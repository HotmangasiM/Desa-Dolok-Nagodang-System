<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOfficialRequest;
use App\Http\Requests\UpdateOfficialRequest;
use App\Models\Official;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AdminOfficialPageController extends Controller
{
    protected function nextSortOrder(): int
    {
        $this->normalizeSortOrders();

        $maxSortOrder = (int) Official::max('sort_order');

        return $maxSortOrder > 0 ? $maxSortOrder + 1 : 1;
    }

    protected function displayOrderGuide(?Official $ignoreOfficial = null)
    {
        return Official::query()
            ->when($ignoreOfficial, fn ($query) => $query->whereKeyNot($ignoreOfficial->id))
            ->orderedForDisplay()
            ->limit(5)
            ->get(['id', 'name', 'position', 'sort_order']);
    }

    public function index(Request $request): View
    {
        $this->normalizeSortOrders();

        $filters = [
            'search' => trim((string) $request->query('search')),
            'position' => trim((string) $request->query('position')),
        ];

        $officials = Official::query()
            ->when($filters['search'], function ($query) use ($filters) {
                $query->where(function ($q) use ($filters) {
                    $q->where('name', 'like', '%' . $filters['search'] . '%')
                        ->orWhere('position', 'like', '%' . $filters['search'] . '%')
                        ->orWhere('phone', 'like', '%' . $filters['search'] . '%')
                        ->orWhere('email', 'like', '%' . $filters['search'] . '%');
                });
            })
            ->when($filters['position'], function ($query) use ($filters) {
                $query->where('position', 'like', '%' . $filters['position'] . '%');
            })
            ->orderedForDisplay()
            ->paginate(10)
            ->withQueryString();

        $allOfficials = Official::count();
        $officialWithPosition = Official::whereNotNull('position')->count();
        $officialWithPhone = Official::whereNotNull('phone')->count();

        return view('admin.officials.index', [
            'title' => 'Admin Desa - Aparat Desa',
            'pageTitle' => 'Aparat Desa',
            'pageDescription' => 'Kelola profil aparat desa dan struktur jabatan.',
            'breadcrumbs' => [
                ['label' => 'Aparat Desa', 'url' => null],
            ],

            'officials' => $officials,
            'filters' => $filters,

            // statistik untuk card di blade
            'allOfficials' => $allOfficials,
            'officialWithPosition' => $officialWithPosition,
            'officialWithPhone' => $officialWithPhone,
        ]);
    }

    public function create(): View
    {
        return view('admin.officials.create', [
            'title' => 'Admin Desa - Tambah Aparat Desa',
            'pageTitle' => 'Tambah Aparat Desa',
            'pageDescription' => 'Tambahkan profil aparat desa baru.',
            'breadcrumbs' => [
                ['label' => 'Aparat Desa', 'url' => route('admin.officials.index')],
                ['label' => 'Tambah Aparat Desa', 'url' => null],
            ],
            'nextSortOrder' => $this->nextSortOrder(),
            'displayOrderGuide' => $this->displayOrderGuide(),
        ]);
    }

    public function store(StoreOfficialRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $this->normalizeSortOrders();

        $data['sort_order'] = $this->nextSortOrder();

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('officials', 'public');
            $data['photo'] = $path;
        }

        Official::create($data);

        return redirect()
            ->route('admin.officials.index')
            ->with('success', 'Data aparat desa berhasil ditambahkan.');
    }

    public function edit(Official $official): View
    {
        return view('admin.officials.edit', [
            'title' => 'Admin Desa - Edit Aparat Desa',
            'pageTitle' => 'Edit Aparat Desa',
            'pageDescription' => 'Perbarui profil aparat desa yang sudah tersimpan.',
            'breadcrumbs' => [
                ['label' => 'Aparat Desa', 'url' => route('admin.officials.index')],
                ['label' => 'Edit Aparat Desa', 'url' => null],
            ],
            'official' => $official,
            'nextSortOrder' => $this->nextSortOrder(),
            'displayOrderGuide' => $this->displayOrderGuide($official),
        ]);
    }

    public function update(UpdateOfficialRequest $request, Official $official): RedirectResponse
    {
        $data = $request->validated();

        unset($data['sort_order']);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('officials', 'public');
            $data['photo'] = $path;
        }

        $official->update($data);

        return redirect()
            ->route('admin.officials.index')
            ->with('success', 'Data aparat desa berhasil diperbarui.');
    }

    public function reorder(Request $request, Official $official): RedirectResponse
    {
        $direction = $request->input('direction');

        if (!in_array($direction, ['up', 'down'], true)) {
            return redirect()
                ->route('admin.officials.index')
                ->with('success', 'Arah perpindahan urutan tidak valid.');
        }

        DB::transaction(function () use ($official, $direction) {
            $this->normalizeSortOrders();

            $orderedOfficials = Official::orderedForDisplay()->get(['id', 'sort_order']);
            $currentIndex = $orderedOfficials->search(fn ($item) => (int) $item->id === (int) $official->id);

            if ($currentIndex === false) {
                return;
            }

            $swapIndex = $direction === 'up' ? $currentIndex - 1 : $currentIndex + 1;

            if (!isset($orderedOfficials[$swapIndex])) {
                return;
            }

            $currentOfficial = Official::find($official->id);
            $swapOfficial = Official::find($orderedOfficials[$swapIndex]->id);

            if (!$currentOfficial || !$swapOfficial) {
                return;
            }

            $currentSortOrder = (int) $currentOfficial->sort_order;
            $swapSortOrder = (int) $swapOfficial->sort_order;

            $currentOfficial->update(['sort_order' => $swapSortOrder]);
            $swapOfficial->update(['sort_order' => $currentSortOrder]);
        });

        return redirect()
            ->route('admin.officials.index')
            ->with('success', 'Urutan tampil aparat berhasil diperbarui.');
    }

    public function destroy(Official $official): RedirectResponse
    {
        $official->delete();

        return redirect()
            ->route('admin.officials.index')
            ->with('success', 'Data aparat desa berhasil dihapus.');
    }

    protected function normalizeSortOrders(): void
    {
        $officials = Official::orderedForDisplay()->get(['id']);

        foreach ($officials as $index => $official) {
            $expectedOrder = $index + 1;

            Official::whereKey($official->id)->update([
                'sort_order' => $expectedOrder,
            ]);
        }
    }
}
