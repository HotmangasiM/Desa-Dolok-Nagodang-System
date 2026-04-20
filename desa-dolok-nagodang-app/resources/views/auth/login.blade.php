<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Desa</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-100">
    <div class="min-h-screen grid lg:grid-cols-2">

        {{-- Left Section --}}
        <div class="hidden lg:flex bg-slate-900 text-white p-12 flex-col justify-between">
            <div>
                <div class="w-14 h-14 rounded-2xl bg-emerald-500/20 flex items-center justify-center text-2xl mb-6">
                    🏡
                </div>
                <h1 class="text-4xl font-bold leading-tight">
                    Sistem Informasi Desa Dolok Nagodang
                </h1>
                <p class="mt-4 text-slate-300 text-base leading-7 max-w-md">
                    Kelola data penduduk, surat elektronik, aparat desa, berita, dan inventaris desa
                    dalam satu panel administrasi yang rapi dan terpusat.
                </p>
            </div>

            <div class="rounded-3xl bg-slate-800 p-6 border border-slate-700">
                <p class="text-sm text-slate-300 leading-6">
                    “Panel admin ini dirancang untuk membantu operasional desa menjadi lebih tertib,
                    cepat, dan terdokumentasi dengan baik.”
                </p>
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