@extends('layouts.public')

@section('content')
{{-- HERO --}}
{{-- HERO SLIDER --}}
<section class="relative">

    <div class="swiper heroSwiper h-[700px]">

        <div class="swiper-wrapper">

            {{-- SLIDE 1 --}}
            <div class="swiper-slide relative">
                <img
                    src="{{ asset('storage/sliders/dusun1.jpg') }}"
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
                    src="{{ asset('storage/sliders/dusun2.jpg') }}"
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
                    src="{{ asset('storage/sliders/dusun3.jpg') }}"
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

        {{-- PAGINATION --}}
        <div class="swiper-pagination"></div>

    </div>

</section>

{{-- QUICK MENU --}}
<section class="max-w-7xl mx-auto px-4 -mt-12 relative z-10">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @php
            $menus = [
                ['label' => 'Profil Desa', 'desc' => 'Informasi wilayah', 'icon' => '🏘️', 'url' => route('public.profile')],
                ['label' => 'Berita Desa', 'desc' => number_format($totalPublishedNews ?? 0) . ' berita tayang', 'icon' => '📰', 'url' => route('public.news.index')],
                ['label' => 'Aparat Desa', 'desc' => 'Struktur perangkat', 'icon' => '👥', 'url' => route('public.officials')],
                ['label' => 'Layanan Surat', 'desc' => number_format($totalLetterTypes ?? 0) . ' jenis layanan', 'icon' => '📄', 'url' => route('public.letters')],
            ];
        @endphp

        @foreach ($menus as $menu)
            <a href="{{ $menu['url'] }}"
               class="group rounded-3xl bg-white p-5 shadow-sm border border-slate-200 hover:shadow-lg hover:-translate-y-1 transition">
                <div class="w-14 h-14 rounded-2xl bg-emerald-50 flex items-center justify-center text-3xl group-hover:bg-emerald-100 transition">
                    {{ $menu['icon'] }}
                </div>
                <p class="mt-4 font-bold text-slate-800">{{ $menu['label'] }}</p>
                <p class="mt-1 text-xs text-slate-500">{{ $menu['desc'] }}</p>
            </a>
        @endforeach
    </div>
</section>

{{-- INFORMASI CEPAT --}}
<section class="max-w-7xl mx-auto px-4 py-12">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-5">
        <div class="rounded-3xl bg-white border border-slate-200 p-6 shadow-sm">
            <div class="w-12 h-12 rounded-2xl bg-emerald-100 flex items-center justify-center text-2xl">
                🕘
            </div>
            <p class="mt-4 text-sm text-slate-500">Jam Layanan</p>
            <h3 class="mt-1 font-bold text-slate-800">Senin - Jumat</h3>
            <p class="mt-1 text-sm text-slate-500">08.00 - 15.00 WIB</p>
        </div>

        <div class="rounded-3xl bg-white border border-slate-200 p-6 shadow-sm">
            <div class="w-12 h-12 rounded-2xl bg-sky-100 flex items-center justify-center text-2xl">
                📍
            </div>
            <p class="mt-4 text-sm text-slate-500">Lokasi</p>
            <h3 class="mt-1 font-bold text-slate-800">Dolok Nagodang</h3>
            <p class="mt-1 text-sm text-slate-500">Kec. Uluan, Kab. Toba</p>
        </div>

        <div class="rounded-3xl bg-white border border-slate-200 p-6 shadow-sm">
            <div class="w-12 h-12 rounded-2xl bg-amber-100 flex items-center justify-center text-2xl">
                📰
            </div>
            <p class="mt-4 text-sm text-slate-500">Berita Tayang</p>
            <h3 class="mt-1 font-bold text-slate-800">
                {{ number_format($totalPublishedNews ?? 0) }} Berita
            </h3>
            <a href="{{ route('public.news.index') }}" class="mt-2 inline-flex text-sm font-semibold text-emerald-700">
                Lihat berita →
            </a>
        </div>

        <div class="rounded-3xl bg-white border border-slate-200 p-6 shadow-sm">
            <div class="w-12 h-12 rounded-2xl bg-violet-100 flex items-center justify-center text-2xl">
                📄
            </div>
            <p class="mt-4 text-sm text-slate-500">Layanan Surat</p>
            <h3 class="mt-1 font-bold text-slate-800">
                {{ number_format($totalLetterTypes ?? 0) }} Jenis Layanan
            </h3>
            <a href="{{ route('public.letters') }}" class="mt-2 inline-flex text-sm font-semibold text-emerald-700">
                Lihat layanan →
            </a>
        </div>
    </div>
</section>

{{-- SAMBUTAN + STATISTIK --}}
<section class="max-w-7xl mx-auto px-4 py-16">
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
        <div class="lg:col-span-2 rounded-3xl bg-white border border-slate-200 p-8 shadow-sm">
            <p class="text-sm font-semibold text-emerald-700">Sambutan Kepala Desa</p>

            <div class="mt-5 flex items-center gap-5">
                <div class="w-20 h-20 rounded-2xl bg-emerald-100 overflow-hidden flex items-center justify-center text-3xl font-bold text-emerald-700 shrink-0">
                    @if(!empty($villageHead?->photo))
                        <img src="{{ asset('storage/' . $villageHead->photo) }}"
                             class="w-full h-full object-cover"
                             alt="{{ $villageHead->name }}">
                    @else
                        {{ $villageHead ? strtoupper(substr($villageHead->name, 0, 1)) : 'K' }}
                    @endif
                </div>

                <div>
                    <h2 class="text-2xl font-bold text-slate-800">
                        {{ $villageHead->name ?? 'Kepala Desa Dolok Nagodang' }}
                    </h2>
                    <p class="mt-1 text-sm text-slate-500">
                        {{ $villageHead->position ?? 'Kepala Desa' }}
                    </p>
                </div>
            </div>

            <p class="mt-6 text-slate-600 leading-7">
                Selamat datang di Website Resmi Desa Dolok Nagodang. Website ini hadir sebagai media informasi,
                pelayanan, dan transparansi desa untuk seluruh masyarakat.
            </p>

            <a href="{{ route('public.profile') }}"
               class="mt-6 inline-flex font-semibold text-sm text-emerald-700 hover:text-emerald-800">
                Lihat profil desa →
            </a>
        </div>

        <div class="lg:col-span-3 rounded-3xl bg-white border border-slate-200 p-8 shadow-sm">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="text-sm font-semibold text-emerald-700">Data Penduduk</p>
                    <h2 class="mt-1 text-2xl font-bold text-slate-800">Statistik Penduduk</h2>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-emerald-100 flex items-center justify-center text-2xl">
                    📊
                </div>
            </div>

            <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="rounded-2xl bg-emerald-50 p-5">
                    <p class="text-sm text-slate-500">Total Penduduk</p>
                    <h3 class="mt-2 text-3xl font-bold text-slate-800">{{ number_format($totalCitizens) }}</h3>
                </div>

                <div class="rounded-2xl bg-sky-50 p-5">
                    <p class="text-sm text-slate-500">Laki-laki</p>
                    <h3 class="mt-2 text-3xl font-bold text-slate-800">{{ number_format($maleCitizens) }}</h3>
                </div>

                <div class="rounded-2xl bg-pink-50 p-5">
                    <p class="text-sm text-slate-500">Perempuan</p>
                    <h3 class="mt-2 text-3xl font-bold text-slate-800">{{ number_format($femaleCitizens) }}</h3>
                </div>
            </div>

            <div class="mt-6 space-y-4">
                @forelse ($dusunStats as $dusun)
                    @php
                        $percentage = $totalCitizens > 0
                            ? round(($dusun->total / $totalCitizens) * 100, 1)
                            : 0;
                    @endphp

                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5">
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <p class="font-semibold text-slate-800">{{ $dusun->dusun }}</p>
                                <p class="mt-1 text-sm text-slate-500">
                                    {{ number_format($dusun->total) }} penduduk
                                </p>
                            </div>

                            <div class="text-right">
                                <p class="text-xl font-bold text-emerald-700">
                                    {{ $percentage }}%
                                </p>
                                <p class="text-xs text-slate-500">dari total</p>
                            </div>
                        </div>

                        <div class="mt-4 h-3 w-full rounded-full bg-slate-200 overflow-hidden">
                            <div
                                class="h-full rounded-full bg-emerald-600"
                                style="width: {{ $percentage }}%">
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="rounded-2xl border bg-slate-50 p-5 text-sm text-slate-500">
                        Statistik dusun belum tersedia.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</section>

{{-- BERITA --}}
<section class="bg-slate-100/80 py-16">
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

                    <div class="p-5">
                        <p class="text-xs text-slate-500">
                            {{ $item->published_at ? $item->published_at->format('d M Y') : '-' }}
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
<section class="max-w-7xl mx-auto px-4 py-16">
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

    <div class="mt-8 grid grid-cols-2 md:grid-cols-4 gap-6">
        @forelse($officials as $official)
            <div class="rounded-3xl bg-white border border-slate-200 p-6 text-center shadow-sm hover:shadow-md transition">
                <div class="mx-auto w-24 h-24 rounded-full bg-emerald-100 overflow-hidden flex items-center justify-center text-2xl font-bold text-emerald-700">
                    @if($official->photo)
                        <img src="{{ asset('storage/' . $official->photo) }}"
                             class="w-full h-full object-cover"
                             alt="{{ $official->name }}">
                    @else
                        {{ strtoupper(substr($official->name, 0, 1)) }}
                    @endif
                </div>

                <h3 class="mt-4 font-bold text-slate-800">{{ $official->name }}</h3>
                <p class="mt-1 text-sm text-emerald-700">{{ $official->position ?? '-' }}</p>
            </div>
        @empty
            <div class="md:col-span-4 rounded-2xl bg-white border p-8 text-center text-slate-500">
                Data aparat desa belum tersedia.
            </div>
        @endforelse
    </div>
</section>

{{-- LAYANAN SURAT --}}
<section class="bg-emerald-950 text-white py-16">
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

        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-5">
            @forelse ($letterTypes as $type)
                <div class="rounded-2xl bg-white/10 border border-white/10 p-5 hover:bg-white/15 transition">
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
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    new Swiper('.heroSwiper', {
        modules: [
            window.SwiperModules.Navigation,
            window.SwiperModules.Pagination,
            window.SwiperModules.Autoplay
        ],

        loop: true,

        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },

        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
    });

});
</script>
@endpush