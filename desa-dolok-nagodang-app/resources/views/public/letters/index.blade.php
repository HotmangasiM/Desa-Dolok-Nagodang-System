@extends('layouts.public')

@section('content')

{{-- HERO --}}
<section class="relative overflow-hidden bg-gradient-to-br from-emerald-950 via-emerald-900 to-emerald-800 text-white">

    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 right-0 w-72 h-72 bg-white rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-72 h-72 bg-emerald-300 rounded-full blur-3xl"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24">

        <div class="max-w-3xl">

            <div class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/10 px-4 py-2 backdrop-blur">
                <i data-lucide="file-text" class="w-4 h-4 text-emerald-200"></i>

                <span class="text-sm font-medium text-emerald-100">
                    Pelayanan Administrasi Desa
                </span>
            </div>

            <h1 class="mt-6 text-4xl md:text-5xl lg:text-6xl font-bold leading-tight tracking-tight">
                Layanan Surat Desa
            </h1>

            <p class="mt-6 max-w-2xl text-base md:text-lg leading-8 text-emerald-50/90">
                Informasi jenis surat yang dapat diproses melalui Pemerintah Desa Dolok Nagodang.
                Warga dapat menyiapkan dokumen yang diperlukan sebelum datang ke kantor desa.
            </p>

            <div class="mt-8 flex flex-wrap gap-4">

                <a href="#layanan"
                   class="inline-flex items-center gap-2 rounded-2xl bg-white px-6 py-3.5 text-sm font-semibold text-emerald-800 shadow-lg hover:bg-emerald-50 transition">

                    Lihat Layanan

                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>

                <a href="#alur"
                   class="inline-flex items-center gap-2 rounded-2xl border border-white/20 bg-white/10 px-6 py-3.5 text-sm font-semibold text-white backdrop-blur hover:bg-white/15 transition">

                    Alur Pengurusan
                </a>

            </div>

        </div>

    </div>

</section>

{{-- SUMMARY --}}
<section class="relative z-10 mt-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">

            {{-- CARD --}}
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm hover:shadow-md transition">

                <div class="flex items-center justify-between">

                    <div>

                        <p class="text-sm font-medium text-slate-500">
                            Jenis Layanan
                        </p>

                        <h3 class="mt-2 text-3xl font-bold text-slate-800">
                            {{ number_format($letterTypes->count()) }}
                        </h3>

                    </div>

                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-emerald-100">
                        <i data-lucide="files" class="w-7 h-7 text-emerald-700"></i>
                    </div>

                </div>

            </div>

            {{-- CARD --}}
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm hover:shadow-md transition">

                <div class="flex items-center justify-between">

                    <div>

                        <p class="text-sm font-medium text-slate-500">
                            Lokasi Pengajuan
                        </p>

                        <h3 class="mt-2 text-xl font-bold text-slate-800">
                            Kantor Desa
                        </h3>

                    </div>

                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-sky-100">
                        <i data-lucide="building-2" class="w-7 h-7 text-sky-700"></i>
                    </div>

                </div>

            </div>

            {{-- CARD --}}
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm hover:shadow-md transition sm:col-span-2 lg:col-span-1">

                <div class="flex items-center justify-between">

                    <div>

                        <p class="text-sm font-medium text-slate-500">
                            Jam Layanan
                        </p>

                        <h3 class="mt-2 text-xl font-bold text-slate-800">
                            Senin - Jumat
                        </h3>

                    </div>

                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-amber-100">
                        <i data-lucide="clock-3" class="w-7 h-7 text-amber-700"></i>
                    </div>

                </div>

            </div>

        </div>

    </div>
</section>

{{-- ALUR --}}
<section id="alur" class="py-16 md:py-20 bg-white">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- HEADING --}}
        <div class="max-w-3xl">

            <p class="text-sm font-semibold uppercase tracking-wide text-emerald-700">
                Alur Pelayanan
            </p>

            <h2 class="mt-2 text-3xl md:text-4xl font-bold tracking-tight text-slate-800">
                Cara Mengurus Surat
            </h2>

            <p class="mt-4 text-slate-500 leading-7">
                Ikuti langkah berikut agar proses administrasi berjalan lebih mudah,
                cepat, dan sesuai prosedur pelayanan desa.
            </p>

        </div>

        {{-- STEPS --}}
        <div class="mt-10 grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6">

            @php
                $steps = [
                    [
                        'title' => 'Pilih Jenis Surat',
                        'desc' => 'Warga menentukan jenis surat sesuai kebutuhan administrasi.',
                        'icon' => 'file-search',
                        'number' => '01'
                    ],
                    [
                        'title' => 'Siapkan Dokumen',
                        'desc' => 'Siapkan KTP, KK, dan dokumen pendukung lainnya.',
                        'icon' => 'folder-check',
                        'number' => '02'
                    ],
                    [
                        'title' => 'Datang ke Kantor',
                        'desc' => 'Petugas desa melakukan pengecekan dan verifikasi data.',
                        'icon' => 'building',
                        'number' => '03'
                    ],
                    [
                        'title' => 'Surat Diproses',
                        'desc' => 'Surat diproses dan dapat diambil setelah selesai.',
                        'icon' => 'badge-check',
                        'number' => '04'
                    ],
                ];
            @endphp

            @foreach ($steps as $step)

                <div class="group relative rounded-3xl border border-slate-200 bg-slate-50/70 p-6 hover:border-emerald-200 hover:bg-white hover:shadow-lg transition duration-300">

                    <div class="absolute top-5 right-5 text-4xl font-black text-slate-100 group-hover:text-emerald-50 transition">
                        {{ $step['number'] }}
                    </div>

                    <div class="relative flex h-14 w-14 items-center justify-center rounded-2xl bg-emerald-100">

                        <i data-lucide="{{ $step['icon'] }}"
                           class="w-7 h-7 text-emerald-700">
                        </i>

                    </div>

                    <h3 class="mt-6 text-lg font-bold text-slate-800">
                        {{ $step['title'] }}
                    </h3>

                    <p class="mt-3 text-sm leading-7 text-slate-500">
                        {{ $step['desc'] }}
                    </p>

                </div>

            @endforeach

        </div>

    </div>

</section>

{{-- DAFTAR SURAT --}}
<section id="layanan" class="bg-slate-100/70 py-16 md:py-20">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- HEADING --}}
        <div class="flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">

            <div class="max-w-2xl">

                <p class="text-sm font-semibold uppercase tracking-wide text-emerald-700">
                    Jenis Surat
                </p>

                <h2 class="mt-2 text-3xl md:text-4xl font-bold tracking-tight text-slate-800">
                    Layanan yang Tersedia
                </h2>

                <p class="mt-4 text-slate-500 leading-7">
                    Daftar layanan surat yang dapat diproses oleh Pemerintah Desa
                    Dolok Nagodang untuk kebutuhan administrasi masyarakat.
                </p>

            </div>

        </div>

        {{-- GRID --}}
        <div class="mt-10 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

            @forelse ($letterTypes as $type)

                <div class="group rounded-3xl border border-slate-200 bg-white p-6 shadow-sm hover:-translate-y-1 hover:shadow-xl transition duration-300">

                    {{-- ICON --}}
                    <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-emerald-100 group-hover:bg-emerald-600 transition">

                        <i data-lucide="file-text"
                           class="w-8 h-8 text-emerald-700 group-hover:text-white transition">
                        </i>

                    </div>

                    {{-- TITLE --}}
                    <h3 class="mt-6 text-xl font-bold leading-snug text-slate-800">
                        {{ $type->name }}
                    </h3>

                    {{-- DESC --}}
                    <p class="mt-3 text-sm leading-7 text-slate-500 min-h-[84px]">
                        {{ $type->description ?: 'Layanan administrasi surat yang dapat diproses melalui kantor desa.' }}
                    </p>

                    {{-- CODE --}}
                    <div class="mt-5 rounded-2xl border border-slate-200 bg-slate-50 p-4">

                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                            Kode Surat
                        </p>

                        <p class="mt-1 text-base font-bold text-emerald-700">
                            {{ $type->code }}
                        </p>

                    </div>

                    {{-- BUTTON --}}
                    <a href="{{ route('public.letters.show', $type->code) }}"
                       class="mt-6 inline-flex items-center gap-2 rounded-2xl bg-emerald-600 px-5 py-3 text-sm font-semibold text-white hover:bg-emerald-700 transition">

                        Lihat Detail

                        <i data-lucide="arrow-right" class="w-4 h-4"></i>

                    </a>

                </div>

            @empty

                <div class="col-span-full rounded-3xl border border-dashed border-slate-300 bg-white p-12 text-center">

                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-slate-100">
                        <i data-lucide="folder-open" class="w-8 h-8 text-slate-400"></i>
                    </div>

                    <p class="mt-5 text-slate-500">
                        Layanan surat belum tersedia.
                    </p>

                </div>

            @endforelse

        </div>

    </div>

</section>

{{-- PERSYARATAN --}}
<section class="py-16 md:py-20 bg-white">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">

            {{-- LEFT --}}
            <div class="rounded-[32px] border border-slate-200 bg-white p-8 md:p-10 shadow-sm">

                <div class="flex items-center gap-4">

                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-emerald-100">

                        <i data-lucide="clipboard-check"
                           class="w-7 h-7 text-emerald-700">
                        </i>

                    </div>

                    <div>

                        <p class="text-sm font-semibold uppercase tracking-wide text-emerald-700">
                            Persyaratan Umum
                        </p>

                        <h2 class="mt-1 text-2xl md:text-3xl font-bold text-slate-800">
                            Dokumen yang Perlu Disiapkan
                        </h2>

                    </div>

                </div>

                <div class="mt-8 space-y-5">

                    @php
                        $requirements = [
                            'Kartu Tanda Penduduk atau NIK pemohon.',
                            'Kartu Keluarga jika diperlukan.',
                            'Dokumen pendukung sesuai jenis surat.',
                            'Datang ke kantor desa pada jam pelayanan.',
                        ];
                    @endphp

                    @foreach($requirements as $item)

                        <div class="flex items-start gap-4 rounded-2xl bg-slate-50 p-4">

                            <div class="mt-0.5 flex h-8 w-8 items-center justify-center rounded-full bg-emerald-100">

                                <i data-lucide="check"
                                   class="w-4 h-4 text-emerald-700">
                                </i>

                            </div>

                            <p class="flex-1 text-slate-600 leading-7">
                                {{ $item }}
                            </p>

                        </div>

                    @endforeach

                </div>

            </div>

            {{-- RIGHT --}}
            <div class="relative overflow-hidden rounded-[32px] bg-gradient-to-br from-emerald-950 via-emerald-900 to-emerald-800 p-8 md:p-10 text-white shadow-sm">

                <div class="absolute top-0 right-0 w-56 h-56 bg-white/10 rounded-full blur-3xl"></div>

                <div class="relative">

                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white/10 backdrop-blur">

                        <i data-lucide="phone-call"
                           class="w-7 h-7 text-emerald-100">
                        </i>

                    </div>

                    <p class="mt-6 text-sm font-semibold uppercase tracking-wide text-emerald-200">
                        Butuh Bantuan?
                    </p>

                    <h2 class="mt-2 text-3xl font-bold leading-tight">
                        Hubungi Kantor Desa
                    </h2>

                    <p class="mt-5 leading-8 text-emerald-100">
                        Jika warga membutuhkan informasi lebih lanjut terkait layanan surat,
                        silakan menghubungi atau datang langsung ke Kantor Desa Dolok Nagodang.
                    </p>

                    {{-- CONTACT --}}
                    <div class="mt-8 space-y-4">

                        <div class="flex items-start gap-4">

                            <div class="mt-1">
                                <i data-lucide="map-pin" class="w-5 h-5 text-emerald-200"></i>
                            </div>

                            <p class="text-emerald-100">
                                Desa Dolok Nagodang, Kec. Uluan, Kab. Toba
                            </p>

                        </div>

                        <div class="flex items-start gap-4">

                            <div class="mt-1">
                                <i data-lucide="clock-3" class="w-5 h-5 text-emerald-200"></i>
                            </div>

                            <p class="text-emerald-100">
                                Senin - Jumat, 08.00 - 15.00
                            </p>

                        </div>

                        <div class="flex items-start gap-4">

                            <div class="mt-1">
                                <i data-lucide="phone" class="w-5 h-5 text-emerald-200"></i>
                            </div>

                            <p class="text-emerald-100">
                                08xxxxxxxxxx
                            </p>

                        </div>

                    </div>

                    {{-- BUTTON --}}
                    <a href="{{ route('public.home') }}"
                       class="mt-10 inline-flex items-center gap-2 rounded-2xl bg-white px-6 py-3.5 text-sm font-semibold text-emerald-800 hover:bg-emerald-50 transition">

                        <i data-lucide="arrow-left" class="w-4 h-4"></i>

                        Kembali ke Beranda
                    </a>

                </div>

            </div>

        </div>

    </div>

</section>

@endsection