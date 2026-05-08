<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Website Desa Dolok Nagodang' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $description ?? 'Website resmi Desa Dolok Nagodang sebagai pusat informasi dan pelayanan masyarakat.' }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- ANIMASI --}}
    <style>
        .fade-up {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.6s ease;
        }
        .fade-up.show {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800">

    {{-- ================= HEADER ================= --}}
    <header class="sticky top-0 z-50 bg-white/90 backdrop-blur border-b border-slate-200 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">

            {{-- LOGO --}}
            <a href="{{ route('public.home') }}" class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-600 flex items-center justify-center text-white font-bold">
                    D
                </div>
                <div>
                    <p class="text-sm font-bold text-slate-800">Desa Dolok Nagodang</p>
                    <p class="text-xs text-slate-500">Kabupaten Toba</p>
                </div>
            </a>

            {{-- NAV DESKTOP --}}
            <!-- <nav class="hidden md:flex items-center gap-6 text-sm font-medium text-slate-700">
                <a href="{{ route('public.home') }}" class="hover:text-emerald-600 transition">Beranda</a>
                <a href="{{ route('public.profile') }}" class="hover:text-emerald-600 transition">Profil</a>
                <a href="{{ route('public.news.index') }}" class="hover:text-emerald-600 transition">Berita</a>
                <a href="{{ route('public.officials') }}" class="hover:text-emerald-600 transition">Aparat</a>
                <a href="{{ route('public.letters') }}" class="hover:text-emerald-600 transition">Layanan</a>
            </nav> -->

            @php
                $navItems = [
                    ['label' => 'Beranda', 'route' => 'public.home', 'active' => 'public.home'],
                    ['label' => 'Profil', 'route' => 'public.profile', 'active' => 'public.profile'],
                    ['label' => 'Berita', 'route' => 'public.news.index', 'active' => 'public.news.*'],
                    ['label' => 'Aparat', 'route' => 'public.officials', 'active' => 'public.officials'],
                    ['label' => 'Layanan', 'route' => 'public.letters', 'active' => 'public.letters*'],
                ];
            @endphp

            <nav class="hidden md:flex items-center gap-6 text-sm font-medium">
                @foreach ($navItems as $item)
                    <a href="{{ route($item['route']) }}"
                    class="{{ request()->routeIs($item['active'])
                            ? 'text-emerald-600 font-bold'
                            : 'text-slate-700 hover:text-emerald-600' }} transition">
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </nav>

            {{-- CTA --}}
            <div class="hidden md:flex items-center gap-3">
                <a href="{{ route('login') }}"
                   class="rounded-xl border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100">
                    Login
                </a>

                <a href="{{ route('public.letters') }}"
                   class="rounded-xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700">
                    Ajukan Surat
                </a>
            </div>

            {{-- MOBILE MENU BUTTON --}}
            <button id="menuBtn" class="md:hidden text-2xl">
                ☰
            </button>
        </div>

        {{-- MOBILE MENU --}}
        <!-- <div id="mobileMenu" class="hidden md:hidden border-t bg-white">
            <div class="px-4 py-4 space-y-3 text-sm">
                <a href="{{ route('public.home') }}" class="block">Beranda</a>
                <a href="{{ route('public.profile') }}" class="block">Profil</a>
                <a href="{{ route('public.news.index') }}" class="block">Berita</a>
                <a href="{{ route('public.officials') }}" class="block">Aparat</a>
                <a href="{{ route('public.letters') }}" class="block">Layanan</a>
                <a href="{{ route('login') }}" class="block text-emerald-600 font-semibold">Login</a>
            </div>
        </div> -->
        <div id="mobileMenu" class="hidden md:hidden border-t bg-white">
            <div class="px-4 py-4 space-y-2 text-sm">
                @foreach ($navItems as $item)
                    <a href="{{ route($item['route']) }}"
                    class="block rounded-xl px-4 py-3 {{ request()->routeIs($item['active'])
                            ? 'bg-emerald-50 text-emerald-700 font-bold'
                            : 'text-slate-700 hover:bg-slate-50' }}">
                        {{ $item['label'] }}
                    </a>
                @endforeach

                <a href="{{ route('login') }}"
                class="block rounded-xl px-4 py-3 text-emerald-700 font-semibold bg-emerald-50">
                    Login Admin
                </a>
            </div>
        </div>
    </header>

    {{-- ================= MAIN ================= --}}
    <main>
        @yield('content')
    </main>

    {{-- ================= FOOTER ================= --}}
    <!-- <footer class="bg-slate-900 text-slate-300 mt-16">
        <div class="max-w-7xl mx-auto px-4 py-12 grid grid-cols-1 md:grid-cols-3 gap-8">

            <div>
                <h3 class="text-white font-bold text-lg">Desa Dolok Nagodang</h3>
                <p class="mt-3 text-sm leading-6">
                    Website resmi desa sebagai pusat informasi dan pelayanan masyarakat.
                </p>
            </div>

            <div>
                <h3 class="text-white font-semibold">Menu</h3>
                <ul class="mt-3 space-y-2 text-sm">
                    <li><a href="/" class="hover:text-white">Beranda</a></li>
                    <li><a href="{{ route('public.news.index') }}" class="hover:text-white">Berita</a></li>
                    <li><a href="{{ route('public.letters') }}" class="hover:text-white">Layanan</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-white font-semibold">Kontak</h3>
                <p class="mt-3 text-sm leading-6">
                    📍 Desa Dolok Nagodang<br>
                    📞 08xxxxxxxxxx<br>
                    ✉ desa@email.com
                </p>
            </div>
        </div>

        <div class="border-t border-slate-800 text-center text-sm py-4">
            © {{ date('Y') }} Desa Dolok Nagodang. All rights reserved.
        </div>
    </footer> -->

    <footer class="bg-slate-950 text-slate-300 mt-16">
        <div class="max-w-7xl mx-auto px-4 py-12 grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="md:col-span-2">
                <h3 class="text-white font-bold text-lg">Desa Dolok Nagodang</h3>
                <p class="mt-3 text-sm leading-6 max-w-md">
                    Website resmi desa sebagai pusat informasi, pelayanan administrasi,
                    berita kegiatan, dan transparansi Pemerintah Desa Dolok Nagodang.
                </p>
            </div>

            <div>
                <h3 class="text-white font-semibold">Menu Utama</h3>
                <ul class="mt-3 space-y-2 text-sm">
                    <li><a href="{{ route('public.home') }}" class="hover:text-white">Beranda</a></li>
                    <li><a href="{{ route('public.profile') }}" class="hover:text-white">Profil Desa</a></li>
                    <li><a href="{{ route('public.news.index') }}" class="hover:text-white">Berita Desa</a></li>
                    <li><a href="{{ route('public.letters') }}" class="hover:text-white">Layanan Surat</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-white font-semibold">Kontak Desa</h3>
                <div class="mt-3 space-y-2 text-sm leading-6">
                    <p>📍 Desa Dolok Nagodang, Kec. Uluan, Kab. Toba</p>
                    <p>🕘 Senin - Jumat, 08.00 - 15.00</p>
                    <p>📞 08xxxxxxxxxx</p>
                    <p>✉ desa@email.com</p>
                </div>
            </div>
        </div>

        <div class="border-t border-slate-800 py-4 text-center text-xs text-slate-500">
            © {{ date('Y') }} Desa Dolok Nagodang. Dikelola oleh Pemerintah Desa.
        </div>
    </footer>

    @if(isset($visitorStats))
        <div class="fixed left-5 bottom-6 z-50 hidden lg:block group">
            {{-- Detail --}}
            <div class="absolute bottom-20 left-0 w-80 rounded-2xl bg-slate-900/90 text-white border border-white/20 shadow-2xl backdrop-blur p-5
                        opacity-0 translate-y-3 pointer-events-none group-hover:opacity-100 group-hover:translate-y-0 group-hover:pointer-events-auto transition-all duration-300">
                <h3 class="text-lg font-bold mb-4">Jumlah Kunjungan</h3>

                <div class="space-y-3 text-sm">
                    <div class="flex justify-between border-b border-white/20 pb-2">
                        <span>Hari Ini</span>
                        <strong>{{ number_format($visitorStats['today'] ?? 0) }}</strong>
                    </div>

                    <div class="flex justify-between border-b border-white/20 pb-2">
                        <span>Kemarin</span>
                        <strong>{{ number_format($visitorStats['yesterday'] ?? 0) }}</strong>
                    </div>

                    <div class="flex justify-between border-b border-white/20 pb-2">
                        <span>Minggu Ini</span>
                        <strong>{{ number_format($visitorStats['this_week'] ?? 0) }}</strong>
                    </div>

                    <div class="flex justify-between border-b border-white/20 pb-2">
                        <span>Minggu Lalu</span>
                        <strong>{{ number_format($visitorStats['last_week'] ?? 0) }}</strong>
                    </div>

                    <div class="flex justify-between border-b border-white/20 pb-2">
                        <span>Bulan Ini</span>
                        <strong>{{ number_format($visitorStats['this_month'] ?? 0) }}</strong>
                    </div>

                    <div class="flex justify-between border-b border-white/20 pb-2">
                        <span>Bulan Lalu</span>
                        <strong>{{ number_format($visitorStats['last_month'] ?? 0) }}</strong>
                    </div>

                    <div class="flex justify-between pt-1">
                        <span>Total Kunjungan</span>
                        <strong>{{ number_format($visitorStats['total'] ?? 0) }}</strong>
                    </div>
                </div>
            </div>

            {{-- Ringkas --}}
            <div class="w-64 rounded-2xl bg-emerald-500/85 text-white border border-white/30 shadow-2xl backdrop-blur px-5 py-4 cursor-pointer">
                <div class="flex items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center text-xl">
                            👥
                        </div>

                        <div>
                            <p class="font-bold">Kunjungan</p>
                            <p class="text-sm text-emerald-50">Hari Ini</p>
                        </div>
                    </div>

                    <div class="text-right">
                        <p class="text-xl font-bold">{{ number_format($visitorStats['today'] ?? 0) }}</p>
                        <p class="text-xs text-emerald-50">visitor</p>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- FLOATING PENGADUAN --}}
<div class="fixed right-5 bottom-6 z-50">
    <button
        type="button"
        onclick="toggleComplaintPanel()"
        class="rounded-2xl bg-rose-500/90 text-white border border-white/30 shadow-2xl backdrop-blur px-5 py-4 hover:bg-rose-600 transition">
        <div class="flex items-center gap-3">
            <span class="text-2xl">🎧</span>
            <span class="font-bold">Pengaduan</span>
        </div>
    </button>
</div>

    {{-- PANEL PENGADUAN --}}
    <div id="complaintPanel"
        class="fixed right-5 bottom-24 z-50 hidden w-[360px] max-w-[calc(100vw-2rem)] rounded-3xl bg-white border border-slate-200 shadow-2xl overflow-hidden">

        <div class="bg-emerald-700 text-white px-5 py-4 flex items-center justify-between">
            <div>
                <h3 class="font-bold">Form Pengaduan</h3>
                <p class="text-xs text-emerald-100">Sampaikan aspirasi atau laporan Anda.</p>
            </div>

            <button type="button" onclick="toggleComplaintPanel()" class="text-white text-xl">
                ×
            </button>
        </div>

        <form method="POST"
            action="{{ route('public.complaints.store') }}"
            enctype="multipart/form-data"
            class="p-5 space-y-4">
            @csrf

            @if(session('complaint_success'))
                <div class="rounded-xl bg-emerald-50 border border-emerald-200 px-4 py-3 text-sm text-emerald-700">
                    {{ session('complaint_success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="rounded-xl bg-rose-50 border border-rose-200 px-4 py-3 text-sm text-rose-700">
                    <p class="font-semibold">Pengaduan belum bisa dikirim.</p>
                    <ul class="mt-2 list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Nama <span class="text-rose-500">*</span>
                </label>
                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                    placeholder="Masukkan nama Anda"
                >
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Nomor Telepon/WA <span class="text-rose-500">*</span>
                </label>
                <input
                    type="text"
                    name="phone"
                    value="{{ old('phone') }}"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                    placeholder="Masukkan nomor HP/WhatsApp"
                >
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Kategori Pengaduan <span class="text-rose-500">*</span>
                </label>
                <select
                    name="category"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                >
                    <option value="">Pilih kategori pengaduan</option>
                    @foreach (['Umum', 'Sosial', 'Keamanan', 'Kesehatan', 'Kebersihan', 'Permintaan'] as $category)
                        <option value="{{ $category }}" {{ old('category') === $category ? 'selected' : '' }}>
                            {{ $category }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Pengaduan <span class="text-rose-500">*</span>
                </label>
                <textarea
                    name="message"
                    rows="4"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm leading-6 focus:outline-none focus:ring-2 focus:ring-emerald-500"
                    placeholder="Masukkan pesan, informasi, atau detail aduan Anda"
                >{{ old('message') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Lampiran
                </label>
                <input
                    type="file"
                    name="attachment"
                    accept=".jpg,.jpeg,.png,.pdf"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm"
                >
                <p class="mt-1 text-xs text-slate-500">Format: JPG, PNG, PDF. Maksimal 2MB.</p>
            </div>

            <div class="flex justify-end pt-2">
                <button
                    type="submit"
                    class="rounded-xl bg-emerald-600 px-5 py-3 text-sm font-semibold text-white hover:bg-emerald-700 transition">
                    Kirim
                </button>
            </div>
        </form>
    </div>

    <script>
        function toggleComplaintPanel() {
            const panel = document.getElementById('complaintPanel');
            if (!panel) return;

            panel.classList.toggle('hidden');
        }

        document.addEventListener('DOMContentLoaded', function () {
            const hasComplaintFeedback =
                @json(session()->has('complaint_success') || $errors->any());

            if (hasComplaintFeedback) {
                const panel = document.getElementById('complaintPanel');
                if (panel) {
                    panel.classList.remove('hidden');
                }
            }
        });
    </script>

    {{-- ================= SCRIPT ================= --}}
    <script>
        // MOBILE MENU
        const menuBtn = document.getElementById('menuBtn');
        const mobileMenu = document.getElementById('mobileMenu');

        if (menuBtn) {
            menuBtn.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
            });
        }

        // ANIMASI SCROLL
        document.addEventListener("DOMContentLoaded", () => {
            const elements = document.querySelectorAll(".fade-up");

            const observer = new IntersectionObserver(entries => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add("show");
                    }
                });
            });

            elements.forEach(el => observer.observe(el));
        });
    </script>

</body>
</html>