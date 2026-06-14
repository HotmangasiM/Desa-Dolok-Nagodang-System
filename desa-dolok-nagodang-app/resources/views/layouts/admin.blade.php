<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin Desa' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')

    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-slate-100 text-slate-800">

<div class="min-h-screen flex">

    {{-- OVERLAY MOBILE --}}
    <div id="overlay" class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden"></div>

    {{-- SIDEBAR DESKTOP --}}
    <aside class="hidden lg:flex lg:w-72 xl:w-80 bg-slate-900 text-white flex-col">

        {{-- BRAND --}}
        <div class="px-6 py-6 border-b border-slate-800">
            <div class="flex items-center gap-3">

                <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center p-2">
                    <img src="{{ asset('storage/dummy/logo.png') }}" class="w-full h-full object-contain">
                </div>

                <div>
                    <h1 class="text-base font-bold">Sistem Desa</h1>
                    <p class="text-xs text-slate-400">Admin Panel</p>
                </div>

            </div>
        </div>

        {{-- MENU --}}
        <nav class="flex-1 px-4 py-6 space-y-1">

            @php
                $active = fn($r) =>
                    request()->routeIs($r)
                    ? 'bg-emerald-600 text-white shadow'
                    : 'text-slate-300 hover:bg-slate-800 hover:text-white';
            @endphp

            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium {{ $active('admin.dashboard') }}">
                <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                Dashboard
            </a>

            <a href="{{ route('admin.citizens.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium {{ $active('admin.citizens.*') }}">
                <i data-lucide="users" class="w-5 h-5"></i>
                Penduduk
            </a>

            <a href="{{ route('admin.officials.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium {{ $active('admin.officials.*') }}">
                <i data-lucide="briefcase" class="w-5 h-5"></i>
                Aparat
            </a>

            <a href="{{ route('admin.letters.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium {{ $active('admin.letters.*') }}">
                <i data-lucide="file-text" class="w-5 h-5"></i>
                Surat
            </a>

            <a href="{{ route('admin.news.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium {{ $active('admin.news.*') }}">
                <i data-lucide="newspaper" class="w-5 h-5"></i>
                Berita
            </a>

            <a href="{{ route('admin.assets.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium {{ $active('admin.assets.*') }}">
                <i data-lucide="package" class="w-5 h-5"></i>
                Inventaris
            </a>

            <a href="{{ route('admin.infrastructure.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium {{ $active('admin.infrastructure.*') }}">
                <i data-lucide="building-2" class="w-5 h-5"></i>
                Infrastruktur
            </a>

        </nav>

        {{-- USER --}}
        <div class="p-4 border-t border-slate-800">

            <div class="bg-slate-800 p-4 rounded-2xl">

                <div class="flex items-center gap-3">

                    <div class="w-10 h-10 rounded-full bg-emerald-600 flex items-center justify-center font-bold">
                        {{ strtoupper(substr(auth()->user()->name ?? 'A',0,1)) }}
                    </div>

                    <div class="min-w-0">
                        <div class="text-sm font-semibold truncate">
                            {{ auth()->user()->name ?? 'Admin' }}
                        </div>
                        <div class="text-xs text-slate-400 truncate">
                            {{ auth()->user()->email ?? '-' }}
                        </div>
                    </div>

                </div>

                <div class="mt-4 space-y-2">

                    <a href="{{ route('profile.edit') }}"
                       class="block text-center text-sm bg-slate-700 hover:bg-slate-600 py-2 rounded-xl">
                        Profil
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="w-full bg-red-600 hover:bg-red-700 py-2 rounded-xl text-sm">
                            Logout
                        </button>
                    </form>

                </div>

            </div>

        </div>

    </aside>

    {{-- MOBILE SIDEBAR --}}
    <aside id="mobileSidebar"
           class="fixed top-0 left-0 w-72 h-full bg-slate-900 text-white z-50 -translate-x-full transition-transform lg:hidden">

        <div class="p-5 flex justify-between border-b border-slate-800">
            <span class="font-bold">Menu</span>
            <button onclick="toggleSidebar()">
                <i data-lucide="x"></i>
            </button>
        </div>

        <nav class="p-4 space-y-2 text-sm">

            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                <i data-lucide="layout-dashboard"></i> Dashboard
            </a>

            <a href="{{ route('admin.citizens.index') }}" class="flex items-center gap-3">
                <i data-lucide="users"></i> Penduduk
            </a>

            <a href="{{ route('admin.officials.index') }}" class="flex items-center gap-3">
                <i data-lucide="briefcase"></i> Aparat
            </a>

            <a href="{{ route('admin.letters.index') }}" class="flex items-center gap-3">
                <i data-lucide="file-text"></i> Surat
            </a>

            <a href="{{ route('admin.news.index') }}" class="flex items-center gap-3">
                <i data-lucide="newspaper"></i> Berita
            </a>

            <a href="{{ route('admin.assets.index') }}" class="flex items-center gap-3">
                <i data-lucide="package"></i> Inventaris
            </a>

            <a href="{{ route('admin.infrastructure.index') }}" class="flex items-center gap-3">
                <i data-lucide="building-2"></i> Infrastruktur
            </a>

        </nav>

    </aside>

    {{-- MAIN --}}
    <div class="flex-1 min-w-0">

        {{-- TOPBAR --}}
        <header class="bg-white border-b sticky top-0 z-30">

            <div class="flex items-center justify-between px-4 py-4">

                <div class="flex items-center gap-3">

                    <button class="lg:hidden" onclick="toggleSidebar()">
                        <i data-lucide="menu"></i>
                    </button>

                    <div>
                        <h1 class="font-bold text-lg">
                            {{ $pageTitle ?? 'Dashboard' }}
                        </h1>

                        <p class="text-xs text-slate-500">
                            {{ $pageDescription ?? 'Panel Administrasi Desa' }}
                        </p>
                    </div>

                </div>

                <div class="flex items-center gap-3">

                    <a href="{{ route('profile.edit') }}"
                       class="hidden sm:flex items-center gap-2 border px-3 py-2 rounded-xl text-sm">
                        <i data-lucide="user"></i>
                        Profil
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="bg-red-500 text-white px-3 py-2 rounded-xl text-sm">
                            Logout
                        </button>
                    </form>

                </div>

            </div>

        </header>

        {{-- CONTENT --}}
        <main class="p-6">
            @yield('content')
        </main>

    </div>

</div>

{{-- SCRIPT --}}
<script>
function toggleSidebar() {
    document.getElementById('mobileSidebar').classList.toggle('-translate-x-full');
    document.getElementById('overlay').classList.toggle('hidden');
}

document.getElementById('overlay').addEventListener('click', toggleSidebar);

document.addEventListener("DOMContentLoaded", () => {
    lucide.createIcons();
});
</script>

@stack('scripts')

</body>
</html>