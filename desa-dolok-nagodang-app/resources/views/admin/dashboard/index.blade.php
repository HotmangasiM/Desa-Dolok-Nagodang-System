@extends('layouts.admin')

@section('content')
<div class="space-y-6">

    {{-- STATISTICS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5">

        {{-- Citizens --}}
        <div class="rounded-2xl bg-white border border-slate-200 p-5 shadow-sm">
            <p class="text-sm text-slate-500">Penduduk</p>
            <h3 class="text-3xl font-bold mt-2 text-slate-800">{{ $totalCitizens }}</h3>
            <p class="text-xs text-slate-500 mt-2">
                Laki-laki: {{ $maleCitizens }} | Perempuan: {{ $femaleCitizens }}
            </p>
        </div>

        {{-- Officials --}}
        <div class="rounded-2xl bg-white border border-slate-200 p-5 shadow-sm">
            <p class="text-sm text-slate-500">Aparat Desa</p>
            <h3 class="text-3xl font-bold mt-2 text-slate-800">{{ $totalOfficials }}</h3>
            <p class="text-xs text-slate-500 mt-2">
                Total aparat aktif di sistem
            </p>
        </div>

        {{-- News --}}
        <div class="rounded-2xl bg-white border border-slate-200 p-5 shadow-sm">
            <p class="text-sm text-slate-500">Berita</p>
            <h3 class="text-3xl font-bold mt-2 text-slate-800">{{ $totalNews }}</h3>
            <p class="text-xs text-slate-500 mt-2">
                Dipublikasikan: {{ $publishedNews }}
            </p>
        </div>

        {{-- Assets --}}
        <div class="rounded-2xl bg-white border border-slate-200 p-5 shadow-sm">
            <p class="text-sm text-slate-500">Inventaris</p>
            <h3 class="text-3xl font-bold mt-2 text-slate-800">{{ $totalAssets }}</h3>
            <p class="text-xs text-slate-500 mt-2">
                Kondisi baik: {{ $goodAssets }}
            </p>
        </div>
    </div>

    {{-- CHARTS --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-5">

        {{-- CHART SURAT --}}
        <div class="rounded-2xl bg-white border border-slate-200 p-5 shadow-sm">
            <h3 class="text-lg font-bold text-slate-800 mb-4">
                Statistik Surat per Bulan
            </h3>
            <div class="relative h-[320px]">
                <canvas id="lettersChart"></canvas>
            </div>
        </div>

        {{-- CHART GENDER --}}
        <div class="rounded-2xl bg-white border border-slate-200 p-5 shadow-sm">
            <h3 class="text-lg font-bold text-slate-800 mb-4">
                Distribusi Penduduk
            </h3>
            <div class="relative h-[320px]">
                <canvas id="genderChart"></canvas>
            </div>
        </div>

        {{-- CHART DUSUN --}}
        <div class="rounded-2xl bg-white border border-slate-200 p-5 shadow-sm">
            <h3 class="text-lg font-bold text-slate-800 mb-4">
                Penduduk per Dusun
            </h3>
            <div class="relative h-[320px]">
                <canvas id="dusunChart"></canvas>
            </div>
        </div>

    </div>

    {{-- LETTER STATS --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

        <div class="rounded-2xl bg-white border border-slate-200 p-5 shadow-sm">
            <p class="text-sm text-slate-500">Total Surat</p>
            <h3 class="text-3xl font-bold mt-2 text-slate-800">{{ $totalLetters }}</h3>
        </div>

        <div class="rounded-2xl bg-white border border-slate-200 p-5 shadow-sm">
            <p class="text-sm text-slate-500">Diajukan</p>
            <h3 class="text-3xl font-bold mt-2 text-slate-800">{{ $submittedLetters }}</h3>
        </div>

        <div class="rounded-2xl bg-white border border-slate-200 p-5 shadow-sm">
            <p class="text-sm text-slate-500">Selesai</p>
            <h3 class="text-3xl font-bold mt-2 text-slate-800">{{ $completedLetters }}</h3>
        </div>
    </div>

    {{-- RECENT LETTERS --}}
    <div class="rounded-2xl bg-white border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-200">
            <h2 class="text-lg font-bold text-slate-800">Surat Terbaru</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-5 py-3 text-left font-semibold text-slate-600">Nomor</th>
                        <th class="px-5 py-3 text-left font-semibold text-slate-600">Jenis</th>
                        <th class="px-5 py-3 text-left font-semibold text-slate-600">Pemohon</th>
                        <th class="px-5 py-3 text-left font-semibold text-slate-600">Status</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($recentLetters as $letter)
                        <tr class="border-t border-slate-100 hover:bg-slate-50 transition">
                            <td class="px-5 py-3 text-slate-700">
                                {{ $letter->letter_number }}
                            </td>
                            <td class="px-5 py-3 text-slate-700">
                                {{ optional($letter->letterType)->name ?? '-' }}
                            </td>
                            <td class="px-5 py-3 text-slate-700">
                                {{ optional($letter->citizen)->full_name ?? '-' }}
                            </td>
                            <td class="px-5 py-3">
                                @if ($letter->status === 'COMPLETED')
                                    <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">
                                        Selesai
                                    </span>
                                @elseif ($letter->status === 'SUBMITTED')
                                    <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-700">
                                        Diajukan
                                    </span>
                                @elseif ($letter->status === 'PROCESSING')
                                    <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-medium bg-sky-100 text-sky-700">
                                        Diproses
                                    </span>
                                @else
                                    <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-700">
                                        {{ strtolower($letter->status ?? '-') }}
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-slate-500">
                                Belum ada data surat
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // ===== CHART SURAT =====
        const lettersCtx = document.getElementById('lettersChart');

        if (lettersCtx) {
            new Chart(lettersCtx, {
                type: 'bar',
                data: {
                    labels: @json($monthlyLabels ?? []),
                    datasets: [{
                        label: 'Jumlah Surat',
                        data: @json($monthlyData ?? []),
                        backgroundColor: 'rgba(16, 185, 129, 0.75)',
                        borderColor: '#10b981',
                        borderWidth: 1,
                        borderRadius: 8,
                        maxBarThickness: 42
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0,
                                stepSize: 1
                            },
                            grid: {
                                color: 'rgba(148, 163, 184, 0.15)'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        }

        // ===== CHART GENDER =====
        const genderCtx = document.getElementById('genderChart');

        if (genderCtx) {
            new Chart(genderCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Laki-laki', 'Perempuan'],
                    datasets: [{
                        data: [
                            {{ $maleCitizens ?? 0 }},
                            {{ $femaleCitizens ?? 0 }}
                        ],
                        backgroundColor: [
                            '#3b82f6',
                            '#ec4899'
                        ],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '65%',
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        }

        // ===== CHART DUSUN =====
        const dusunCtx = document.getElementById('dusunChart');

        if (dusunCtx) {
            new Chart(dusunCtx, {
                type: 'bar',
                data: {
                    labels: @json($dusunLabels ?? []),
                    datasets: [{
                        label: 'Jumlah Penduduk',
                        data: @json($dusunData ?? []),
                        backgroundColor: 'rgba(139, 92, 246, 0.7)',
                        borderColor: '#8b5cf6',
                        borderWidth: 1,
                        borderRadius: 8,
                        maxBarThickness: 40
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0,
                                stepSize: 1
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        }
    });
</script>
@endpush
