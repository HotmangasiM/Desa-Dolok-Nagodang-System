@extends('layouts.public')

@section('content')
<section class="bg-emerald-950 text-white">
    <div class="max-w-7xl mx-auto px-4 py-16">
        <a href="{{ route('public.letters') }}"
           class="inline-flex text-sm text-emerald-100 hover:text-white mb-5">
            ← Kembali ke Layanan Surat
        </a>

        <p class="inline-flex rounded-full bg-white/10 px-4 py-2 text-sm text-emerald-100 border border-white/10">
            Kode Surat: {{ $letterType->code }}
        </p>

        <h1 class="mt-6 text-4xl md:text-5xl font-bold leading-tight">
            {{ $letterType->name }}
        </h1>

        <p class="mt-5 max-w-3xl text-emerald-100 leading-7">
            {{ $letterType->description ?: 'Informasi layanan administrasi surat yang dapat diproses melalui kantor desa.' }}
        </p>
    </div>
</section>

<section class="max-w-7xl mx-auto px-4 py-16">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- Persyaratan --}}
        <div class="lg:col-span-2 rounded-3xl bg-white border border-slate-200 p-8 shadow-sm">
            <p class="text-sm font-semibold text-emerald-700">Persyaratan</p>
            <h2 class="mt-1 text-3xl font-bold text-slate-800">
                Dokumen yang Perlu Disiapkan
            </h2>

            <div class="mt-6 space-y-4">
                @foreach ($requirements as $requirement)
                    <div class="flex gap-3">
                        <span class="mt-0.5 inline-flex w-6 h-6 rounded-full bg-emerald-100 text-emerald-700 items-center justify-center text-sm font-bold">
                            ✓
                        </span>
                        <p class="text-slate-600">{{ $requirement }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Info --}}
        <div class="rounded-3xl bg-white border border-slate-200 p-8 shadow-sm">
            <p class="text-sm font-semibold text-emerald-700">Informasi Layanan</p>

            <div class="mt-6 space-y-5">
                <div>
                    <p class="text-sm text-slate-500">Jenis Surat</p>
                    <p class="font-bold text-slate-800">{{ $letterType->name }}</p>
                </div>

                <div>
                    <p class="text-sm text-slate-500">Kode</p>
                    <p class="font-bold text-emerald-700">{{ $letterType->code }}</p>
                </div>

                <div>
                    <p class="text-sm text-slate-500">Lokasi Pengajuan</p>
                    <p class="font-bold text-slate-800">Kantor Desa Dolok Nagodang</p>
                </div>

                <div>
                    <p class="text-sm text-slate-500">Jam Layanan</p>
                    <p class="font-bold text-slate-800">Senin - Jumat, 08.00 - 15.00</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="bg-slate-100/80 py-16">
    <div class="max-w-7xl mx-auto px-4">
        <p class="text-sm font-semibold text-emerald-700">Alur Pengajuan</p>
        <h2 class="mt-1 text-3xl font-bold text-slate-800">
            Cara Mengurus {{ $letterType->name }}
        </h2>

        <div class="mt-8 grid grid-cols-1 md:grid-cols-5 gap-5">
            @foreach ($flowSteps as $index => $step)
                <div class="rounded-3xl bg-white border border-slate-200 p-6 shadow-sm">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-600 text-white flex items-center justify-center font-bold">
                        {{ $index + 1 }}
                    </div>
                    <p class="mt-4 text-sm text-slate-600 leading-6">
                        {{ $step }}
                    </p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="max-w-7xl mx-auto px-4 py-16">
    <div class="rounded-3xl bg-emerald-950 text-white p-8 md:p-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
        <div>
            <h2 class="text-3xl font-bold">Ingin mengajukan surat ini?</h2>
            <p class="mt-3 text-emerald-100">
                Isi formulir pengajuan secara online, lalu petugas desa akan memproses data yang masuk.
            </p>
        </div>

        <div class="flex flex-col sm:flex-row gap-3">
            <!-- <a href="{{ route('public.letters.apply', $letterType->code) }}"
               class="inline-flex justify-center rounded-xl bg-white px-5 py-3 text-sm font-semibold text-emerald-800 hover:bg-emerald-50 transition">
                Ajukan Surat Online
            </a> -->

            @if(config('features.public_letter_submission'))
                <a href="{{ route('public.letters.apply', $letterType->code) }}"
                class="inline-flex justify-center rounded-xl bg-white px-5 py-3 text-sm font-semibold text-emerald-800 hover:bg-emerald-50 transition">
                    Ajukan Surat Online
                </a>
            @else
                <button
                    type="button"
                    class="inline-flex justify-center rounded-xl bg-slate-300 px-5 py-3 text-sm font-semibold text-slate-600 cursor-not-allowed">
                    Pengajuan Online (Segera Hadir)
                </button>
            @endif

            <a href="{{ route('public.letters') }}"
               class="inline-flex justify-center rounded-xl border border-white/30 px-5 py-3 text-sm font-semibold text-white hover:bg-white/10 transition">
                Layanan Lain
            </a>
        </div>
    </div>
</section>
@endsection