<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin Panel' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 text-slate-800">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="hidden md:flex md:w-72 md:flex-col bg-slate-900 text-slate-100 shadow-xl">
            <div class="px-6 py-6 border-b border-slate-800">
                <h1 class="text-2xl font-bold tracking-tight text-white">Admin Desa</h1>
                <p class="text-sm text-slate-400 mt-1">Sistem Informasi Desa</p>
            </div>

            <nav class="flex-1 px-4 py-6 space-y-2">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('admin.dashboard') }}">
                        <span>📊</span>
                        <span class="font-semibold">Dashboard</span>
                </a>

                <a href="{{ route('admin.citizens.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl transition
                    {{ request()->routeIs('admin.citizens.*')
                        ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-900/30'
                        : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <span>👥</span>
                    <span class="font-semibold">Penduduk</span>
                </a>

                <a href="{{ route('admin.news.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl transition
                    {{ request()->routeIs('admin.news.*')
                        ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-900/30'
                        : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <span>📰</span>
                    <span class="font-semibold">Berita Desa</span>
                </a>

                <a href="{{ route('admin.assets.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('admin.assets.*')}}">
                    <span>🏢</span>
                    <span class="font-semibold">Inventaris</span>
                </a>

                <a href="{{ route('admin.officials.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('admin.officials.*') }}">
                        <span>🧑‍💼</span>
                        <span class="font-semibold">Aparat Desa</span>
                </a>

                <a href="{{ route('admin.letters.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('admin.letters.*') }}">
                        <span>📄</span>
                        <span class="font-semibold">Surat Elektronik</span>
                </a>
            </nav>

            <div class="px-4 py-4 border-t border-slate-800">
                <div class="flex items-center gap-3 px-3 py-3 rounded-xl bg-slate-800">
                    <div class="w-11 h-11 rounded-full bg-emerald-500 flex items-center justify-center font-bold text-white">
                        A
                    </div>
                    <div class="min-w-0">
                        <p class="font-semibold text-white truncate">Admin Desa</p>
                        <p class="text-xs text-slate-400 truncate">admin@desa.local</p>
                    </div>
                </div>

                <button class="mt-4 w-full rounded-xl bg-rose-500/10 text-rose-300 hover:bg-rose-500/20 px-4 py-3 font-medium transition">
                    Logout
                </button>
            </div>
        </aside>

        <!-- Main -->
        <div class="flex-1 flex flex-col min-w-0">
            <!-- Topbar -->
            <header class="bg-white border-b border-slate-200 px-6 py-4 flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold text-slate-800">{{ $pageTitle ?? 'Dashboard' }}</h2>
                    <p class="text-sm text-slate-500 mt-1">{{ $pageDescription ?? 'Kelola data sistem' }}</p>
                </div>

                <div class="flex items-center gap-4">
                    <button class="hidden md:inline-flex items-center gap-2 rounded-xl border border-slate-200 px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50 transition">
                        🔔
                        <span>Pemberitahuan</span>
                    </button>

                    <div class="flex items-center gap-3">
                        <div class="text-right hidden sm:block">
                            <p class="text-sm font-semibold text-slate-700">Admin Desa</p>
                            <p class="text-xs text-slate-500">Super Administrator</p>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold">
                            A
                        </div>
                    </div>
                </div>
            </header>

            <main class="p-6">
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>
</html>