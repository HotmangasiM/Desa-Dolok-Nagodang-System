@extends('layouts.public')

@section('content')

{{-- HERO --}}
<section class="relative overflow-hidden bg-gradient-to-br from-emerald-950 via-emerald-900 to-slate-950 text-white">

    {{-- BACKGROUND GLOW --}}
    <div class="absolute inset-0 overflow-hidden">

        <div class="absolute -top-24 -right-24 w-[420px] h-[420px] rounded-full bg-emerald-500/20 blur-3xl"></div>

        <div class="absolute bottom-0 left-0 w-[320px] h-[320px] rounded-full bg-sky-500/20 blur-3xl"></div>

    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-20">

        <div class="max-w-3xl">

            <span class="inline-flex items-center rounded-full border border-white/10 bg-white/10 backdrop-blur px-4 py-2 text-sm font-medium text-emerald-100">
                Profil Desa
            </span>

            <h1 class="mt-5 text-4xl md:text-5xl lg:text-6xl font-black tracking-tight leading-tight">
                Desa Dolok Nagodang
            </h1>

            <p class="mt-5 text-base md:text-lg leading-8 text-emerald-100 max-w-2xl">
                Informasi resmi mengenai sejarah desa, wilayah,
                pemerintahan desa, dan potensi Desa Dolok Nagodang,
                Kecamatan Uluan, Kabupaten Toba.
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
                    ['title' => 'Kecamatan', 'value' => 'Uluan'],
                    ['title' => 'Kabupaten', 'value' => 'Toba'],
                    ['title' => 'Provinsi', 'value' => 'Sumatera Utara'],
                    ['title' => 'Dusun', 'value' => '3 Dusun'],
                ];
            @endphp

            @foreach($summary as $item)

                <div class="rounded-3xl bg-white border border-slate-200 p-5 shadow-sm">

                    <p class="text-sm text-slate-500">
                        {{ $item['title'] }}
                    </p>

                    <h3 class="mt-2 text-lg md:text-xl font-bold text-slate-800">
                        {{ $item['value'] }}
                    </h3>

                </div>

            @endforeach

        </div>

    </div>

</section>

{{-- GAMBARAN UMUM --}}
<section class="py-10 md:py-14 bg-slate-50">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

            {{-- CONTENT --}}
            <div class="lg:col-span-2">

                <div class="rounded-[28px] bg-white border border-slate-200 p-6 md:p-8 shadow-sm">

                    <span class="text-sm font-semibold text-emerald-700">
                        Gambaran Umum Desa
                    </span>

                    <h2 class="mt-2 text-2xl md:text-3xl font-bold tracking-tight text-slate-800">
                        Tentang Desa Dolok Nagodang
                    </h2>

                    <div class="mt-6 space-y-4 text-slate-600 leading-7 text-[15px]">

                        <p>
                            Desa Dolok Nagodang merupakan salah satu dari 17 desa
                            di Kecamatan Uluan, Kabupaten Toba,
                            Provinsi Sumatera Utara.
                        </p>

                        <p>
                            Desa ini berjarak sekitar 5 km dari pusat Kecamatan Uluan
                            dan sekitar 22 km dari pusat Kabupaten Toba.
                        </p>

                        <p>
                            Secara administratif Desa Dolok Nagodang terdiri dari
                            3 dusun, yaitu Dusun I Dolok Nagodang,
                            Dusun II Lumban Lintong,
                            dan Dusun III Sosorsilobu.
                        </p>

                        <p>
                            Pemerintah Desa terus meningkatkan pelayanan publik,
                            transparansi informasi, dan pembangunan desa
                            berbasis masyarakat.
                        </p>

                    </div>

                </div>

            </div>

            {{-- SIDEBAR --}}
            <div class="space-y-4">

                <div class="rounded-[28px] bg-emerald-950 p-6 text-white shadow-sm">

                    <span class="text-sm font-semibold text-emerald-200">
                        Informasi Desa
                    </span>

                    <div class="mt-6 space-y-5">

                        <div>
                            <p class="text-sm text-emerald-200">
                                Luas Wilayah
                            </p>

                            <h3 class="mt-1 text-lg font-bold">
                                500 Ha
                            </h3>
                        </div>

                        <div>
                            <p class="text-sm text-emerald-200">
                                Ketinggian
                            </p>

                            <h3 class="mt-1 text-lg font-bold">
                                970 mdpl
                            </h3>
                        </div>

                        <div>
                            <p class="text-sm text-emerald-200">
                                Suhu
                            </p>

                            <h3 class="mt-1 text-lg font-bold">
                                18° - 28°C
                            </h3>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>

{{-- SEJARAH --}}
<section class="py-10 md:py-14">

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center">

            <span class="text-sm font-semibold text-emerald-700">
                Sejarah Desa
            </span>

            <h2 class="mt-2 text-3xl font-bold tracking-tight text-slate-800">
                Legenda dan Sejarah Desa
            </h2>

        </div>

        <div class="mt-8 rounded-[28px] bg-white border border-slate-200 p-6 md:p-8 shadow-sm">

            <div class="space-y-5 text-slate-600 leading-7 text-[15px]">

                <p>
                    Sebelum Belanda memasuki wilayah Tapanuli,
                    telah terbentuk pemerintahan Nagori Lumban Nabolon
                    yang dipimpin oleh Kepala Nagari.
                </p>

                <p>
                    Salah satu wilayah yang berada di bawah pemerintahan tersebut
                    adalah Kampung Dolok Nagodang yang terdiri dari beberapa wilayah,
                    seperti Lumban Tonga-tonga, Lumban Padang,
                    Lumban Ginjang, Lumban Gala-gala,
                    Lumban Ginabean, Nasuksuk,
                    Lumban Simangambit, Lumban Paraduan,
                    Lumban Lintong, dan Sosor Silobu.
                </p>

                <p>
                    Pada tahun 1951 seluruh wilayah tersebut disatukan menjadi
                    Kampung Dolok Nagodang dengan kepala kampung pertama
                    bernama Op. Juara Bulan Manurung.
                </p>

                <p>
                    Hingga saat ini pembangunan desa terus berkembang melalui
                    program pemerintah, swadaya masyarakat,
                    kelompok tani, kelompok perikanan,
                    dan pengelolaan dana desa.
                </p>

            </div>

        </div>

    </div>

</section>

{{-- LETAK GEOGRAFIS --}}
<section class="py-10 md:py-14 bg-slate-50">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

            {{-- CONTENT --}}
            <div class="rounded-[28px] bg-white border border-slate-200 p-6 md:p-8 shadow-sm">

                <span class="text-sm font-semibold text-emerald-700">
                    Letak Geografis
                </span>

                <h2 class="mt-2 text-2xl md:text-3xl font-bold tracking-tight text-slate-800">
                    Kondisi Wilayah Desa
                </h2>

                <div class="mt-6 space-y-4 text-slate-600 leading-7 text-[15px]">

                    <p>
                        Desa Dolok Nagodang merupakan daerah dataran tinggi
                        dengan ketinggian sekitar 970 mdpl di atas permukaan laut.
                    </p>

                    <p>
                        Curah hujan di wilayah desa relatif tinggi,
                        yaitu sekitar 155–260 mm per tahun dengan
                        suhu udara rata-rata 18°–28°C.
                    </p>

                    <p>
                        Luas wilayah Desa Dolok Nagodang sekitar
                        500 hektar dan terbagi menjadi 3 dusun,
                        yaitu Dusun I Dolok Nagodang,
                        Dusun II Lumban Lintong,
                        dan Dusun III Sosorsilobu.
                    </p>

                </div>

            </div>

            {{-- BATAS WILAYAH --}}
            <div class="rounded-[28px] bg-emerald-950 p-6 md:p-8 text-white shadow-sm">

                <span class="text-sm font-semibold text-emerald-200">
                    Batas Wilayah
                </span>

                <div class="mt-6 space-y-4">

                    <div class="rounded-2xl bg-white/10 p-4">
                        <p class="text-sm text-emerald-200">
                            Sebelah Utara
                        </p>

                        <p class="mt-1 font-medium">
                            Desa Doloksaribu Lumban Nabolon dan Desa Nalela
                        </p>
                    </div>

                    <div class="rounded-2xl bg-white/10 p-4">
                        <p class="text-sm text-emerald-200">
                            Sebelah Timur
                        </p>

                        <p class="mt-1 font-medium">
                            Desa Lumban Nabolon
                        </p>
                    </div>

                    <div class="rounded-2xl bg-white/10 p-4">
                        <p class="text-sm text-emerald-200">
                            Sebelah Selatan
                        </p>

                        <p class="mt-1 font-medium">
                            Desa Parbagasan Janjimatogu dan Desa Lumban Binanga
                        </p>
                    </div>

                    <div class="rounded-2xl bg-white/10 p-4">
                        <p class="text-sm text-emerald-200">
                            Sebelah Barat
                        </p>

                        <p class="mt-1 font-medium">
                            Desa Parik dan Desa Amborgang
                        </p>
                    </div>

                </div>

            </div>

        </div>

    </div>

</section>

{{-- KEPALA DESA --}}
<section class="py-10 md:py-14">

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center">

            <span class="text-sm font-semibold text-emerald-700">
                Pemerintahan Desa
            </span>

            <h2 class="mt-2 text-3xl font-bold tracking-tight text-slate-800">
                Kepala Desa dari Masa ke Masa
            </h2>

        </div>

        <div class="mt-8 overflow-hidden rounded-[28px] border border-slate-200 bg-white shadow-sm">

            <div class="overflow-x-auto">

                <table class="min-w-full">

                    <thead class="bg-emerald-950 text-white">

                        <tr>

                            <th class="px-6 py-4 text-left text-sm font-semibold">
                                No
                            </th>

                            <th class="px-6 py-4 text-left text-sm font-semibold">
                                Nama
                            </th>

                            <th class="px-6 py-4 text-left text-sm font-semibold">
                                Masa Jabatan
                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-slate-100">

                        @php
                            $kepalaDesa = [
                                ['no' => 1, 'nama' => 'Op. Juara Bulan Manurung', 'masa' => '1951 - 1965'],
                                ['no' => 2, 'nama' => 'Etti Manurung', 'masa' => '1965 - 1970'],
                                ['no' => 3, 'nama' => 'Jonas Manurung', 'masa' => '1970 - 1984'],
                                ['no' => 4, 'nama' => 'Maruli Sirait', 'masa' => '1984 - 2000'],
                                ['no' => 5, 'nama' => 'Binsar Manurung', 'masa' => '2000 - 2013'],
                                ['no' => 6, 'nama' => 'Togar Manurung', 'masa' => '2013 - 2019'],
                                ['no' => 7, 'nama' => 'Pj. Panal Freddy Nadapdap', 'masa' => '2019 - 2019'],
                                ['no' => 8, 'nama' => 'Togar Manurung', 'masa' => '2020 - 2022'],
                                ['no' => 9, 'nama' => 'Pj. Winra Marpaung, SE', 'masa' => '2022 - 2023'],
                                ['no' => 10, 'nama' => 'Bangkit Manurung', 'masa' => '2023 - Sekarang'],
                            ];
                        @endphp

                        @foreach($kepalaDesa as $item)

                            <tr class="hover:bg-slate-50 transition">

                                <td class="px-6 py-4 text-sm text-slate-500">
                                    {{ $item['no'] }}
                                </td>

                                <td class="px-6 py-4 font-semibold text-slate-700">
                                    {{ $item['nama'] }}
                                </td>

                                <td class="px-6 py-4 text-sm text-slate-500">
                                    {{ $item['masa'] }}
                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>
        

    </div>

</section>
{{-- POTENSI & GALERI DESA --}}
<section class="bg-emerald-950 py-14 md:py-20 text-white overflow-hidden">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- HEADING --}}
        <div class="text-center max-w-3xl mx-auto">

            <p class="text-sm font-semibold text-emerald-200">
                Potensi Desa
            </p>

            <h2 class="mt-2 text-3xl md:text-4xl font-bold tracking-tight">
                Potensi dan Galeri Desa
            </h2>

            <p class="mt-4 text-emerald-100 leading-8 text-[15px] md:text-base">
                Potensi unggulan dan dokumentasi kegiatan masyarakat
                Desa Dolok Nagodang.
            </p>

        </div>

        {{-- POTENSI --}}
        <div class="mt-10 grid grid-cols-1 md:grid-cols-3 gap-5">

            @php
                $potensi = [
                    [
                        'icon' => '🌾',
                        'title' => 'Pertanian',
                        'desc' => 'Potensi pertanian dan perkebunan masyarakat desa yang menjadi sumber ekonomi utama.',
                    ],
                    [
                        'icon' => '🐟',
                        'title' => 'Perikanan',
                        'desc' => 'Pengembangan kelompok perikanan dan budidaya masyarakat desa.',
                    ],
                    [
                        'icon' => '🤝',
                        'title' => 'Gotong Royong',
                        'desc' => 'Budaya kebersamaan masyarakat dalam pembangunan desa.',
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

        {{-- GALERI --}}
        <div class="mt-16">

            <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4">

                <div>

                    <p class="text-sm font-semibold text-emerald-200">
                        Galeri Desa
                    </p>

                    <h2 class="mt-2 text-3xl font-bold tracking-tight">
                        Dokumentasi Desa
                    </h2>

                </div>

                <p class="text-sm text-emerald-100">
                    Foto kegiatan dan suasana Desa Dolok Nagodang
                </p>

            </div>

            @php
                $galeri = [
                    [
                        'image' => 'images/galeri/galeri2.jpg',
                        'title' => 'Pemandangan Desa',
                    ],
                    [
                        'image' => 'images/galeri/galeri4.jpg',
                        'title' => 'Pertanian Desa',
                    ],
                    [
                        'image' => 'images/galeri/galeri6.jpg',
                        'title' => 'Lingkungan Desa',
                    ],
                ];
            @endphp

            <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">

                @foreach($galeri as $item)

                    <div class="group overflow-hidden rounded-3xl border border-white/10 bg-white/5">

                        <div class="relative overflow-hidden">

                            <img src="{{ asset($item['image']) }}"
                                 alt="{{ $item['title'] }}"
                                 class="h-64 w-full object-cover transition duration-500 group-hover:scale-110">

                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/10 to-transparent"></div>

                            <div class="absolute bottom-0 left-0 p-5">

                                <h3 class="text-lg font-semibold text-white">
                                    {{ $item['title'] }}
                                </h3>

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

        </div>

    </div>

</section>

@endsection