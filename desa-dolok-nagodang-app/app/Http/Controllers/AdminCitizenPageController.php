<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
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

    public function destroy(int $citizen)
    {
        $this->citizenService->delete($citizen);

        return redirect()
            ->route('admin.citizens.index')
            ->with('success', 'Data Penduduk berhasil dihapus.');
    }
}
