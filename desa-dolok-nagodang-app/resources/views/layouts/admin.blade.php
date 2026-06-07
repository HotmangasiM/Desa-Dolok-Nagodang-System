<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin Desa' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')

    {{-- Lucide Icons --}}
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-slate-100 text-slate-800">

<div class="min-h-screen flex">

    {{-- ================= MOBILE OVERLAY ================= --}}
    <div id="overlay" class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden"></div>

    {{-- ================= SIDEBAR DESKTOP ================= --}}
    <aside class="hidden lg:flex lg:w-72 xl:w-80 bg-slate-900 text-white flex-col">

        {{-- BRAND --}}
        <div class="px-6 py-6 border-b border-slate-800">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-white rounded-xl p-2 flex items-center justify-center">
                    <img src="{{ asset('storage/dummy/logo.png') }}" class="w-full h-full object-contain">
                </div>
                <div>
                    <h1 class="text-lg font-bold">Sistem Informasi Desa</h1>
                    <p class="text-xs text-slate-400">Panel Administrasi</p>
                </div>
            </div>
        </div>

        {{-- MENU --}}
        <nav class="flex-1 px-4 py-6 space-y-2">

            @php
                $menuClass = fn ($route) => request()->routeIs($route)
                        ? 'bg-gradient-to-r from-emerald-500 to-teal-600 text-white shadow-lg'
                        : 'text-slate-300 hover:bg-slate-800 hover:text-white';
            @endphp

            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium {{ $menuClass('admin.dashboard') }}">
                <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                Dashboard
            </a>

            <a href="{{ route('admin.citizens.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium {{ $menuClass('admin.citizens.*') }}">
                <i data-lucide="users" class="w-5 h-5"></i>
                Data Penduduk
            </a>

            <a href="{{ route('admin.officials.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium {{ $menuClass('admin.officials.*') }}">
                <i data-lucide="briefcase" class="w-5 h-5"></i>
                Aparat Desa
            </a>

            <a href="{{ route('admin.letters.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium {{ $menuClass('admin.letters.*') }}">
                <i data-lucide="file-text" class="w-5 h-5"></i>
                Surat
            </a>

            <a href="{{ route('admin.news.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium {{ $menuClass('admin.news.*') }}">
                <i data-lucide="newspaper" class="w-5 h-5"></i>
                Berita
            </a>

            <a href="{{ route('admin.assets.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium {{ $menuClass('admin.assets.*') }}">
                <i data-lucide="package" class="w-5 h-5"></i>
                Inventaris
            </a>

            {{-- INFRASRUKTUR (FIXED) --}}
            <a href="{{ route('admin.infrastructure.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium {{ $menuClass('admin.infrastructure.*') }}">

                <i data-lucide="building-2" class="w-5 h-5"></i>
                Infrastruktur
            </a>

        </nav>

        {{-- USER --}}
        <div class="p-4 border-t border-slate-800">
            <div class="bg-slate-800 p-4 rounded-2xl">

                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-emerald-500 flex items-center justify-center text-white font-bold">
                        {{ strtoupper(substr(auth()->user()->name ?? 'A',0,1)) }}
                    </div>

                    <div>
                        <div class="text-sm font-semibold">
                            {{ auth()->user()->name ?? 'Administrator' }}
                        </div>
                        <div class="text-xs text-slate-400">
                            {{ auth()->user()->email ?? '-' }}
                        </div>
                    </div>
                </div>

                <div class="mt-4 flex flex-col gap-2">

                    <a href="{{ route('profile.edit') }}"
                       class="text-center text-sm bg-slate-700 hover:bg-slate-600 py-2 rounded-xl">
                        Profile
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

    {{-- ================= MOBILE SIDEBAR ================= --}}
    <aside id="mobileSidebar"
           class="fixed top-0 left-0 w-72 h-full bg-slate-900 text-white z-50 transform -translate-x-full transition-transform lg:hidden">

        <div class="p-5 border-b border-slate-800 flex items-center justify-between">
            <span class="font-bold">Menu</span>
            <button onclick="toggleSidebar()">✕</button>
        </div>

        <div class="p-4 space-y-2">

            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 py-2">
                <i data-lucide="layout-dashboard"></i> Dashboard
            </a>

            <a href="{{ route('admin.citizens.index') }}" class="flex items-center gap-3 py-2">
                <i data-lucide="users"></i> Penduduk
            </a>

            <a href="{{ route('admin.officials.index') }}" class="flex items-center gap-3 py-2">
                <i data-lucide="briefcase"></i> Aparat
            </a>

            <a href="{{ route('admin.letters.index') }}" class="flex items-center gap-3 py-2">
                <i data-lucide="file-text"></i> Surat
            </a>

            <a href="{{ route('admin.news.index') }}" class="flex items-center gap-3 py-2">
                <i data-lucide="newspaper"></i> Berita
            </a>

            <a href="{{ route('admin.assets.index') }}" class="flex items-center gap-3 py-2">
                <i data-lucide="package"></i> Inventaris
            </a>

            {{-- INFRASRUKTUR MOBILE --}}
            <a href="{{ route('admin.infrastructure.index') }}" class="flex items-center gap-3 py-2">
                <i data-lucide="building-2"></i> Infrastruktur
            </a>

        </div>
    </aside>

    {{-- ================= MAIN ================= --}}
    <div class="flex-1 min-w-0">

        {{-- TOPBAR --}}
        <header class="bg-white/95 backdrop-blur border-b sticky top-0 z-30">

            <div class="flex items-center justify-between px-4 py-4">

                <div class="flex items-center gap-3">
                    <button class="lg:hidden" onclick="toggleSidebar()">
                        <i data-lucide="menu"></i>
                    </button>

                    <div class="min-w-0">
                        <nav class="hidden sm:flex items-center gap-2 text-sm text-slate-500 mb-1">
                            <a href="{{ route('admin.dashboard') }}" class="hover:text-slate-700 transition">
                                Admin
                            </a>

                            @isset($breadcrumbs)
                                @foreach ($breadcrumbs as $breadcrumb)
                                    <span>/</span>

                                    @if (!empty($breadcrumb['url']))
                                        <a href="{{ $breadcrumb['url'] }}" class="hover:text-slate-700 transition">
                                            {{ $breadcrumb['label'] }}
                                        </a>
                                    @else
                                        <span class="text-slate-700 font-medium">
                                            {{ $breadcrumb['label'] }}
                                        </span>
                                    @endif
                                @endforeach
                            @else
                                <span>/</span>
                                <span class="text-slate-700 font-medium">
                                    {{ $pageTitle ?? 'Dashboard' }}
                                </span>
                            @endisset
                        </nav>

                        <h1 class="font-bold text-lg text-slate-800 truncate">
                            {{ $pageTitle ?? 'Dashboard' }}
                        </h1>

                        @isset($pageDescription)
                            <p class="hidden sm:block text-xs text-slate-500 mt-1">
                                {{ $pageDescription }}
                            </p>
                        @else
                            <p class="hidden sm:block text-xs text-slate-500 mt-1">
                                Administrator Panel
                            </p>
                        @endisset
                    </div>
                </div>

                <div class="flex items-center gap-3">

                    <div class="hidden sm:flex items-center gap-3 bg-slate-50 border rounded-xl px-3 py-2">
                        <div class="w-9 h-9 rounded-full bg-emerald-500 text-white flex items-center justify-center font-bold">
                            {{ strtoupper(substr(auth()->user()->name ?? 'A',0,1)) }}
                        </div>

                        <div class="leading-tight">
                            <div class="text-sm font-semibold">
                                {{ auth()->user()->name ?? 'Administrator' }}
                            </div>
                            <div class="text-xs text-slate-500">
                                Administrator
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('profile.edit') }}"
                       class="hidden sm:inline-flex items-center gap-2 px-3 py-2 rounded-xl border bg-white text-sm">
                        <i data-lucide="user-circle" class="w-4 h-4"></i>
                        Profile
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
<script>
Swal.fire({
    icon: 'success',
    title: 'Berhasil',
    text: '{{ session('success') }}',
    confirmButtonColor: '#10b981'
});
</script>
@endif

@if(session('error'))
<script>
Swal.fire({
    icon: 'error',
    title: 'Gagal',
    text: '{{ session('error') }}',
    confirmButtonColor: '#ef4444'
});
</script>
@endif

@if(session('warning'))
<script>
Swal.fire({
    icon: 'warning',
    title: 'Peringatan',
    text: '{{ session('warning') }}'
});
</script>
@endif

<script>
function toggleSidebar() {
    const sidebar = document.getElementById('mobileSidebar');
    const overlay = document.getElementById('overlay');

    sidebar.classList.toggle('-translate-x-full');
    overlay.classList.toggle('hidden');
}

document.getElementById('overlay').addEventListener('click', toggleSidebar);

document.addEventListener("DOMContentLoaded", () => {
    lucide.createIcons();
});
</script>

@stack('scripts')

</body>
</html>
