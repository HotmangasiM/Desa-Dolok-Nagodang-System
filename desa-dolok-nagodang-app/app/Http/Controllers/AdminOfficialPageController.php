<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOfficialRequest;
use App\Http\Requests\UpdateOfficialRequest;
use App\Models\Official;
use App\Services\OfficialService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminOfficialPageController extends Controller
{
    public function __construct(
        protected OfficialService $officialService
    ) {
    }

    public function index(Request $request): View
    {
        $filters = [
            'search' => $request->query('search'),
            'position' => $request->query('position'),
        ];

        $perPage = (int) $request->query('per_page', 10);

        $officials = $this->officialService->getAll($filters, $perPage);

        $allOfficials = Official::count();
        $officialWithPosition = Official::whereNotNull('position')->count();
        $officialWithPhone = Official::whereNotNull('phone')->count();

        return view('admin.officials.index', [
            'title' => 'Admin Desa - Aparat Desa',
            'pageTitle' => 'Manajemen Aparat Desa',
            'pageDescription' => 'Kelola profil aparat desa dan struktur jabatan.',
            'officials' => $officials,
            'allOfficials' => $allOfficials,
            'officialWithPosition' => $officialWithPosition,
            'officialWithPhone' => $officialWithPhone,
            'filters' => $filters,
        ]);
    }

    public function create(): View
    {
        return view('admin.officials.create', [
            'title' => 'Admin Desa - Tambah Aparat',
            'pageTitle' => 'Tambah Aparat Desa',
            'pageDescription' => 'Tambahkan profil aparat desa baru.',
        ]);
    }

    public function store(StoreOfficialRequest $request): RedirectResponse
    {
        $this->officialService->create($request->validated());

        return redirect()
            ->route('admin.officials.index')
            ->with('success', 'Data aparat desa berhasil ditambahkan.');
    }

    public function edit(int $official): View
    {
        $officialData = $this->officialService->getById($official);

        return view('admin.officials.edit', [
            'title' => 'Admin Desa - Edit Aparat',
            'pageTitle' => 'Edit Aparat Desa',
            'pageDescription' => 'Perbarui profil aparat desa.',
            'official' => $officialData,
        ]);
    }

    public function update(UpdateOfficialRequest $request, int $official): RedirectResponse
    {
        $this->officialService->update($official, $request->validated());

        return redirect()
            ->route('admin.officials.index')
            ->with('success', 'Data aparat desa berhasil diperbarui.');
    }

    public function destroy(int $official): RedirectResponse
    {
        $this->officialService->delete($official);

        return redirect()
            ->route('admin.officials.index')
            ->with('success', 'Data aparat desa berhasil dihapus.');
    }
}