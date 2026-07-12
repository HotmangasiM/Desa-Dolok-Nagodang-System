<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAssetRequest;
use App\Http\Requests\UpdateAssetRequest;
use App\Models\Asset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminAssetPageController extends Controller
{
    public function index(Request $request): View
    {
        $filters = [
            'search' => trim((string) $request->query('search')),
            'condition' => $request->query('condition'),
            'category' => trim((string) $request->query('category')),
        ];

        $assets = Asset::query()
            ->when($filters['search'], function ($query) use ($filters) {
                $query->where(function ($q) use ($filters) {
                    $q->where('item_name', 'like', '%' . $filters['search'] . '%')
                        ->orWhere('item_code', 'like', '%' . $filters['search'] . '%')
                        ->orWhere('category', 'like', '%' . $filters['search'] . '%')
                        ->orWhere('location', 'like', '%' . $filters['search'] . '%');
                });
            })
            ->when($filters['condition'], function ($query) use ($filters) {
                $query->where('condition', $filters['condition']);
            })
            ->when($filters['category'], function ($query) use ($filters) {
                $query->where('category', 'like', '%' . $filters['category'] . '%');
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $allAssets = Asset::count();
        $goodAssets = Asset::where('condition', 'good')->count();
        $damagedAssets = Asset::where('condition', 'damaged')->count();

        return view('admin.assets.index', [
            'title' => 'Admin Desa - Inventaris Desa',
            'pageTitle' => 'Inventaris Desa',
            'pageDescription' => 'Kelola data inventaris dan aset desa.',
            'breadcrumbs' => [
                ['label' => 'Inventaris Desa', 'url' => null],
            ],

            'assets' => $assets,
            'filters' => $filters,

            // statistik untuk card di blade
            'allAssets' => $allAssets,
            'goodAssets' => $goodAssets,
            'damagedAssets' => $damagedAssets,
        ]);
    }

    public function create(): View
    {
        return view('admin.assets.create', [
            'title' => 'Admin Desa - Tambah Inventaris',
            'pageTitle' => 'Tambah Inventaris',
            'pageDescription' => 'Tambahkan data inventaris baru ke dalam sistem.',
            'breadcrumbs' => [
                ['label' => 'Inventaris Desa', 'url' => route('admin.assets.index')],
                ['label' => 'Tambah Inventaris', 'url' => null],
            ],
        ]);
    }

    public function store(StoreAssetRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('asset_photo')) {
            $path = $request->file('asset_photo')->store('assets', 'public');
            $data['asset_photo'] = $path;
        }

        Asset::create($data);

        return redirect()
            ->route('admin.assets.index')
            ->with('success', 'Data inventaris berhasil ditambahkan.');
    }

    public function edit(Asset $asset): View
    {
        return view('admin.assets.edit', [
            'title' => 'Admin Desa - Edit Inventaris',
            'pageTitle' => 'Edit Inventaris',
            'pageDescription' => 'Perbarui data inventaris yang sudah tersimpan.',
            'breadcrumbs' => [
                ['label' => 'Inventaris Desa', 'url' => route('admin.assets.index')],
                ['label' => 'Edit Inventaris', 'url' => null],
            ],
            'asset' => $asset,
        ]);
    }

    public function update(UpdateAssetRequest $request, Asset $asset): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('asset_photo')) {
            $path = $request->file('asset_photo')->store('assets', 'public');
            $data['asset_photo'] = $path;
        }

        $asset->update($data);

        return redirect()
            ->route('admin.assets.index')
            ->with('success', 'Data inventaris berhasil diperbarui.');
    }

    public function destroy(Asset $asset): RedirectResponse
    {
        $asset->delete();

        return redirect()
            ->route('admin.assets.index')
            ->with('success', 'Data inventaris berhasil dihapus.');
    }
}
