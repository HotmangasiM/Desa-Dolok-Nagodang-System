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
        <div class="rounded-2xl bg-white border border-slate-200 p-5 shadow-sm">
            <p class="text-sm text-slate-500">Penduduk</p>
            <h3 class="text-3xl font-bold mt-2 text-slate-800">{{ $totalCitizens }}</h3>
            <p class="text-xs text-slate-500 mt-2">
                L: {{ $maleCitizens }} | P: {{ $femaleCitizens }}
            </p>
        </div>

        {{-- Officials --}}
        <div class="rounded-2xl bg-white border border-slate-200 p-5 shadow-sm">
            <p class="text-sm text-slate-500">Aparat Desa</p>
            <h3 class="text-3xl font-bold mt-2 text-slate-800">{{ $totalOfficials }}</h3>
        </div>

        {{-- News --}}
        <div class="rounded-2xl bg-white border border-slate-200 p-5 shadow-sm">
            <p class="text-sm text-slate-500">Berita</p>
            <h3 class="text-3xl font-bold mt-2 text-slate-800">{{ $totalNews }}</h3>
            <p class="text-xs text-slate-500 mt-2">
                Published: {{ $publishedNews }}
            </p>
        </div>

        {{-- Assets --}}
        <div class="rounded-2xl bg-white border border-slate-200 p-5 shadow-sm">
            <p class="text-sm text-slate-500">Inventaris</p>
            <h3 class="text-3xl font-bold mt-2 text-slate-800">{{ $totalAssets }}</h3>
        </div>

    </div>

    {{-- CARD PER DUSUN --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        @foreach ($dusunStats as $dusun)
        <div class="rounded-2xl bg-white border border-slate-200 p-5 shadow-sm">
            <p class="text-sm text-slate-500">{{ $dusun->dusun }}</p>
            <h3 class="text-3xl font-bold mt-2 text-slate-800">{{ $dusun->total }}</h3>
            <p class="text-xs text-slate-500 mt-2">
                L: {{ $dusun->L }} | P: {{ $dusun->P }}
            </p>
        </div>
        @endforeach
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
            <p class="text-sm text-slate-500">Submitted</p>
            <h3 class="text-3xl font-bold mt-2 text-slate-800">{{ $submittedLetters }}</h3>
        </div>

        <div class="rounded-2xl bg-white border border-slate-200 p-5 shadow-sm">
            <p class="text-sm text-slate-500">Approved</p>
            <h3 class="text-3xl font-bold mt-2 text-slate-800">{{ $approvedLetters }}</h3>
        </div>

    </div>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    // ===== CHART SURAT =====
    new Chart(document.getElementById('lettersChart'), {
        type: 'line',
        data: {
            labels: @json($monthlyLabels),
            datasets: [{
                label: 'Jumlah Surat',
                data: @json($monthlyData),
                borderColor: '#10b981',
                backgroundColor: 'rgba(16,185,129,0.1)',
                fill: true,
                tension: 0.4
            }]
        }
    });

    // ===== CHART GENDER =====
    new Chart(document.getElementById('genderChart'), {
        type: 'doughnut',
        data: {
            labels: ['Laki-laki', 'Perempuan'],
            datasets: [{
                data: [
                    {{ $genderData['L'] ?? 0 }},
                    {{ $genderData['P'] ?? 0 }}
                ],
                backgroundColor: ['#3b82f6','#ec4899']
            }]
        }
    });

    // ===== CHART DUSUN =====
    const dusunData = @json($dusunStats);

    new Chart(document.getElementById('dusunChart'), {
        type: 'bar',
        data: {
            labels: dusunData.map(d => d.dusun),
            datasets: [{
                label: 'Total Penduduk',
                data: dusunData.map(d => d.total),
                backgroundColor: '#10b981'
            }]
        }
    });

});
</script>
@endpush