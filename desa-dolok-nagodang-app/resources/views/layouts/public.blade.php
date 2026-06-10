<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Website Desa Dolok Nagodang' }}</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
          content="{{ $description ?? 'Website resmi Desa Dolok Nagodang sebagai pusat informasi dan pelayanan masyarakat.' }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')

    {{-- GOOGLE FONT --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- LUCIDE ICON --}}
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Inter', sans-serif;
        }

        .fade-up {
            opacity: 0;
            transform: translateY(25px);
            transition: all .7s ease;
        }

        .fade-up.show {
            opacity: 1;
            transform: translateY(0);
        }

        .glass {
            background: rgba(255,255,255,.7);
            backdrop-filter: blur(12px);
        }

        .mobile-scroll::-webkit-scrollbar {
            display: none;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800 overflow-x-hidden">

{{-- ================= HEADER ================= --}}
<header class="sticky top-0 z-[999] bg-white/90 backdrop-blur-xl border-b border-slate-200/80 shadow-sm">

    {{-- NAVIGATION --}}
    @php
        $navItems = [
            [
                'label' => 'Beranda',
                'route' => 'public.home',
                'active' => 'public.home',
                'icon' => 'home',
            ],
            [
                'label' => 'Profil',
                'route' => 'public.profile',
                'active' => 'public.profile',
                'icon' => 'building-2',
            ],
            [
                'label' => 'Berita',
                'route' => 'public.news.index',
                'active' => 'public.news.*',
                'icon' => 'newspaper',
            ],
            [
                'label' => 'Aparat',
                'route' => 'public.officials',
                'active' => 'public.officials',
                'icon' => 'users',
            ],
            [
                'label' => 'Layanan',
                'route' => 'public.letters',
                'active' => 'public.letters*',
                'icon' => 'file-text',
            ],
            [
                'label' => 'Infrastruktur',
                'route' => 'public.infrastruktur.index',
                'active' => 'public.infrastruktur*',
                'icon' => 'construction',
            ],
        ];
    @endphp

    <div class="w-full px-4 lg:px-8 xl:px-10">

        <div class="h-20 flex items-center gap-6">

            {{-- LOGO --}}
            <a href="{{ route('public.home') }}"
               class="flex items-center gap-3 shrink-0">

                <div class="w-12 h-12 rounded-2xl bg-white border border-slate-200 shadow-sm overflow-hidden flex items-center justify-center">

                    <img
                        src="{{ asset('images/logo.png') }}"
                        alt="Logo Desa"
                        class="w-full h-full object-contain">

                </div>

                <div class="leading-tight hidden sm:block">

                    <h1 class="text-sm md:text-base font-bold text-slate-800">
                        Desa Dolok Nagodang
                    </h1>

                    <p class="text-xs text-slate-500">
                        Kabupaten Toba • Sumatera Utara
                    </p>

                </div>

            </a>

            {{-- DESKTOP MENU --}}
            <div class="hidden lg:flex flex-1 justify-end">

                <nav class="flex items-center gap-2">

                    @foreach ($navItems as $item)

                        <a href="{{ route($item['route']) }}"
                           class="relative px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-300

                           {{ request()->routeIs($item['active'])
                                ? 'bg-emerald-600 text-white shadow-md'
                                : 'text-slate-700 hover:bg-slate-100 hover:text-emerald-700'
                           }}">

                            {{ $item['label'] }}

                        </a>

                    @endforeach

                </nav>

            </div>

            {{-- MOBILE BUTTON --}}
            <button
                id="menuBtn"
                class="lg:hidden ml-auto w-11 h-11 rounded-2xl border border-slate-200 bg-white shadow-sm flex items-center justify-center">

                <i data-lucide="menu" class="w-5 h-5"></i>

            </button>

        </div>

    </div>

    {{-- MOBILE MENU --}}
    <div id="mobileMenu"
         class="hidden lg:hidden border-t border-slate-200 bg-white">

        <div class="px-4 py-5 space-y-2 max-h-[80vh] overflow-y-auto mobile-scroll">

            @foreach ($navItems as $item)

                <a href="{{ route($item['route']) }}"
                   class="flex items-center gap-3 rounded-2xl px-4 py-4 text-sm font-semibold transition

                   {{ request()->routeIs($item['active'])
                        ? 'bg-emerald-600 text-white'
                        : 'text-slate-700 hover:bg-slate-100'
                   }}">

                    <i data-lucide="{{ $item['icon'] }}" class="w-5 h-5"></i>

                    {{ $item['label'] }}

                </a>

            @endforeach

        </div>

    </div>

</header>


{{-- ================= MAIN ================= --}}
<main class="min-h-screen">
    @yield('content')
</main>

{{-- ================= FOOTER ================= --}}
<footer class="relative overflow-hidden bg-slate-950 text-slate-300 mt-4">

    {{-- BACKGROUND --}}
    <div class="absolute inset-0 opacity-10">
        <div class="absolute -top-20 -left-20 w-72 h-72 bg-emerald-500 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-80 h-80 bg-cyan-500 rounded-full blur-3xl"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 lg:px-6 py-10">

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

            {{-- PROFILE --}}
            <div class="xl:col-span-2">

                <div class="flex items-center gap-4">

                    <div class="w-12 h-12 rounded-2xl bg-white overflow-hidden flex items-center justify-center shadow-sm">
                        <img
                            src="{{ asset('images/logo.png') }}"
                            alt="Logo Desa"
                            class="w-full h-full object-contain"
                        >
                    </div>

                    <div>
                        <h3 class="text-lg font-bold text-white">
                            Desa Dolok Nagodang
                        </h3>

                        <p class="text-sm text-slate-400">
                            Kabupaten Toba
                        </p>
                    </div>

                </div>

                <p class="mt-4 text-sm leading-7 text-slate-400 max-w-xl">
                    Website resmi Pemerintah Desa Dolok Nagodang sebagai pusat informasi,
                    pelayanan administrasi, berita desa, dan transparansi publik
                    kepada masyarakat.
                </p>

            </div>

            {{-- MENU --}}
            <div>

                <h3 class="text-white font-bold text-base">
                    Menu Utama
                </h3>

                <div class="mt-4 space-y-2.5 text-sm">

                    <a href="{{ route('public.home') }}"
                       class="flex items-center gap-2 text-slate-400 hover:text-white transition">

                        <i data-lucide="chevron-right" class="w-4 h-4"></i>

                        Beranda

                    </a>

                    <a href="{{ route('public.profile') }}"
                       class="flex items-center gap-2 text-slate-400 hover:text-white transition">

                        <i data-lucide="chevron-right" class="w-4 h-4"></i>

                        Profil Desa

                    </a>

                    <a href="{{ route('public.news.index') }}"
                       class="flex items-center gap-2 text-slate-400 hover:text-white transition">

                        <i data-lucide="chevron-right" class="w-4 h-4"></i>

                        Berita Desa

                    </a>

                    <a href="{{ route('public.letters') }}"
                       class="flex items-center gap-2 text-slate-400 hover:text-white transition">

                        <i data-lucide="chevron-right" class="w-4 h-4"></i>

                        Layanan Surat

                    </a>

                </div>

            </div>

            {{-- CONTACT --}}
            <div>

                <h3 class="text-white font-bold text-base">
                    Informasi Desa
                </h3>

                <div class="mt-4 space-y-3 text-sm">

                    {{-- ALAMAT --}}
                    <div class="flex gap-3">

                        <div class="w-9 h-9 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center shrink-0">

                            <i data-lucide="map-pin" class="w-4 h-4 text-emerald-400"></i>

                        </div>

                        <div>
                            <p class="font-semibold text-white">
                                Alamat
                            </p>

                            <p class="text-slate-400 leading-6">
                                Desa Dolok Nagodang, Kecamatan Uluan, Kabupaten Toba
                            </p>
                        </div>

                    </div>

                    {{-- JAM --}}
                    <div class="flex gap-3">

                        <div class="w-9 h-9 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center shrink-0">

                            <i data-lucide="clock-3" class="w-4 h-4 text-emerald-400"></i>

                        </div>

                        <div>
                            <p class="font-semibold text-white">
                                Jam Layanan
                            </p>

                            <p class="text-slate-400">
                                Senin - Jumat, 08.00 - 15.00 WIB
                            </p>
                        </div>

                    </div>

                    {{-- TELEPON --}}
                    <div class="flex gap-3">

                        <div class="w-9 h-9 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center shrink-0">

                            <i data-lucide="phone" class="w-4 h-4 text-emerald-400"></i>

                        </div>

                        <div>
                            <p class="font-semibold text-white">
                                Telepon
                            </p>

                            <p class="text-slate-400">
                                08xxxxxxxxxx
                            </p>
                        </div>

                    </div>

                    {{-- EMAIL --}}
                    <div class="flex gap-3">

                        <div class="w-9 h-9 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center shrink-0">

                            <i data-lucide="mail" class="w-4 h-4 text-emerald-400"></i>

                        </div>

                        <div>
                            <p class="font-semibold text-white">
                                Email
                            </p>

                            <p class="text-slate-400">
                                desa@email.com
                            </p>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- COPYRIGHT --}}
    <div class="border-t border-white/10">

        <div class="max-w-7xl mx-auto px-4 lg:px-6 py-3 flex flex-col items-center justify-center gap-1 text-sm text-slate-500 text-center">

            <p>
                © {{ date('Y') }} Pemerintah Desa Dolok Nagodang
            </p>

            <p>
                Design & Development by
                <span class="font-semibold text-white">
                    Marsidapari 
                </span>
            </p>

        </div>

    </div>

</footer>

{{-- ================= VISITOR STATS ================= --}}
@if(isset($visitorStats))

<div class="fixed left-4 bottom-4 z-50 hidden lg:block group">

    {{-- DETAIL --}}
    <div class="absolute bottom-20 left-0 w-72 rounded-2xl bg-slate-900/95 border border-white/10 text-white p-4 shadow-2xl backdrop-blur-xl
                opacity-0 invisible translate-y-2
                group-hover:opacity-100
                group-hover:visible
                group-hover:translate-y-0
                transition-all duration-300">

        <div class="flex items-center justify-between mb-4">

            <h3 class="font-semibold text-base">
                Statistik Pengunjung
            </h3>

            <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center">
                <i data-lucide="activity" class="w-4 h-4 text-emerald-400"></i>
            </div>

        </div>

        <div class="space-y-2 text-sm">

            @php
                $stats = [
                    'Hari Ini' => $visitorStats['today'] ?? 0,
                    'Kemarin' => $visitorStats['yesterday'] ?? 0,
                    'Minggu Ini' => $visitorStats['this_week'] ?? 0,
                    'Minggu Lalu' => $visitorStats['last_week'] ?? 0,
                    'Bulan Ini' => $visitorStats['this_month'] ?? 0,
                    'Bulan Lalu' => $visitorStats['last_month'] ?? 0,
                ];
            @endphp

            @foreach($stats as $label => $value)

                <div class="flex justify-between border-b border-white/10 pb-2">

                    <span class="text-slate-300">
                        {{ $label }}
                    </span>

                    <span class="font-semibold">
                        {{ number_format($value) }}
                    </span>

                </div>

            @endforeach

            <div class="flex justify-between pt-2">

                <span class="font-semibold">
                    Total
                </span>

                <span class="font-bold text-emerald-400">
                    {{ number_format($visitorStats['total'] ?? 0) }}
                </span>

            </div>

        </div>

    </div>

   {{-- MINI VISITOR --}}
<div class="h-14 min-w-[250px] bg-emerald-500 text-white rounded-2xl shadow-xl shadow-emerald-900/10 px-5 cursor-pointer border border-emerald-400/70">

    <div class="h-full flex items-center justify-center gap-3">

        <i data-lucide="users" class="w-5 h-5"></i>

        <span class="text-sm font-semibold text-emerald-50 whitespace-nowrap">
            Pengunjung Hari Ini
        </span>

        <span class="font-bold text-lg leading-none">
            {{ number_format($visitorStats['today'] ?? 0) }}
        </span>

    </div>

</div>

</div>

@endif

{{-- ================= FLOATING COMPLAINT ================= --}}
<div class="fixed right-4 bottom-4 z-50">

    <button
        type="button"
        onclick="toggleComplaintPanel()"
        class="w-14 h-14 md:w-[190px] md:h-14
               md:px-5
               rounded-2xl
               bg-rose-400 hover:bg-rose-500
               text-white
               shadow-xl shadow-rose-900/10
               border border-rose-300/80
               flex items-center justify-center
               transition-all duration-300">

        <i data-lucide="headphones" class="w-5 h-5 md:hidden"></i>

        <div class="hidden md:flex h-full w-full flex-col items-center justify-center text-center">

            <p class="text-sm font-semibold leading-tight text-rose-50">
                Layanan
            </p>

            <p class="text-sm font-semibold leading-tight text-white">
                Pengaduan
            </p>

        </div>

    </button>

</div>

{{-- ================= PANEL PENGADUAN ================= --}}
<div id="complaintPanel"
     class="hidden fixed
            right-4
            bottom-20
            z-[999]
            w-[calc(100vw-24px)]
            sm:w-[360px]
            md:w-[380px]
            rounded-3xl
            bg-white
            border border-slate-200
            shadow-2xl
            overflow-hidden">

    {{-- HEADER --}}
    <div class="bg-gradient-to-r from-emerald-700 to-emerald-600 text-white px-6 py-5 flex items-start justify-between gap-4">

        <div>
            <h3 class="text-lg font-bold">
                Form Pengaduan
            </h3>

            <p class="text-sm text-emerald-100 mt-1">
                Sampaikan aspirasi atau laporan masyarakat.
            </p>
        </div>

        <button
            type="button"
            onclick="toggleComplaintPanel()"
            class="w-9 h-9 rounded-xl bg-white/10 hover:bg-white/20 flex items-center justify-center">

            <i data-lucide="x" class="w-4 h-4"></i>

        </button>

    </div>

    {{-- BODY --}}
    <form
        method="POST"
        action="{{ route('public.complaints.store') }}"
        enctype="multipart/form-data"
        class="p-4 sm:p-5 space-y-4 max-h-[70vh] overflow-y-auto">

        @csrf

        @if(session('complaint_success'))

            <div class="rounded-2xl bg-emerald-50 border border-emerald-200 px-4 py-3 text-sm text-emerald-700">
                {{ session('complaint_success') }}
            </div>

        @endif

        @if ($errors->any())

            <div class="rounded-2xl bg-rose-50 border border-rose-200 px-4 py-3 text-sm text-rose-700">

                <p class="font-semibold">
                    Pengaduan belum bisa dikirim.
                </p>

                <ul class="mt-2 list-disc list-inside space-y-1">

                    @foreach ($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif

        {{-- INPUT --}}
        <div>
            <label class="block text-sm font-semibold mb-2">
                Nama
            </label>

            <input
                type="text"
                name="name"
                value="{{ old('name') }}"
                class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                placeholder="Masukkan nama">
        </div>

        <div>
            <label class="block text-sm font-semibold mb-2">
                Nomor Telepon
            </label>

            <input
                type="text"
                name="phone"
                value="{{ old('phone') }}"
                class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                placeholder="08xxxxxxxxxx">
        </div>

        <div>
            <label class="block text-sm font-semibold mb-2">
                Kategori
            </label>

            <select
                name="category"
                class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none">

                <option value="">Pilih kategori</option>

                @foreach (['Umum', 'Sosial', 'Keamanan', 'Kesehatan', 'Kebersihan', 'Permintaan'] as $category)

                    <option value="{{ $category }}"
                        {{ old('category') === $category ? 'selected' : '' }}>

                        {{ $category }}

                    </option>

                @endforeach

            </select>
        </div>

        <div>
            <label class="block text-sm font-semibold mb-2">
                Pengaduan
            </label>

            <textarea
                name="message"
                rows="5"
                class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm leading-7 focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                placeholder="Masukkan isi pengaduan">{{ old('message') }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-semibold mb-2">
                Lampiran
            </label>

            <input
                type="file"
                name="attachment"
                class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm">
        </div>

        <button
            type="submit"
            class="w-full rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white py-3 font-semibold transition">

            Kirim Pengaduan

        </button>

    </form>

</div>

{{-- ================= SCRIPT ================= --}}
<script>

    document.addEventListener("DOMContentLoaded", function () {
        lucide.createIcons();
    });

    // MOBILE MENU
    const menuBtn = document.getElementById('menuBtn');
    const mobileMenu = document.getElementById('mobileMenu');

    if (menuBtn) {
        menuBtn.addEventListener('click', function () {
            mobileMenu.classList.toggle('hidden');
        });
    }

    // COMPLAINT PANEL
    function toggleComplaintPanel() {

        const panel = document.getElementById('complaintPanel');

        if (!panel) return;

        panel.classList.toggle('hidden');
    }

    // AUTO OPEN
    document.addEventListener('DOMContentLoaded', function () {

        const hasComplaintFeedback =
            @json(session()->has('complaint_success') || $errors->any());

        if (hasComplaintFeedback) {

            document
                .getElementById('complaintPanel')
                ?.classList.remove('hidden');

        }

    });

    // ANIMATION
    document.addEventListener("DOMContentLoaded", () => {

        const elements = document.querySelectorAll(".fade-up");

        const observer = new IntersectionObserver(entries => {

            entries.forEach(entry => {

                if (entry.isIntersecting) {
                    entry.target.classList.add("show");
                }

            });

        }, {
            threshold: 0.1
        });

        elements.forEach(el => observer.observe(el));

    });

</script>

@stack('scripts')

</body>
</html>
