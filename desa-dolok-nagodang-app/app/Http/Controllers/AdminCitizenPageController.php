<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCitizenRequest;
use App\Http\Requests\UpdateCitizenRequest;
use App\Models\Citizen;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Services\CitizenService;

class AdminCitizenPageController extends Controller
{
    public function __construct(
        protected CitizenService $citizenService
    ){

    }

    public function index(Request $request): View
    {
        $filters = [
            'search' => $request->query('search'),
            'gender' => $request->query('gender'),
            'life_status' => $request->query('life_status'),
        ];

        $perPage = (int) $request->query('per_page', 10);

        $citizens = $this->citizenService->getAll($filters, $perPage);

        $allCitizens = \App\Models\Citizen::query()->count();
        $maleCitizens = \App\Models\Citizen::query()->where('gender', 'L')->count();
        $femaleCitizens = \App\Models\Citizen::query()->where('gender', 'P')->count();
        $activeCitizens = \App\Models\Citizen::query()->where('life_status', 'alive')->count();

        return view('admin.citizens.index', [
            'title' => 'Admin Desa - Data Penduduk',
            'pageTitle' => 'Manajemen Penduduk',
            'pageDescription' => 'Kelola data penduduk untuk kebutuhan administrasi desa.',
            'citizens' => $citizens,
            'allCitizens' => $allCitizens,
            'maleCitizens' => $maleCitizens,
            'femaleCitizens' => $femaleCitizens,
            'activeCitizens' => $activeCitizens,
            'filters' => $filters,
        ]);
    }

    public function create(): View
    {
        return view('admin.citizens.create', [
            'title' => 'Admin Desa - Tambah Penduduk',
            'pageTitle' => 'Tambah Penduduk',
            'pageDescription' => 'Tambahkan data penduduk baru ke dalam sistem.'
        ]);
    }

    public function store(StoreCitizenRequest $request): RedirectResponse
    {
        $this->citizenService->create($request->validated());

        return redirect()
            ->route('admin.citizens.index')
            ->with('success', 'Data penduduk berhasil ditambahkan.');
    }

    public function edit(int $citizen): View
    {
        $citizenData = $this->citizenService->getById($citizen);

        return view('admin.citizens.edit', [
            'title' => 'Admin Desa - Edit Penduduk',
            'pageTitle' => 'Edit Penduduk',
            'pageDescription' => 'Perbarui data penduduk yang sudah terdaftar.',
            'citizen' => $citizenData,
        ]);
    }

    public function update(UpdateCitizenRequest $request, int $citizen): RedirectResponse
    {
        $this->citizenService->update($citizen, $request->validated());

        return redirect()
            ->route('admin.citizens.index')
            ->with('success', 'Data penduduk berhasil diperbaharui.');
    }

    public function destroy(int $citizen)
    {
        $this->citizenService->delete($citizen);

        return redirect()
            ->route('admin.citizens.index')
            ->with('success', 'Data Penduduk berhasil dihapus.');
    }
}
