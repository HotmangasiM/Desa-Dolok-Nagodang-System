<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Website Desa Dolok Nagodang' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

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
            <nav class="hidden md:flex items-center gap-6 text-sm font-medium text-slate-700">
                <a href="{{ route('public.home') }}" class="hover:text-emerald-600 transition">Beranda</a>
                <a href="{{ route('public.profile') }}" class="hover:text-emerald-600 transition">Profil</a>
                <a href="{{ route('public.news.index') }}" class="hover:text-emerald-600 transition">Berita</a>
                <a href="{{ route('public.officials') }}" class="hover:text-emerald-600 transition">Aparat</a>
                <a href="{{ route('public.letters') }}" class="hover:text-emerald-600 transition">Layanan</a>
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
        <div id="mobileMenu" class="hidden md:hidden border-t bg-white">
            <div class="px-4 py-4 space-y-3 text-sm">
                <a href="{{ route('public.home') }}" class="block">Beranda</a>
                <a href="{{ route('public.profile') }}" class="block">Profil</a>
                <a href="{{ route('public.news.index') }}" class="block">Berita</a>
                <a href="{{ route('public.officials') }}" class="block">Aparat</a>
                <a href="{{ route('public.letters') }}" class="block">Layanan</a>
                <a href="{{ route('login') }}" class="block text-emerald-600 font-semibold">Login</a>
            </div>
        </div>
    </header>

    {{-- ================= MAIN ================= --}}
    <main>
        @yield('content')
    </main>

    {{-- ================= FOOTER ================= --}}
    <footer class="bg-slate-900 text-slate-300 mt-16">
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
    </footer>

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