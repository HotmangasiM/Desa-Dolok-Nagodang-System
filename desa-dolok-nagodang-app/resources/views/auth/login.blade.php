<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Desa</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-100">
    <div class="min-h-screen grid lg:grid-cols-2">

        {{-- Left Section --}}
        <div class="relative hidden lg:flex overflow-hidden">
            {{-- Background Image --}}
            <img
                src="{{ asset('images/farmer-login.png') }}"
                alt="Petani desa"
                class="absolute inset-0 h-full w-full object-cover"
            >

            {{-- Dark Overlay --}}
            <div class="absolute inset-0 bg-slate-950/55"></div>

            {{-- Soft Gradient Overlay --}}
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-900/30 to-slate-900/40"></div>

            {{-- Content --}}
            <div class="relative z-10 flex h-full w-full flex-col justify-between p-12 text-white">
                <div class="max-w-lg">
                    <!-- <div class="mb-6 flex h-14 w-14 items-center justify-center rounded-2xl bg-emerald-500/20 text-2xl backdrop-blur-sm border border-white/10">
                        🌾
                    </div> -->

                    <h1 class="text-4xl xl:text-5xl font-bold leading-tight drop-shadow-lg align-center">
                        Sistem Informasi
                        <br>
                        Desa Dolok Nagodang
                    </h1>

                    <p class="mt-5 max-w-md text-base leading-7 text-slate-100/90">
                        Kelola data penduduk, surat, berita, aparat desa, dan inventaris
                        dalam satu panel administrasi yang rapi dan terpusat.
                    </p>
                </div>

                <div class="max-w-md rounded-3xl border border-white/15 bg-white/10 p-6 backdrop-blur-md shadow-xl">
                    <p class="text-sm leading-6 text-slate-100/90">
                        “Panel admin ini dirancang untuk membantu operasional desa menjadi lebih tertib,
                        cepat, dan terdokumentasi dengan baik.”
                    </p>
                </div>
            </div>
        </div>

        {{-- Right Section --}}
        <div class="flex items-center justify-center px-4 py-10 sm:px-6 lg:px-12">
            <div class="w-full max-w-md">
                <div class="rounded-3xl bg-white shadow-xl border border-slate-200 p-8 sm:p-10">
                    <div class="text-center mb-8">
                        <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-emerald-100 text-3xl">
                            🔐
                        </div>
                        <h2 class="text-2xl font-bold text-slate-800">Masuk ke Panel Admin</h2>
                        <p class="mt-2 text-sm text-slate-500">
                            Gunakan akun admin untuk mengakses sistem informasi desa.
                        </p>
                    </div>

                    @if (session('status'))
                        <div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mb-4 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="space-y-5">
                        @csrf

                        <div>
                            <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">
                                Email
                            </label>
                            <input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                autofocus
                                autocomplete="username"
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                placeholder="Masukkan email"
                            >
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-semibold text-slate-700 mb-2">
                                Password
                            </label>
                            <input
                                id="password"
                                type="password"
                                name="password"
                                required
                                autocomplete="current-password"
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                placeholder="Masukkan password"
                            >
                        </div>

                        <div class="flex items-center justify-between">
                            <label class="inline-flex items-center gap-2 text-sm text-slate-600">
                                <input
                                    type="checkbox"
                                    name="remember"
                                    class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500"
                                >
                                <span>Remember me</span>
                            </label>

                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-sm font-medium text-emerald-600 hover:text-emerald-700">
                                    Lupa password?
                                </a>
                            @endif
                        </div>

                        <button
                            type="submit"
                            class="w-full rounded-xl bg-emerald-600 px-4 py-3 text-sm font-semibold text-white hover:bg-emerald-700 transition shadow-lg shadow-emerald-600/20">
                            Masuk
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>