<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCitizenRequest;
use App\Http\Requests\UpdateCitizenRequest;
use App\Models\Citizen;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminCitizenPageController extends Controller
{
    public function index(Request $request): View
    {
        $filters = [
            'search' => trim((string) $request->query('search')),
            'gender' => $request->query('gender'),
            'life_status' => $request->query('life_status'),
        ];

        $citizens = Citizen::query()
            ->when($filters['search'], function ($query) use ($filters) {
                $query->where(function ($q) use ($filters) {
                    $q->where('full_name', 'like', '%' . $filters['search'] . '%')
                        ->orWhere('nik', 'like', '%' . $filters['search'] . '%')
                        ->orWhere('address', 'like', '%' . $filters['search'] . '%');
                });
            })
            ->when($filters['gender'], function ($query) use ($filters) {
                $query->where('gender', $filters['gender']);
            })
            ->when($filters['life_status'], function ($query) use ($filters) {
                $query->where('life_status', $filters['life_status']);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        // =============================
        // 📊 STATISTIK UMUM
        // =============================
        $allCitizens = Citizen::count();
        $maleCitizens = Citizen::where('gender', 'Laki-laki')->count();
        $femaleCitizens = Citizen::where('gender', 'Perempuan')->count();
        $activeCitizens = Citizen::where('life_status', 'alive')->count();
        $maleCitizenPercentage = $allCitizens > 0 ? round(($maleCitizens / $allCitizens) * 100, 1) : 0;
        $femaleCitizenPercentage = $allCitizens > 0 ? round(($femaleCitizens / $allCitizens) * 100, 1) : 0;

        $dusunStats = Citizen::query()
            ->whereNotNull('address')
            ->pluck('address')
            ->map(function (string $address): string {
                return str($address)->squish()->explode(' ')->take(2)->implode(' ');
            })
            ->filter()
            ->countBy()
            ->sortKeys()
            ->map(fn (int $total, string $dusun): object => (object) [
                'dusun' => $dusun,
                'total' => $total,
            ])
            ->values();

        return view('admin.citizens.index', [
            'title' => 'Admin Desa - Data Penduduk',
            'pageTitle' => 'Data Penduduk',
            'pageDescription' => 'Kelola data penduduk desa secara terpusat.',
            'breadcrumbs' => [
                ['label' => 'Data Penduduk', 'url' => null],
            ],

            'citizens' => $citizens,
            'filters' => $filters,

            // statistik utama
            'allCitizens' => $allCitizens,
            'maleCitizens' => $maleCitizens,
            'femaleCitizens' => $femaleCitizens,
            'activeCitizens' => $activeCitizens,
            'maleCitizenPercentage' => $maleCitizenPercentage,
            'femaleCitizenPercentage' => $femaleCitizenPercentage,

            // 🔥 tambahan
            'dusunStats' => $dusunStats,

            // legacy
            'totalCitizens' => $allCitizens,
        ]);
    }

    public function create(): View
    {
        return view('admin.citizens.create', [
            'title' => 'Admin Desa - Tambah Penduduk',
            'pageTitle' => 'Tambah Penduduk',
            'pageDescription' => 'Tambahkan data penduduk baru ke dalam sistem.',
            'breadcrumbs' => [
                ['label' => 'Data Penduduk', 'url' => route('admin.citizens.index')],
                ['label' => 'Tambah Penduduk', 'url' => null],
            ],
        ]);
    }

    public function store(StoreCitizenRequest $request): RedirectResponse
    {
        Citizen::create($request->validated());

        return redirect()
            ->route('admin.citizens.index')
            ->with('success', 'Data penduduk berhasil ditambahkan.');
    }

    public function edit(Citizen $citizen): View
    {
        return view('admin.citizens.edit', [
            'title' => 'Admin Desa - Edit Penduduk',
            'pageTitle' => 'Edit Penduduk',
            'pageDescription' => 'Perbarui data penduduk yang sudah tersimpan.',
            'breadcrumbs' => [
                ['label' => 'Data Penduduk', 'url' => route('admin.citizens.index')],
                ['label' => 'Edit Penduduk', 'url' => null],
            ],
            'citizen' => $citizen,
        ]);
    }

    public function update(UpdateCitizenRequest $request, Citizen $citizen): RedirectResponse
    {
        $citizen->update($request->validated());

        return redirect()
            ->route('admin.citizens.index')
            ->with('success', 'Data penduduk berhasil diperbarui.');
    }

    public function destroy(Citizen $citizen): RedirectResponse
    {
        $citizen->delete();

        return redirect()
            ->route('admin.citizens.index')
            ->with('success', 'Data penduduk berhasil dihapus.');
    }
}
