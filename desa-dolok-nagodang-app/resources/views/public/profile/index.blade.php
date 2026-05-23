@extends('layouts.public')

@section('content')

{{-- HERO --}}
<section class="relative overflow-hidden bg-emerald-950 text-white">

    <div class="absolute inset-0 opacity-20">
        <div class="absolute top-0 right-0 w-[420px] h-[420px] bg-emerald-500 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-[320px] h-[320px] bg-sky-500 rounded-full blur-3xl"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24">

        <div class="max-w-3xl">

            <span class="inline-flex items-center rounded-full border border-white/10 bg-white/10 px-4 py-2 text-xs md:text-sm font-medium text-emerald-100 backdrop-blur">
                Profil Desa
            </span>

            <h1 class="mt-6 text-4xl md:text-5xl lg:text-6xl font-bold leading-tight tracking-tight">
                Desa Dolok Nagodang
            </h1>

            <p class="mt-5 text-base md:text-lg leading-8 text-emerald-100 max-w-2xl">
                Informasi umum mengenai Desa Dolok Nagodang, Kecamatan Uluan,
                Kabupaten Toba, meliputi sejarah, visi misi, wilayah,
                dan potensi desa.
            </p>

        </div>

    </div>

</section>

{{-- RINGKASAN --}}
<section class="relative mt-8 z-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">

            @php
                $summary = [
                    ['title' => 'Desa', 'value' => 'Dolok Nagodang'],
                    ['title' => 'Kecamatan', 'value' => 'Uluan'],
                    ['title' => 'Kabupaten', 'value' => 'Toba'],
                    ['title' => 'Provinsi', 'value' => 'Sumatera Utara'],
                ];
            @endphp

            @foreach($summary as $item)
                <div class="rounded-2xl md:rounded-3xl bg-white border border-slate-200 p-5 md:p-6 shadow-sm">

                    <p class="text-xs md:text-sm text-slate-500">
                        {{ $item['title'] }}
                    </p>

                    <h3 class="mt-2 text-base md:text-xl font-bold text-slate-800 leading-snug">
                        {{ $item['value'] }}
                    </h3>

                </div>
            @endforeach

        </div>

    </div>
</section>

{{-- TENTANG --}}
<section class="py-14 md:py-20">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">

            {{-- KONTEN --}}
            <div class="lg:col-span-2 rounded-3xl bg-white border border-slate-200 p-6 md:p-8 shadow-sm">

                <div class="max-w-3xl">

                    <p class="text-sm font-semibold text-emerald-700">
                        Tentang Desa
                    </p>

                    <h2 class="mt-2 text-2xl md:text-3xl font-bold tracking-tight text-slate-800">
                        Sekilas Desa Dolok Nagodang
                    </h2>

                    <div class="mt-6 space-y-5 text-slate-600 leading-8 text-[15px] md:text-base">

                        <p>
                            Desa Dolok Nagodang merupakan salah satu desa yang berada
                            di Kecamatan Uluan, Kabupaten Toba,
                            Provinsi Sumatera Utara.
                        </p>

                        <p>
                            Website ini hadir sebagai media informasi resmi desa
                            untuk membantu masyarakat mendapatkan informasi terkait
                            pemerintahan desa, pelayanan administrasi,
                            berita kegiatan, dan data publik desa.
                        </p>

                        <p>
                            Melalui sistem informasi desa ini, Pemerintah Desa
                            Dolok Nagodang berupaya meningkatkan keterbukaan
                            informasi dan kualitas pelayanan kepada masyarakat.
                        </p>

                    </div>

                </div>

            </div>

            {{-- SIDEBAR --}}
            <div class="rounded-3xl bg-emerald-950 p-6 md:p-8 text-white shadow-sm">

                <p class="text-sm font-semibold text-emerald-200">
                    Informasi Layanan
                </p>

                <h2 class="mt-2 text-2xl font-bold">
                    Kantor Desa
                </h2>

                <div class="mt-8 space-y-6">

                    <div>
                        <p class="text-sm font-semibold text-white">
                            Alamat
                        </p>

                        <p class="mt-2 text-sm leading-7 text-emerald-100">
                            Desa Dolok Nagodang, Kecamatan Uluan,
                            Kabupaten Toba
                        </p>
                    </div>

                    <div>
                        <p class="text-sm font-semibold text-white">
                            Jam Layanan
                        </p>

                        <p class="mt-2 text-sm leading-7 text-emerald-100">
                            Senin - Jumat, 08.00 - 15.00 WIB
                        </p>
                    </div>

                    <div>
                        <p class="text-sm font-semibold text-white">
                            Layanan
                        </p>

                        <p class="mt-2 text-sm leading-7 text-emerald-100">
                            Administrasi kependudukan dan surat
                            keterangan desa.
                        </p>
                    </div>

                </div>

            </div>

        </div>

    </div>

</section>

{{-- VISI MISI --}}
<section class="bg-slate-50 py-16 md:py-20 overflow-hidden">

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- HEADING --}}
        <div class="text-center max-w-3xl mx-auto">

            <span class="inline-flex items-center rounded-full bg-emerald-100 px-4 py-2 text-sm font-semibold text-emerald-700">
                Visi & Misi Desa
            </span>

            <h2 class="mt-5 text-3xl md:text-4xl font-bold tracking-tight text-slate-800">
                Desa Dolok Nagodang
            </h2>

            <p class="mt-4 text-base leading-7 text-slate-500">
                Komitmen Pemerintah Desa dalam mewujudkan pelayanan publik
                yang transparan, modern, dan berorientasi kepada masyarakat.
            </p>

        </div>

        {{-- VISI --}}
        <div class="mt-14">

            <div class="relative rounded-[32px] bg-white border border-slate-200 shadow-sm overflow-hidden">

                {{-- Accent --}}
                <div class="h-2 w-full bg-gradient-to-r from-emerald-500 to-emerald-400"></div>

                <div class="p-8 md:p-12">

                    {{-- HEADER --}}
                    <div class="flex flex-col sm:flex-row sm:items-center gap-5">

                        {{-- ICON --}}
                        <div class="w-20 h-20 rounded-3xl bg-emerald-50 border border-emerald-100 flex items-center justify-center shrink-0">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="w-10 h-10 text-emerald-600"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="1.8">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>

                                <circle cx="12" cy="12" r="3"/>

                            </svg>

                        </div>

                        {{-- TEXT --}}
                        <div>

                            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-emerald-600">
                                Visi
                            </p>

                            <h3 class="mt-2 text-2xl md:text-3xl font-bold text-slate-800">
                                Arah dan Tujuan Desa
                            </h3>

                        </div>

                    </div>

                    {{-- CONTENT --}}
                    <div class="mt-8 md:mt-10">

                        <p class="text-lg md:text-xl leading-9 text-slate-600">
                            Mewujudkan Desa Dolok Nagodang yang tertib administrasi,
                            informatif, transparan, dan memberikan pelayanan terbaik
                            kepada masyarakat.
                        </p>

                    </div>

                </div>

            </div>

        </div>

        {{-- MISI --}}
        <div class="mt-8">

            <div class="relative rounded-[32px] bg-white border border-slate-200 shadow-sm overflow-hidden">

                {{-- Accent --}}
                <div class="h-2 w-full bg-gradient-to-r from-sky-500 to-cyan-400"></div>

                <div class="p-8 md:p-12">

                    {{-- HEADER --}}
                    <div class="flex flex-col sm:flex-row sm:items-center gap-5">

                        {{-- ICON --}}
                        <div class="w-20 h-20 rounded-3xl bg-sky-50 border border-sky-100 flex items-center justify-center shrink-0">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="w-10 h-10 text-sky-600"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="1.8">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M9 12l2 2 4-4"/>

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M12 22C17.523 22 22 17.523 22 12S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/>

                            </svg>

                        </div>

                        {{-- TEXT --}}
                        <div>

                            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-sky-600">
                                Misi
                            </p>

                            <h3 class="mt-2 text-2xl md:text-3xl font-bold text-slate-800">
                                Langkah dan Komitmen Desa
                            </h3>

                        </div>

                    </div>

                    {{-- LIST --}}
                    <div class="mt-10 grid grid-cols-1 md:grid-cols-2 gap-5">

                        {{-- ITEM --}}
                        <div class="flex items-start gap-4 rounded-2xl border border-slate-100 bg-slate-50 p-5">

                            <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center shrink-0">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="w-5 h-5 text-emerald-600"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor"
                                     stroke-width="2">

                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M5 13l4 4L19 7"/>

                                </svg>

                            </div>

                            <p class="text-slate-600 leading-7">
                                Meningkatkan kualitas pelayanan administrasi desa.
                            </p>

                        </div>

                        {{-- ITEM --}}
                        <div class="flex items-start gap-4 rounded-2xl border border-slate-100 bg-slate-50 p-5">

                            <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center shrink-0">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="w-5 h-5 text-emerald-600"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor"
                                     stroke-width="2">

                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M5 13l4 4L19 7"/>

                                </svg>

                            </div>

                            <p class="text-slate-600 leading-7">
                                Menyediakan informasi desa yang mudah diakses masyarakat.
                            </p>

                        </div>

                        {{-- ITEM --}}
                        <div class="flex items-start gap-4 rounded-2xl border border-slate-100 bg-slate-50 p-5">

                            <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center shrink-0">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="w-5 h-5 text-emerald-600"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor"
                                     stroke-width="2">

                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M5 13l4 4L19 7"/>

                                </svg>

                            </div>

                            <p class="text-slate-600 leading-7">
                                Mendorong transparansi dalam penyelenggaraan pemerintahan desa.
                            </p>

                        </div>

                        {{-- ITEM --}}
                        <div class="flex items-start gap-4 rounded-2xl border border-slate-100 bg-slate-50 p-5">

                            <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center shrink-0">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="w-5 h-5 text-emerald-600"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor"
                                     stroke-width="2">

                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M5 13l4 4L19 7"/>

                                </svg>

                            </div>

                            <p class="text-slate-600 leading-7">
                                Mendukung partisipasi masyarakat dalam pembangunan desa.
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>  
{{-- WILAYAH --}}
<section class="py-14 md:py-20">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-10 items-start">

            {{-- LEFT --}}
            <div>

                <p class="text-sm font-semibold text-emerald-700">
                    Wilayah Desa
                </p>

                <h2 class="mt-2 text-3xl font-bold tracking-tight text-slate-800">
                    Wilayah Administratif
                </h2>

                <p class="mt-4 text-slate-500 leading-8 text-[15px] md:text-base">
                    Desa Dolok Nagodang terdiri dari beberapa wilayah dusun
                    yang menjadi bagian dari administrasi pelayanan masyarakat.
                </p>

                <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">

                    @php
                        $dusun = ['Dusun I', 'Dusun II', 'Dusun III'];
                    @endphp

                    @foreach($dusun as $item)
                        <div class="rounded-2xl bg-white border border-slate-200 p-5 shadow-sm">

                            <p class="text-sm text-slate-500">
                                Wilayah
                            </p>

                            <h3 class="mt-2 text-lg font-bold text-slate-800">
                                {{ $item }}
                            </h3>

                        </div>
                    @endforeach

                </div>

            </div>

            {{-- MAP --}}
            <div class="rounded-3xl bg-white border border-slate-200 p-5 md:p-6 shadow-sm">

                <h3 class="text-xl font-bold text-slate-800">
                    Peta Lokasi
                </h3>

                <p class="mt-2 text-sm text-slate-500">
                    Lokasi wilayah Desa Dolok Nagodang.
                </p>

                <div class="mt-5 overflow-hidden rounded-2xl border border-slate-200 aspect-video">

                    <iframe
                        src="https://www.google.com/maps?q=Dolok%20Nagodang&output=embed"
                        width="100%"
                        height="100%"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy">
                    </iframe>

                </div>

            </div>

        </div>

    </div>

</section>

{{-- POTENSI --}}
<section class="bg-emerald-950 py-14 md:py-20 text-white overflow-hidden">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- HEADING --}}
        <div class="text-center max-w-3xl mx-auto">

            <p class="text-sm font-semibold text-emerald-200">
                Potensi Desa
            </p>

            <h2 class="mt-2 text-3xl md:text-4xl font-bold tracking-tight">
                Potensi dan Keunggulan Desa
            </h2>

            <p class="mt-4 text-emerald-100 leading-8 text-[15px] md:text-base">
                Beberapa potensi desa yang dapat dikembangkan untuk mendukung
                kesejahteraan masyarakat.
            </p>

        </div>

        {{-- GRID --}}
        <div class="mt-10 grid grid-cols-1 md:grid-cols-3 gap-5">

            @php
                $potensi = [
                    [
                        'icon' => '🌾',
                        'title' => 'Pertanian',
                        'desc' => 'Potensi hasil pertanian dan perkebunan masyarakat desa.',
                    ],
                    [
                        'icon' => '🏞️',
                        'title' => 'Alam dan Lingkungan',
                        'desc' => 'Lingkungan desa yang dapat dikembangkan sebagai potensi wilayah.',
                    ],
                    [
                        'icon' => '🤝',
                        'title' => 'Gotong Royong',
                        'desc' => 'Kekuatan sosial masyarakat dalam mendukung pembangunan desa.',
                    ],
                ];
            @endphp

            @foreach($potensi as $item)

                <div class="rounded-3xl border border-white/10 bg-white/10 backdrop-blur p-6 md:p-7">

                    <div class="text-4xl">
                        {{ $item['icon'] }}
                    </div>

                    <h3 class="mt-5 text-xl font-bold">
                        {{ $item['title'] }}
                    </h3>

                    <p class="mt-3 text-sm leading-7 text-emerald-100">
                        {{ $item['desc'] }}
                    </p>

                </div>

            @endforeach

        </div>

    </div>

</section>

@endsection