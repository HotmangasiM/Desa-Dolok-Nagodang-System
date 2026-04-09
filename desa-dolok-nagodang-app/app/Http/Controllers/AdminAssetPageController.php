<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAssetRequest;
use App\Http\Requests\UpdateAssetRequest;
use App\Models\Asset;
use App\Services\AssetService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminAssetPageController extends Controller
{
    public function __construct(
        protected AssetService $assetService
    ) {
    }

    /**
     * LIST PAGE
     */
    public function index(Request $request): View
    {
        $filters = [
            'search' => $request->query('search'),
            'condition' => $request->query('condition'),
            'category' => $request->query('category'),
        ];

        $perPage = (int) $request->query('per_page', 10);

        $assets = $this->assetService->getAll($filters, $perPage);

        // Statistik
        $allAssets = Asset::count();
        $goodAssets = Asset::where('condition', 'good')->count();
        $damagedAssets = Asset::where('condition', 'damaged')->count();

        return view('admin.assets.index', [
            'title' => 'Admin Desa - Inventaris Desa',
            'pageTitle' => 'Manajemen Inventaris Desa',
            'pageDescription' => 'Kelola data aset dan inventaris desa.',
            'assets' => $assets,
            'allAssets' => $allAssets,
            'goodAssets' => $goodAssets,
            'damagedAssets' => $damagedAssets,
            'filters' => $filters,
        ]);
    }

    /**
     * CREATE PAGE
     */
    public function create(): View
    {
        return view('admin.assets.create', [
            'title' => 'Admin Desa - Tambah Inventaris',
            'pageTitle' => 'Tambah Inventaris Desa',
            'pageDescription' => 'Tambahkan data aset inventaris desa.',
        ]);
    }

    /**
     * STORE DATA
     */
    public function store(StoreAssetRequest $request): RedirectResponse
    {
        $this->assetService->create($request->validated());

        return redirect()
            ->route('admin.assets.index')
            ->with('success', 'Data inventaris berhasil ditambahkan.');
    }

    /**
     * EDIT PAGE
     */
    public function edit(int $asset): View
    {
        $assetData = $this->assetService->getById($asset);

        return view('admin.assets.edit', [
            'title' => 'Admin Desa - Edit Inventaris',
            'pageTitle' => 'Edit Inventaris Desa',
            'pageDescription' => 'Perbarui data aset inventaris desa.',
            'asset' => $assetData,
        ]);
    }

    /**
     * UPDATE DATA
     */
    public function update(UpdateAssetRequest $request, int $asset): RedirectResponse
    {
        $this->assetService->update($asset, $request->validated());

        return redirect()
            ->route('admin.assets.index')
            ->with('success', 'Data inventaris berhasil diperbarui.');
    }

    /**
     * DELETE (SOFT DELETE)
     */
    public function destroy(int $asset): RedirectResponse
    {
        $this->assetService->delete($asset);

        return redirect()
            ->route('admin.assets.index')
            ->with('success', 'Data inventaris berhasil dihapus.');
    }
}