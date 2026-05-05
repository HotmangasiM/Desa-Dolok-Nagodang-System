@extends('layouts.public')

@section('content')
{{-- HERO --}}
<section class="bg-emerald-950 text-white">
    <div class="max-w-7xl mx-auto px-4 py-16">
        <div class="max-w-3xl">
            <p class="inline-flex rounded-full bg-white/10 px-4 py-2 text-sm text-emerald-100 border border-white/10">
                Pelayanan Administrasi Desa
            </p>

            <h1 class="mt-6 text-4xl md:text-5xl font-bold leading-tight">
                Layanan Surat Desa
            </h1>

            <p class="mt-5 text-emerald-100 leading-7">
                Informasi jenis surat yang dapat diproses melalui Pemerintah Desa Dolok Nagodang.
                Warga dapat menyiapkan dokumen yang diperlukan sebelum datang ke kantor desa.
            </p>
        </div>
    </div>
</section>

{{-- SUMMARY --}}
<section class="max-w-7xl mx-auto px-4 -mt-8 relative z-10">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <div class="rounded-3xl bg-white border border-slate-200 p-6 shadow-sm">
            <div class="w-12 h-12 rounded-2xl bg-emerald-100 flex items-center justify-center text-2xl">📄</div>
            <p class="mt-4 text-sm text-slate-500">Jenis Layanan</p>
            <h3 class="mt-1 text-3xl font-bold text-slate-800">{{ number_format($letterTypes->count()) }}</h3>
        </div>

        <div class="rounded-3xl bg-white border border-slate-200 p-6 shadow-sm">
            <div class="w-12 h-12 rounded-2xl bg-sky-100 flex items-center justify-center text-2xl">🏢</div>
            <p class="mt-4 text-sm text-slate-500">Lokasi Pengajuan</p>
            <h3 class="mt-1 text-xl font-bold text-slate-800">Kantor Desa</h3>
        </div>

        <div class="rounded-3xl bg-white border border-slate-200 p-6 shadow-sm">
            <div class="w-12 h-12 rounded-2xl bg-amber-100 flex items-center justify-center text-2xl">⏱️</div>
            <p class="mt-4 text-sm text-slate-500">Jam Layanan</p>
            <h3 class="mt-1 text-xl font-bold text-slate-800">Senin - Jumat</h3>
        </div>
    </div>
</section>

{{-- ALUR --}}
<section class="max-w-7xl mx-auto px-4 py-16">
    <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4">
        <div>
            <p class="text-sm font-semibold text-emerald-700">Alur Pelayanan</p>
            <h2 class="mt-1 text-3xl font-bold text-slate-800">Cara Mengurus Surat</h2>
            <p class="mt-2 text-slate-500">Ikuti alur berikut agar proses administrasi berjalan lebih mudah.</p>
        </div>
    </div>

    <div class="mt-8 grid grid-cols-1 md:grid-cols-4 gap-5">
        @php
            $steps = [
                ['title' => 'Pilih Jenis Surat', 'desc' => 'Warga menentukan jenis surat sesuai kebutuhan.', 'icon' => '1'],
                ['title' => 'Siapkan Dokumen', 'desc' => 'Siapkan KTP/KK dan dokumen pendukung lainnya.', 'icon' => '2'],
                ['title' => 'Datang ke Kantor Desa', 'desc' => 'Petugas desa akan melakukan verifikasi data.', 'icon' => '3'],
                ['title' => 'Surat Diproses', 'desc' => 'Surat dibuat dan dapat diambil setelah selesai.', 'icon' => '4'],
            ];
        @endphp

        @foreach ($steps as $step)
            <div class="rounded-3xl bg-white border border-slate-200 p-6 shadow-sm">
                <div class="w-12 h-12 rounded-2xl bg-emerald-600 text-white flex items-center justify-center font-bold">
                    {{ $step['icon'] }}
                </div>
                <h3 class="mt-4 font-bold text-slate-800">{{ $step['title'] }}</h3>
                <p class="mt-2 text-sm text-slate-500 leading-6">{{ $step['desc'] }}</p>
            </div>
        @endforeach
    </div>
</section>

{{-- DAFTAR SURAT --}}
<section class="bg-slate-100/80 py-16">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4">
            <div>
                <p class="text-sm font-semibold text-emerald-700">Jenis Surat</p>
                <h2 class="mt-1 text-3xl font-bold text-slate-800">Layanan yang Tersedia</h2>
                <p class="mt-2 text-slate-500">Daftar jenis surat yang dapat diproses oleh Pemerintah Desa.</p>
            </div>
        </div>

        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse ($letterTypes as $type)
                <div class="rounded-3xl bg-white border border-slate-200 p-6 shadow-sm hover:shadow-md transition">
                    <div class="w-14 h-14 rounded-2xl bg-emerald-100 flex items-center justify-center text-3xl">
                        📄
                    </div>

                    <h3 class="mt-4 text-lg font-bold text-slate-800">
                        {{ $type->name }}
                    </h3>

                    <p class="mt-2 text-sm text-slate-500 leading-6">
                        {{ $type->description ?: 'Layanan administrasi surat yang dapat diproses melalui kantor desa.' }}
                    </p>

                    <div class="mt-5 rounded-2xl bg-slate-50 border border-slate-200 p-4">
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Kode Surat</p>
                        <p class="mt-1 font-bold text-emerald-700">{{ $type->code }}</p>
                    </div>

                    <a href="{{ route('public.letters.show', $type->code) }}"
                        class="mt-5 inline-flex rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-emerald-700 transition">
                            Lihat Detail
                    </a>
                </div>
            @empty
                <div class="md:col-span-3 rounded-2xl bg-white border border-slate-200 p-10 text-center text-slate-500">
                    Layanan surat belum tersedia.
                </div>
            @endforelse
        </div>
    </div>
</section>

{{-- PERSYARATAN --}}
<section class="max-w-7xl mx-auto px-4 py-16">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="rounded-3xl bg-white border border-slate-200 p-8 shadow-sm">
            <p class="text-sm font-semibold text-emerald-700">Persyaratan Umum</p>
            <h2 class="mt-1 text-3xl font-bold text-slate-800">Dokumen yang Perlu Disiapkan</h2>

            <div class="mt-6 space-y-4">
                <div class="flex gap-3">
                    <span class="text-emerald-600 font-bold">✓</span>
                    <p class="text-slate-600">Kartu Tanda Penduduk atau NIK pemohon.</p>
                </div>
                <div class="flex gap-3">
                    <span class="text-emerald-600 font-bold">✓</span>
                    <p class="text-slate-600">Kartu Keluarga jika diperlukan.</p>
                </div>
                <div class="flex gap-3">
                    <span class="text-emerald-600 font-bold">✓</span>
                    <p class="text-slate-600">Dokumen pendukung sesuai jenis surat.</p>
                </div>
                <div class="flex gap-3">
                    <span class="text-emerald-600 font-bold">✓</span>
                    <p class="text-slate-600">Datang ke kantor desa pada jam pelayanan.</p>
                </div>
            </div>
        </div>

        <div class="rounded-3xl bg-emerald-950 text-white p-8 shadow-sm">
            <p class="text-sm font-semibold text-emerald-200">Butuh Bantuan?</p>
            <h2 class="mt-1 text-3xl font-bold">Hubungi Kantor Desa</h2>

            <p class="mt-4 text-emerald-100 leading-7">
                Jika warga membutuhkan informasi lebih lanjut terkait layanan surat,
                silakan menghubungi atau datang langsung ke Kantor Desa Dolok Nagodang.
            </p>

            <div class="mt-6 space-y-3 text-sm text-emerald-100">
                <p>📍 Desa Dolok Nagodang, Kec. Uluan, Kab. Toba</p>
                <p>🕘 Senin - Jumat, 08.00 - 15.00</p>
                <p>📞 08xxxxxxxxxx</p>
            </div>

            <a href="{{ route('public.home') }}"
               class="mt-8 inline-flex rounded-xl bg-white px-5 py-3 text-sm font-semibold text-emerald-800 hover:bg-emerald-50 transition">
                Kembali ke Beranda
            </a>
        </div>
    </div>
</section>
@endsection