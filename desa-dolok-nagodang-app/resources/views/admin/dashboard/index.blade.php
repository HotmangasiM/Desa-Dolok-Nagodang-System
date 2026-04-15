@extends('layouts.admin')

@section('content')
<div class="space-y-6">

    {{-- HEADER --}}
    <div>
        <h1 class="text-3xl font-bold text-slate-800">Dashboard</h1>
        <p class="text-sm text-slate-500 mt-2">
            Ringkasan data sistem informasi desa.
        </p>
    </div>

    {{-- STATISTICS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5">

        {{-- Citizens --}}
        <div class="rounded-2xl bg-white border p-5 shadow-sm">
            <p class="text-sm text-slate-500">Penduduk</p>
            <h3 class="text-3xl font-bold mt-2">{{ $totalCitizens }}</h3>
            <p class="text-xs text-slate-500 mt-2">
                L: {{ $maleCitizens }} | P: {{ $femaleCitizens }}
            </p>
        </div>

        {{-- Officials --}}
        <div class="rounded-2xl bg-white border p-5 shadow-sm">
            <p class="text-sm text-slate-500">Aparat Desa</p>
            <h3 class="text-3xl font-bold mt-2">{{ $totalOfficials }}</h3>
        </div>

        {{-- News --}}
        <div class="rounded-2xl bg-white border p-5 shadow-sm">
            <p class="text-sm text-slate-500">Berita</p>
            <h3 class="text-3xl font-bold mt-2">{{ $totalNews }}</h3>
            <p class="text-xs text-slate-500 mt-2">
                Published: {{ $publishedNews }}
            </p>
        </div>

        {{-- Assets --}}
        <div class="rounded-2xl bg-white border p-5 shadow-sm">
            <p class="text-sm text-slate-500">Inventaris</p>
            <h3 class="text-3xl font-bold mt-2">{{ $totalAssets }}</h3>
            <p class="text-xs text-slate-500 mt-2">
                Good: {{ $goodAssets }}
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-5">

        {{-- CHART SURAT --}}
        <div class="rounded-2xl bg-white border p-5 shadow-sm">
            <h3 class="text-lg font-bold text-slate-800 mb-4">
                Statistik Surat per Bulan
            </h3>
            <canvas id="lettersChart" height="120"></canvas>
        </div>

        {{-- CHART GENDER --}}
        <div class="rounded-2xl bg-white border p-5 shadow-sm">
            <h3 class="text-lg font-bold text-slate-800 mb-4">
                Distribusi Penduduk
            </h3>
            <canvas id="genderChart" height="120"></canvas>
        </div>

    </div>

    {{-- LETTER STATS --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

        <div class="rounded-2xl bg-white border p-5 shadow-sm">
            <p class="text-sm text-slate-500">Total Surat</p>
            <h3 class="text-3xl font-bold mt-2">{{ $totalLetters }}</h3>
        </div>

        <div class="rounded-2xl bg-white border p-5 shadow-sm">
            <p class="text-sm text-slate-500">Submitted</p>
            <h3 class="text-3xl font-bold mt-2">{{ $submittedLetters }}</h3>
        </div>

        <div class="rounded-2xl bg-white border p-5 shadow-sm">
            <p class="text-sm text-slate-500">Approved</p>
            <h3 class="text-3xl font-bold mt-2">{{ $approvedLetters }}</h3>
        </div>
    </div>

    {{-- RECENT LETTERS --}}
    <div class="rounded-2xl bg-white border shadow-sm">
        <div class="px-5 py-4 border-b">
            <h2 class="text-lg font-bold text-slate-800">Surat Terbaru</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-5 py-3 text-left">Nomor</th>
                        <th class="px-5 py-3 text-left">Jenis</th>
                        <th class="px-5 py-3 text-left">Pemohon</th>
                        <th class="px-5 py-3 text-left">Status</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($recentLetters as $letter)
                        <tr class="border-t">
                            <td class="px-5 py-3">{{ $letter->letter_number }}</td>
                            <td class="px-5 py-3">{{ $letter->letterType->name ?? '-' }}</td>
                            <td class="px-5 py-3">{{ $letter->citizen->full_name ?? '-' }}</td>
                            <td class="px-5 py-3">
                                <span class="px-2 py-1 rounded-full text-xs bg-slate-100">
                                    {{ $letter->status }}
                                </span>
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
    // ===== CHART SURAT =====
    const lettersCtx = document.getElementById('lettersChart');

    new Chart(lettersCtx, {
        type: 'line',
        data: {
            labels: @json($monthlyLabels),
            datasets: [{
                label: 'Jumlah Surat',
                data: @json($monthlyData),
                tension: 0.4,
                fill: true,
                borderColor: '#10b981',
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true
                }
            }
        }
    });

    // ===== CHART GENDER =====
    const genderCtx = document.getElementById('genderChart');

    new Chart(genderCtx, {
        type: 'doughnut',
        data: {
            labels: ['Laki-laki', 'Perempuan'],
            datasets: [{
                data: [
                    {{ $genderData['L'] }},
                    {{ $genderData['P'] }}
                ],
                backgroundColor: [
                    '#3b82f6',
                    '#ec4899'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>
@endpush