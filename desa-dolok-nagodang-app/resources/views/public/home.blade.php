@extends('layouts.public')

@section('content')
{{-- HERO --}}
<section class="relative">

    <div class="swiper heroSwiper h-[620px] md:h-[700px]">

        <div class="swiper-wrapper">

            {{-- SLIDE 1 --}}
            <div class="swiper-slide relative">
                <img
                    src="{{ asset('storage/sliders/slide1.jpg') }}"
                    class="absolute inset-0 w-full h-full object-cover"
                >

                <div class="absolute inset-0 bg-black/50"></div>

                <div class="relative z-10 max-w-7xl mx-auto px-4 h-full flex items-center">
                    <div class="max-w-3xl text-white fade-up">
                        <p class="inline-flex rounded-full bg-white/10 border border-white/20 px-4 py-2 text-sm">
                            Website Resmi Desa
                        </p>

                        <h1 class="mt-6 text-5xl md:text-6xl font-bold leading-tight">
                            Desa Dolok Nagodang
                        </h1>

                        <p class="mt-6 text-lg text-slate-200 leading-8">
                            Portal informasi pemerintahan desa, layanan masyarakat,
                            berita terbaru, dan transparansi pembangunan desa.
                        </p>

                        <div class="mt-8 flex flex-wrap gap-4">
                            <a href="{{ route('public.news.index') }}"
                               class="rounded-2xl bg-emerald-600 px-6 py-4 text-sm font-semibold text-white hover:bg-emerald-700 transition">
                                Lihat Berita
                            </a>

                            <a href="{{ route('public.profile') }}"
                               class="rounded-2xl border border-white/30 bg-white/10 backdrop-blur px-6 py-4 text-sm font-semibold text-white hover:bg-white/20 transition">
                                Profil Desa
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- SLIDE 2 --}}
            <div class="swiper-slide relative">
                <img
                    src="{{ asset('storage/sliders/slide2.jpg') }}"
                    class="absolute inset-0 w-full h-full object-cover"
                >

                <div class="absolute inset-0 bg-black/50"></div>

                <div class="relative z-10 max-w-7xl mx-auto px-4 h-full flex items-center">
                    <div class="max-w-3xl text-white">
                        <p class="inline-flex rounded-full bg-white/10 border border-white/20 px-4 py-2 text-sm">
                            Transparansi Desa
                        </p>

                        <h1 class="mt-6 text-5xl md:text-6xl font-bold leading-tight">
                            Informasi Desa Lebih Terbuka
                        </h1>

                        <p class="mt-6 text-lg text-slate-200 leading-8">
                            Menyediakan informasi terbaru mengenai pembangunan,
                            kegiatan masyarakat, dan layanan administrasi desa.
                        </p>
                    </div>
                </div>
            </div>

            {{-- SLIDE 3 --}}
            <div class="swiper-slide relative">
                <img
                    src="{{ asset('storage/sliders/slide3.jpg') }}"
                    class="absolute inset-0 w-full h-full object-cover"
                >

                <div class="absolute inset-0 bg-black/50"></div>

                <div class="relative z-10 max-w-7xl mx-auto px-4 h-full flex items-center">
                    <div class="max-w-3xl text-white">
                        <p class="inline-flex rounded-full bg-white/10 border border-white/20 px-4 py-2 text-sm">
                            Pelayanan Masyarakat
                        </p>

                        <h1 class="mt-6 text-5xl md:text-6xl font-bold leading-tight">
                            Cepat, Modern, dan Informatif
                        </h1>

                        <p class="mt-6 text-lg text-slate-200 leading-8">
                            Website desa modern untuk mendukung pelayanan publik
                            dan keterbukaan informasi kepada masyarakat.
                        </p>
                    </div>
                </div>
            </div>

        </div>

        {{-- NAVIGATION --}}
        <!-- <button type="button"
        class="hero-prev absolute left-6 top-1/2 z-30 -translate-y-1/2 w-14 h-14 rounded-full bg-white/15 text-white border border-white/30 backdrop-blur-md hover:bg-emerald-600 hover:border-emerald-500 transition hidden md:flex items-center justify-center text-3xl">
            ‹
        </button>

        <button type="button"
                class="hero-next absolute right-6 top-1/2 z-30 -translate-y-1/2 w-14 h-14 rounded-full bg-white/15 text-white border border-white/30 backdrop-blur-md hover:bg-emerald-600 hover:border-emerald-500 transition hidden md:flex items-center justify-center text-3xl">
            ›
        </button> -->

        {{-- PAGINATION --}}
        <div class="swiper-pagination"></div>

    </div>

</section>

{{-- VIDEO DESA --}}
<section class="relative py-16 md:py-20 overflow-hidden bg-black">

    {{-- BACKGROUND --}}
    <div class="absolute inset-0 bg-gradient-to-b from-black via-slate-950 to-black"></div>

    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[700px] h-[300px] bg-emerald-500/10 blur-3xl rounded-full"></div>

    <div class="relative max-w-7xl mx-auto px-4">

        {{-- HEADER --}}
        <div class="text-center max-w-3xl mx-auto">

            <h2 class="mt-4 text-4xl md:text-6xl font-extrabold text-white leading-tight">

                Explore
                <span class="text-emerald-400">
                    Dolok Nagodang
                </span>

            </h2>

            <p class="mt-6 text-slate-300 leading-8 text-base md:text-lg">
                Panorama udara Desa Dolok Nagodang yang menampilkan
                keindahan alam, suasana masyarakat, dan perkembangan desa.
            </p>

        </div>

        {{-- VIDEO --}}
        <div class="mt-12">

            <div class="relative rounded-2xl md:rounded-[36px] overflow-hidden border border-white/10 shadow-[0_25px_80px_rgba(0,0,0,0.65)] bg-black">

                {{-- CINEMATIC OVERLAY --}}
                <div class="absolute top-0 left-0 w-full h-32 bg-gradient-to-b from-black/70 to-transparent z-20 pointer-events-none"></div>

                <div class="absolute bottom-0 left-0 w-full h-40 bg-gradient-to-t from-black/80 to-transparent z-20 pointer-events-none"></div>

                <div class="absolute inset-0 shadow-[inset_0_0_120px_rgba(0,0,0,0.75)] z-20 pointer-events-none"></div>

                {{-- OVERLAY DESKTOP --}}
<div class="hidden md:block absolute bottom-0 left-0 z-30 p-10">

    <div class="inline-flex items-center gap-2 rounded-full bg-white/10 backdrop-blur px-4 py-2 border border-white/10">

        <span class="w-2.5 h-2.5 rounded-full bg-red-500 animate-pulse"></span>

        <span class="text-xs tracking-[0.2em] uppercase text-white/80">
            Drone Footage
        </span>

    </div>

    <h3 class="mt-5 text-4xl font-bold text-white">
        Desa Dolok Nagodang
    </h3>

    <p class="mt-3 text-base text-slate-200 max-w-2xl leading-7">
        Menampilkan pesona desa, alam, budaya,
        dan pembangunan masyarakat secara modern.
    </p>

</div>

{{-- MOBILE CONTENT --}}
<div class="block md:hidden bg-black px-5 py-5">

    <div class="inline-flex items-center gap-2 rounded-full bg-white/10 px-3 py-2 border border-white/10">

        <span class="w-2 h-2 rounded-full bg-red-500"></span>

        <span class="text-[10px] tracking-[0.18em] uppercase text-white/70">
            Drone Footage
        </span>

    </div>

    <h3 class="mt-4 text-2xl font-bold text-white leading-tight">
        Desa Dolok Nagodang
    </h3>

    <p class="mt-2 text-sm text-slate-300 leading-6">
        Menampilkan pesona desa, alam, budaya,
        dan pembangunan masyarakat secara modern.
    </p>

</div>

                {{-- VIDEO --}}
                 <div class="aspect-[16/10] sm:aspect-video bg-black">

                <video
                    class="w-full h-full object-cover"
                    autoplay
                    muted
                    loop
                    playsinline
                    controls
                    preload="metadata"
                    poster="{{ asset('storage/sliders/slide1.jpg') }}"
                >
                    <source
                        src="{{ asset('storage/video/view-desa.mp4') }}"
                        type="video/mp4">

                    Browser tidak mendukung video.
                </video>

            </div>

            </div>

        </div>

    </div>

</section>


{{-- QUICK MENU --}}
<section class="max-w-7xl mx-auto px-4 mt-8 md:mt-10 relative z-10">
    @php
        $menus = [
            ['label'=>'Profil Desa','desc'=>'Informasi wilayah','icon'=>'home','url'=>route('public.profile')],
            ['label'=>'Berita Desa','desc'=>number_format($totalPublishedNews ?? 0).' berita tayang','icon'=>'newspaper','url'=>route('public.news.index')],
            ['label'=>'Aparat Desa','desc'=>'Struktur perangkat','icon'=>'users','url'=>route('public.officials')],
            ['label'=>'Layanan Surat','desc'=>number_format($totalLetterTypes ?? 0).' jenis layanan','icon'=>'file-text','url'=>route('public.letters')],
        ];
    @endphp

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @foreach ($menus as $menu)
        <a href="{{ $menu['url'] }}"
           class="group rounded-3xl bg-white p-4 shadow-sm border hover:shadow-lg hover:-translate-y-1 transition">

            <div class="w-14 h-14 rounded-2xl bg-emerald-50 flex items-center justify-center group-hover:bg-emerald-100 transition">
                <i data-lucide="{{ $menu['icon'] }}" class="w-6 h-6 text-emerald-600 group-hover:scale-110 transition"></i>
            </div>

            <p class="mt-4 font-bold text-slate-800">{{ $menu['label'] }}</p>
            <p class="mt-1 text-xs text-slate-500">{{ $menu['desc'] }}</p>
        </a>
        @endforeach
    </div>
</section>

{{-- INFORMASI CEPAT --}}
<section class="max-w-7xl mx-auto px-4 mt-8 md:mt-10 relative z-10">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

        @php
        $info = [
            ['title'=>'Jam Layanan','value'=>'Senin - Jumat','desc'=>'08.00 - 15.00 WIB','icon'=>'clock','color'=>'emerald'],
            ['title'=>'Lokasi','value'=>'Dolok Nagodang','desc'=>'Kec. Uluan, Kab. Toba','icon'=>'map-pin','color'=>'sky'],
            ['title'=>'Berita Tayang','value'=>number_format($totalPublishedNews ?? 0).' Berita','link'=>route('public.news.index'),'icon'=>'newspaper','color'=>'amber'],
            ['title'=>'Layanan Surat','value'=>number_format($totalLetterTypes ?? 0).' Jenis Layanan','link'=>route('public.letters'),'icon'=>'file-text','color'=>'violet'],
        ];
        @endphp

        @foreach($info as $item)
        <div class="rounded-3xl bg-white border p-6 shadow-sm hover:shadow-md transition">

            <div class="w-12 h-12 rounded-2xl bg-{{ $item['color'] }}-100 flex items-center justify-center">
                <i data-lucide="{{ $item['icon'] }}" class="w-6 h-6 text-{{ $item['color'] }}-600"></i>
            </div>

            <p class="mt-4 text-sm text-slate-500">{{ $item['title'] }}</p>
            <h3 class="mt-1 font-bold text-slate-800">{{ $item['value'] }}</h3>

            @isset($item['desc'])
                <p class="mt-1 text-sm text-slate-500">{{ $item['desc'] }}</p>
            @endisset

            @isset($item['link'])
                <a href="{{ $item['link'] }}" class="mt-2 inline-flex text-sm font-semibold text-emerald-700">
                    Lihat →
                </a>
            @endisset
        </div>
        @endforeach

    </div>
</section>

{{-- SAMBUTAN FULL SECTION --}} 
<section class="relative py-16 md:py-20 bg-gradient-to-br from-slate-50 via-white to-emerald-50 overflow-hidden">

    {{-- Background Decoration --}}
    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-emerald-100 rounded-full blur-3xl opacity-30"></div>
    <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-sky-100 rounded-full blur-3xl opacity-20"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 min-h-screen flex items-center py-16">

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center w-full">

            {{-- FOTO --}}
            <div class="flex justify-center lg:justify-start order-1">

                <div class="relative">

                    <!-- {{-- Glow --}}
                    <div class="absolute inset-0 bg-emerald-200 blur-[100px] opacity-40 rounded-full scale-110"></div>

                    {{-- Decorative Circle --}}
                    <div class="absolute -top-6 -right-6 w-24 h-24 rounded-full border border-emerald-200"></div>
                    <div class="absolute -bottom-6 -left-6 w-16 h-16 rounded-full bg-emerald-100"></div> -->

                    {{-- Image --}}
                    <img
                        src="{{ asset('images/sambutan.png') }}"
                        alt="Kepala Desa"
                        class="relative z-10 w-[200px] sm:w-[280px] lg:w-[380px] object-contain drop-shadow-[0_20px_50px_rgba(0,0,0,0.18)]"
                    >

                </div>

            </div>

            {{-- TEXT --}}
            <div class="order-2 text-center lg:text-left">

                {{-- Badge --}}
                <div class="inline-flex items-center gap-3 rounded-full bg-white/80 backdrop-blur border border-emerald-100 px-5 py-3 shadow-sm">

                    <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center">
                        <i data-lucide="user" class="w-5 h-5 text-emerald-600"></i>
                    </div>

                    <span class="text-sm font-medium text-emerald-700 tracking-wide">
                        Sambutan Kepala Desa
                    </span>

                </div>

                {{-- Title --}}
                <h1 class="mt-7 text-3xl sm:text-5xl lg:text-3xl md:text-5xl font-bold leading-tight text-slate-900">

                    Desa
                    <span class="text-emerald-600">
                        Dolok Nagodang
                    </span>

                </h1>

                {{-- Nama --}}
                <div class="mt-8">

                    <h2 class="text-2xl sm:text-3xl lg:text-3xl font-bold text-slate-800 leading-snug">
                        {{ $villageHead->name ?? 'BANGKIT MANURUNG' }}
                    </h2>

                    <p class="mt-3 text-base sm:text-lg text-slate-500 font-medium">
                        {{ $villageHead->position ?? 'Kepala Desa' }}
                    </p>

                </div>

                {{-- Sambutan --}}
                <div class="mt-8 space-y-5 text-slate-600 text-base sm:text-lg leading-8 max-w-2xl mx-auto lg:mx-0">

                    <p class="text-xl font-semibold text-slate-800">
                        Horas,
                    </p>
                    <!-- <p class="text-xl font-semibold text-slate-800">
                        ᯂᯬᯒᯘ᯲,
                    </p> -->


                    <p>
                        Selamat datang di Website Resmi Desa Dolok Nagodang.
                        Website ini hadir sebagai media informasi, pelayanan publik,
                        dan transparansi pemerintahan desa untuk seluruh masyarakat.
                    </p>

                    <p>
                        Kami berkomitmen menghadirkan pelayanan yang cepat,
                        terbuka, dan modern guna mendukung transformasi digital desa
                        menuju masyarakat yang mandiri dan berdaya saing.
                    </p>

                </div>

                {{-- BUTTON --}}
                <div class="mt-10 flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">

                    <a href="{{ route('public.profile') }}"
                       class="inline-flex items-center justify-center gap-3 rounded-2xl bg-emerald-600 px-8 py-4 text-white font-semibold shadow-lg hover:bg-emerald-700 hover:-translate-y-0.5 transition duration-300">

                        Lihat Profil Desa

                        <i data-lucide="arrow-right" class="w-5 h-5"></i>

                    </a>
                </div>

            </div>

        </div>

    </div>

</section>

{{-- STATISTIK --}}
<section class="py-12 md:py-14 bg-gradient-to-b from-white to-slate-50">

    <div class="max-w-7xl mx-auto px-4">

        {{-- HEADER --}}
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4">

            <div>
                <p class="text-sm font-semibold text-emerald-600">
                    Data Penduduk
                </p>

                <h2 class="mt-1 text-3xl font-bold text-slate-800">
                    Statistik Desa
                </h2>

                <p class="mt-2 text-slate-500">
                    Informasi jumlah penduduk berdasarkan kategori dan dusun.
                </p>
            </div>

            <div class="hidden md:flex w-14 h-14 rounded-2xl bg-emerald-100 items-center justify-center">
                <i data-lucide="bar-chart-3" class="w-7 h-7 text-emerald-600"></i>
            </div>

        </div>

        {{-- CARD UTAMA --}}
        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-5">

            {{-- TOTAL --}}
            <div class="group rounded-3xl bg-white p-6 shadow-sm border border-slate-200 hover:shadow-md transition">

                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-sm text-slate-500">
                            Total Penduduk
                        </p>

                        <h3 class="mt-2 text-3xl font-bold text-slate-800">
                            {{ number_format($totalCitizens) }}
                        </h3>
                    </div>

                    <div class="w-14 h-14 rounded-2xl bg-emerald-50 flex items-center justify-center">
                        <i data-lucide="users" class="w-7 h-7 text-emerald-600"></i>
                    </div>

                </div>

            </div>

            {{-- LAKI --}}
            <div class="group rounded-3xl bg-white p-6 shadow-sm border border-slate-200 hover:shadow-md transition">

                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-sm text-slate-500">
                            Laki-laki
                        </p>

                        <h3 class="mt-2 text-3xl font-bold text-slate-800">
                            {{ number_format($maleCitizens) }}
                        </h3>
                    </div>

                    <div class="w-14 h-14 rounded-2xl bg-sky-50 flex items-center justify-center">
                        <i data-lucide="user" class="w-7 h-7 text-sky-600"></i>
                    </div>

                </div>

            </div>

            {{-- PEREMPUAN --}}
            <div class="group rounded-3xl bg-white p-6 shadow-sm border border-slate-200 hover:shadow-md transition">

                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-sm text-slate-500">
                            Perempuan
                        </p>

                        <h3 class="mt-2 text-3xl font-bold text-slate-800">
                            {{ number_format($femaleCitizens) }}
                        </h3>
                    </div>

                    <div class="w-14 h-14 rounded-2xl bg-pink-50 flex items-center justify-center">
                        <i data-lucide="user-round" class="w-7 h-7 text-pink-600"></i>
                    </div>

                </div>

            </div>

        </div>

        {{-- DUSUN --}}
        <div class="mt-10">

            <div class="flex items-center justify-between mb-5">

                <div>
                    <h3 class="text-xl font-bold text-slate-800">
                        Statistik Per Dusun
                    </h3>

                    <p class="text-sm text-slate-500 mt-1">
                        {{ count($dusunStats) }} dusun terdata
                    </p>
                </div>

            </div>

            {{-- GRID --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

                @forelse ($dusunStats as $dusun)

                    @php
                        $percentage = $totalCitizens > 0
                            ? round(($dusun->total / $totalCitizens) * 100, 1)
                            : 0;
                    @endphp

                    <div class="group rounded-3xl bg-white border border-slate-200 p-4 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300">

                        {{-- ICON --}}
                        <div class="w-12 h-12 rounded-2xl bg-emerald-50 flex items-center justify-center">

                            <i data-lucide="map-pinned" class="w-6 h-6 text-emerald-600"></i>

                        </div>

                        {{-- TEXT --}}
                        <div class="mt-5">

                            <h4 class="text-lg font-bold text-slate-800">
                                {{ $dusun->dusun }}
                            </h4>

                            <p class="mt-1 text-sm text-slate-500">
                                {{ number_format($dusun->total) }} Penduduk
                            </p>

                        </div>

                        {{-- PERCENT --}}
                        <div class="mt-6">

                            <div class="flex items-center justify-between mb-2">

                                <span class="text-sm text-slate-500">
                                    Persentase
                                </span>

                                <span class="text-sm font-bold text-emerald-600">
                                    {{ $percentage }}%
                                </span>

                            </div>

                            <div class="h-2 rounded-full bg-slate-100 overflow-hidden">

                                <div
                                    class="h-full rounded-full bg-gradient-to-r from-emerald-500 to-emerald-600"
                                    style="width: {{ $percentage }}%">
                                </div>

                            </div>

                        </div>

                    </div>

                @empty

                    <div class="col-span-full rounded-3xl border border-dashed border-slate-300 bg-white p-10 text-center">

                        <div class="mx-auto w-14 h-14 rounded-2xl bg-slate-100 flex items-center justify-center">
                            <i data-lucide="database" class="w-6 h-6 text-slate-400"></i>
                        </div>

                        <p class="mt-4 text-slate-500">
                            Statistik dusun belum tersedia.
                        </p>

                    </div>

                @endforelse

            </div>

        </div>

    </div>

</section>

{{-- BERITA --}}
<section class="bg-slate-100/80 py-12 md:py-14">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4">
            <div>
                <p class="text-sm font-semibold text-emerald-700">Informasi Terkini</p>
                <h2 class="mt-1 text-3xl font-bold text-slate-800">Berita Desa</h2>
                <p class="mt-2 text-slate-500">Kabar dan informasi terbaru dari Desa Dolok Nagodang.</p>
            </div>

            <a href="{{ route('public.news.index') }}"
               class="text-sm font-semibold text-emerald-700 hover:text-emerald-800">
                Lihat semua berita →
            </a>
        </div>

        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse ($latestNews as $item)
                <a href="{{ route('public.news.show', $item->slug) }}"
                   class="group rounded-3xl bg-white border border-slate-200 shadow-sm overflow-hidden hover:shadow-lg hover:-translate-y-1 transition">
                    <div class="aspect-video bg-slate-100 overflow-hidden">
                        @if($item->image)
                            <img src="{{ asset('storage/' . $item->image) }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                                 alt="{{ $item->title }}">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-5xl">
                                📰
                            </div>
                        @endif
                    </div>

                    <div class="p-4">
                        <p class="text-xs text-slate-500">
                            {{ $item->published_at ? $item->published_at->locale('id')->translatedFormat('d F Y') : '-' }}
                        </p>
                        <h3 class="mt-2 font-bold text-slate-800 leading-snug">
                            {{ $item->title }}
                        </h3>
                        <p class="mt-2 text-sm text-slate-500 leading-6">
                            {{ \Illuminate\Support\Str::limit(strip_tags($item->content), 110) }}
                        </p>
                    </div>
                </a>
            @empty
                <div class="md:col-span-3 rounded-2xl bg-white border border-slate-200 p-8 text-center text-slate-500">
                    Belum ada berita yang dipublikasikan.
                </div>
            @endforelse
        </div>
    </div>
</section>

{{-- APARAT --}}
<section class="max-w-7xl mx-auto px-4 py-12 md:py-14">
    <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4">
        <div>
            <p class="text-sm font-semibold text-emerald-700">Pemerintahan Desa</p>
            <h2 class="mt-1 text-3xl font-bold text-slate-800">Aparat Desa</h2>
            <p class="mt-2 text-slate-500">Perangkat desa yang melayani masyarakat.</p>
        </div>

        <a href="{{ route('public.officials') }}"
           class="text-sm font-semibold text-emerald-700 hover:text-emerald-800">
            Lihat semua aparat →
        </a>
    </div>

    <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
        @forelse($officials as $official)
            <div class="overflow-hidden rounded-3xl bg-white border border-slate-200 text-center shadow-sm hover:shadow-md transition">
                <div class="h-[300px] md:h-[320px] lg:h-[300px] w-full bg-emerald-100 overflow-hidden flex items-center justify-center text-4xl font-bold text-emerald-700">
                    @if($official->photo)
                        <img src="{{ asset('storage/' . $official->photo) }}"
                             class="w-full h-full object-cover object-top transition duration-500 hover:scale-105"
                             alt="{{ $official->name }}">
                    @else
                        {{ strtoupper(substr($official->name, 0, 1)) }}
                    @endif
                </div>

                <div class="p-5 min-h-[104px] flex flex-col items-center justify-center">
                    <h3 class="font-bold text-slate-800">{{ $official->name }}</h3>
                    <p class="mt-1 text-sm text-emerald-700">{{ $official->position ?? '-' }}</p>
                </div>
            </div>
        @empty
            <div class="md:col-span-4 rounded-2xl bg-white border p-8 text-center text-slate-500">
                Data aparat desa belum tersedia.
            </div>
        @endforelse
    </div>
</section>

{{-- PEMBANGUNAN DESA --}}
<section class="bg-slate-100/80 py-14 md:py-16 overflow-hidden">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- HEADER --}}
        <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-5">

            <div class="max-w-2xl">

                <span class="inline-flex items-center rounded-full bg-emerald-100 px-4 py-2 text-sm font-semibold text-emerald-700">
                    Pembangunan Desa
                </span>

                <h2 class="mt-4 text-3xl md:text-4xl font-bold tracking-tight text-slate-800">
                    Infrastruktur Desa Dolok Nagodang
                </h2>

                <p class="mt-4 text-slate-500 leading-8 text-[15px] md:text-base">
                    Informasi pembangunan, fasilitas desa, dan dokumentasi infrastruktur terbaru.
                </p>

            </div>

            <a href="{{ route('public.infrastruktur.index') }}"
               class="inline-flex items-center gap-2 rounded-2xl bg-emerald-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-emerald-600/20 transition hover:bg-emerald-700">

                Lihat Semua

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-4 w-4"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor"
                     stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>

            </a>

        </div>

        {{-- GRID --}}
        <div class="mt-10 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

            @forelse ($latestInfrastructures as $item)

                <a href="{{ route('public.infrastruktur.show', $item->slug) }}"
                   class="group block overflow-hidden rounded-[28px] border border-slate-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-xl">

                    {{-- IMAGE --}}
                    <div class="relative overflow-hidden">

                        @if($item->image)
                            <img
                                src="{{ asset('storage/' . $item->image) }}"
                                alt="{{ $item->nama_barang }}"
                                class="h-64 w-full object-cover transition duration-500 group-hover:scale-105"
                            >
                        @else
                            <div class="h-64 w-full bg-gradient-to-br from-slate-200 to-slate-100 flex items-center justify-center">
                                <div class="text-center">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         class="mx-auto h-14 w-14 text-slate-400"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor"
                                         stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M3 7l9-4 9 4-9 4-9-4zm0 0v10l9 4 9-4V7" />
                                    </svg>
                                    <p class="mt-3 text-sm text-slate-500">
                                        Foto pembangunan
                                    </p>
                                </div>
                            </div>
                        @endif

                        {{-- BADGE --}}
                        <div class="absolute top-4 left-4">
                            <span class="rounded-full bg-white/90 px-3 py-1 text-xs font-semibold text-slate-700 backdrop-blur">
                                Infrastruktur
                            </span>
                        </div>

                    </div>

                    {{-- CONTENT --}}
                    <div class="p-6">

                        {{-- META --}}
                        <div class="flex items-center gap-2 text-xs text-slate-500">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-4 w-4"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="2">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M8 7V3m8 4V3m-9 8h10m-11 9h12a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v11a2 2 0 002 2z" />
                            </svg>

                            <span>
                                {{ optional($item->created_at)->format('d M Y') }}
                            </span>
                        </div>

                        {{-- TITLE --}}
                        <h3 class="mt-4 text-xl font-bold leading-snug text-slate-800 group-hover:text-emerald-700 transition">
                            {{ $item->nama_barang }}
                        </h3>

                        {{-- DESCRIPTION --}}
                        <p class="mt-3 text-sm leading-7 text-slate-500">
                            {{ \Illuminate\Support\Str::limit(strip_tags($item->content), 120) }}
                        </p>

                        {{-- FOOTER --}}
                        <div class="mt-6 flex items-center justify-between border-t border-slate-100 pt-5">

                            <span class="text-sm font-semibold text-emerald-600 transition group-hover:translate-x-1">
                                Detail
                            </span>

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-4 w-4 text-emerald-600"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>

                        </div>

                    </div>

                </a>

            @empty

                <div class="col-span-full rounded-3xl border border-dashed border-slate-300 bg-white p-10 text-center">

                    <div class="mx-auto w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="w-8 h-8 text-slate-400"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor"
                             stroke-width="1.5">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M3 7l9-4 9 4-9 4-9-4zm0 0v10l9 4 9-4V7" />
                        </svg>
                    </div>

                    <h3 class="mt-5 text-lg font-bold text-slate-700">
                        Belum Ada Data Infrastruktur
                    </h3>

                    <p class="mt-2 text-sm text-slate-500">
                        Data pembangunan desa akan ditampilkan setelah tersedia.
                    </p>

                </div>

            @endforelse

        </div>

    </div>

</section>
{{-- LAYANAN SURAT --}}
<section class="bg-emerald-950 text-white py-12 md:py-14">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4">
            <div>
                <p class="text-sm font-semibold text-emerald-200">Pelayanan Administrasi</p>
                <h2 class="mt-1 text-3xl font-bold">Layanan Surat Desa</h2>
                <p class="mt-2 text-emerald-100">Jenis surat yang tersedia untuk kebutuhan administrasi warga.</p>
            </div>

            <a href="{{ route('public.letters') }}"
               class="inline-flex rounded-xl bg-white px-5 py-3 text-sm font-semibold text-emerald-800 hover:bg-emerald-50 transition">
                Lihat Layanan
            </a>
        </div>

        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-4">
            @forelse ($letterTypes as $type)
                <div class="rounded-2xl bg-white/10 border border-white/10 p-4 hover:bg-white/15 transition">
                    <div class="text-3xl">📄</div>
                    <h3 class="mt-3 font-bold">{{ $type->name }}</h3>
                    <p class="mt-2 text-sm text-emerald-100 leading-6">
                        Silakan hubungi kantor desa untuk proses administrasi surat.
                    </p>
                </div>
            @empty
                <div class="md:col-span-3 rounded-2xl bg-white/10 border border-white/10 p-8 text-center text-emerald-100">
                    Layanan surat belum tersedia.
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
@push('styles')
<style>
    .heroSwiper .swiper-pagination-bullet {
        width: 10px;
        height: 10px;
        background: rgba(255, 255, 255, 0.75);
        opacity: 1;
    }

    .heroSwiper .swiper-pagination-bullet-active {
        width: 28px;
        border-radius: 999px;
        background: #10b981;
    }
</style>
@endpush
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    if (typeof Swiper === 'undefined') {
        console.error('Swiper belum ter-load. Cek resources/js/app.js dan npm run build.');
        return;
    }

    const heroSwiper = new Swiper('.heroSwiper', {
        loop: true,
        slidesPerView: 1,
        speed: 800,

        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },

        navigation: {
            nextEl: '.hero-next',
            prevEl: '.hero-prev',
        },

        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
    });

    console.log('Hero Swiper aktif:', heroSwiper);
});
</script>
@endpush

