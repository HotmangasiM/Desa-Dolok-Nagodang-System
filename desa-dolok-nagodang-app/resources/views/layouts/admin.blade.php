<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin Desa' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 text-slate-800">
    <div class="min-h-screen flex">

        {{-- Sidebar --}}
        <aside class="hidden lg:flex lg:w-72 xl:w-80 bg-slate-900 text-white flex-col">
            <div class="px-6 py-6 border-b border-slate-800">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-2xl bg-emerald-500/20 flex items-center justify-center text-xl">
                        🏡
                    </div>
                    <div>
                        <h1 class="text-lg font-bold">Sistem Informasi Desa</h1>
                        <p class="text-sm text-slate-400">Panel Administrasi</p>
                    </div>
                </div>
            </div>

            <nav class="flex-1 px-4 py-6 space-y-2">
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition {{ request()->routeIs('admin.dashboard') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-600/20' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <span>📊</span>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('admin.citizens.index') }}"
                   class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition {{ request()->routeIs('admin.citizens.*') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-600/20' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <span>👥</span>
                    <span>Data Penduduk</span>
                </a>

                <a href="{{ route('admin.officials.index') }}"
                   class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition {{ request()->routeIs('admin.officials.*') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-600/20' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <span>🧑‍💼</span>
                    <span>Aparat Desa</span>
                </a>

                <a href="{{ route('admin.letters.index') }}"
                   class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition {{ request()->routeIs('admin.letters.*') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-600/20' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <span>📄</span>
                    <span>Surat Elektronik</span>
                </a>

                <a href="{{ route('admin.news.index') }}"
                   class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition {{ request()->routeIs('admin.news.*') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-600/20' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <span>📰</span>
                    <span>Berita Desa</span>
                </a>

                <a href="{{ route('admin.assets.index') }}"
                   class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition {{ request()->routeIs('admin.assets.*') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-600/20' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <span>📦</span>
                    <span>Inventaris Desa</span>
                </a>
            </nav>

            <div class="px-4 py-5 border-t border-slate-800">
                <div class="rounded-2xl bg-slate-800 p-4">
                    <p class="text-sm font-semibold text-white">{{ auth()->user()->name ?? 'Admin' }}</p>
                    <p class="text-xs text-slate-400 mt-1">{{ auth()->user()->email ?? '-' }}</p>

                    <div class="mt-4 flex flex-col gap-2">
                        <a href="{{ route('profile.edit') }}"
                           class="inline-flex items-center justify-center rounded-xl border border-slate-700 bg-slate-900 px-4 py-2.5 text-sm font-medium text-slate-200 hover:bg-slate-700 transition">
                            Profile
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full inline-flex items-center justify-center rounded-xl bg-rose-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-rose-700 transition">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </aside>

        {{-- Main --}}
        <div class="flex-1 min-w-0">
            {{-- Topbar --}}
            <header class="sticky top-0 z-30 bg-white/90 backdrop-blur border-b border-slate-200">
                <div class="px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-bold text-slate-800">{{ $pageTitle ?? 'Dashboard' }}</h2>
                        @isset($pageDescription)
                            <p class="text-xs text-slate-500 mt-0.5">{{ $pageDescription }}</p>
                        @endisset
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="hidden sm:block text-right">
                            <p class="text-sm font-semibold text-slate-800">{{ auth()->user()->name ?? 'Admin' }}</p>
                            <p class="text-xs text-slate-500">Administrator</p>
                        </div>

                        <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center text-slate-700 font-bold">
                            {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                        </div>
                    </div>
                </div>
            </header>

            {{-- Content --}}
            <main class="px-4 sm:px-6 lg:px-8 py-6">
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>