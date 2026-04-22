<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOfficialRequest;
use App\Http\Requests\UpdateOfficialRequest;
use App\Models\Official;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminOfficialPageController extends Controller
{
    public function index(Request $request): View
    {
        $filters = [
            'search' => $request->query('search'),
            'position' => $request->query('position'),
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
                $query->where('position', $filters['position']);
            })
            ->latest()
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
        ]);
    }

    public function store(StoreOfficialRequest $request): RedirectResponse
    {
        $data = $request->validated();

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
        ]);
    }

    public function update(UpdateOfficialRequest $request, Official $official): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('officials', 'public');
            $data['photo'] = $path;
        }

        $official->update($data);

        return redirect()
            ->route('admin.officials.index')
            ->with('success', 'Data aparat desa berhasil diperbarui.');
    }

    public function destroy(Official $official): RedirectResponse
    {
        $official->delete();

        return redirect()
            ->route('admin.officials.index')
            ->with('success', 'Data aparat desa berhasil dihapus.');
    }
}