<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Desa</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen overflow-x-hidden bg-[#f4f7f4] font-sans antialiased">
<div class="relative flex min-h-screen w-full flex-col items-center justify-between px-6 py-12 lg:flex-row lg:px-24">
    <div class="absolute inset-0 z-0">
        <img
            src="{{ asset('storage/dummy/login2.jpg') }}"
            class="h-full w-full object-cover brightness-[0.85] contrast-[1.02]"
            alt="Pemandangan Desa"
        />

        <div class="absolute inset-0 hidden bg-gradient-to-r from-black/80 via-black/35 to-transparent lg:block"></div>
        <div class="absolute inset-0 bg-black/50 lg:hidden"></div>
    </div>

    <div class="absolute right-0 top-12 z-0 hidden h-[450px] w-[450px] rounded-full bg-emerald-400/25 blur-[130px] pointer-events-none lg:block"></div>

    <div class="relative z-10 mb-12 w-full text-white lg:mb-0 lg:max-w-xl">
        <div class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-4 py-2 backdrop-blur-md">
            <div class="h-2.5 w-2.5 rounded-full bg-emerald-400 animate-pulse"></div>
            <span class="text-xs font-medium tracking-wide text-white/90">
                Sistem Informasi Desa
            </span>
        </div>

        <h1 class="mt-8 text-4xl font-bold leading-tight tracking-tight lg:text-6xl">
            Desa Digital
            <span class="mt-1 block font-extrabold text-[#4ade80]">
                Dolok Nagodang
            </span>
        </h1>

        <p class="mt-6 max-w-lg text-sm leading-relaxed text-slate-200/95 lg:text-base">
            Platform desa digital untuk pelayanan masyarakat, administrasi, transparansi informasi, dan pengelolaan data secara modern, cepat, dan terintegrasi.
        </p>

        <div class="relative mt-8 max-w-md overflow-hidden rounded-2xl border border-white/10 bg-white/5 p-5 shadow-xl backdrop-blur-md">
            <div class="absolute left-4 top-2 select-none font-serif text-5xl text-emerald-400/30">"</div>
            <p class="pl-4 text-xs italic leading-relaxed text-slate-200 lg:text-sm">
                Transformasi digital desa dimulai dari pelayanan yang transparan, modern, dan mudah diakses masyarakat.
            </p>
        </div>
    </div>

    <div class="relative z-10 w-full max-w-[440px] lg:mr-4">
        <div class="rounded-[32px] border border-white/60 bg-white/80 px-8 py-10 shadow-[0_20px_50px_rgba(0,0,0,0.12)] backdrop-blur-xl">
            <div class="mb-8 text-center">
                <div class="mb-4 flex justify-center">
                    <div class="rounded-2xl border border-slate-100 bg-white p-3 shadow-sm">
                        <img src="{{ asset('images/logo.jpg') }}" class="h-14 w-14 object-contain" alt="Logo Desa">
                    </div>
                </div>

                <h2 class="text-2xl font-bold tracking-tight text-slate-800">
                    Login Admin
                </h2>
                <p class="mt-1.5 text-xs text-slate-500">
                    Masuk untuk mengelola sistem desa
                </p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div>
                    <label class="mb-1.5 block text-xs font-semibold text-slate-600">
                        Email
                    </label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="email@desa.id"
                        class="w-full rounded-xl border-2 border-emerald-500 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition-all"
                        required
                        autofocus
                        autocomplete="username"
                    >
                    @error('email')
                        <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="mb-1.5 block text-xs font-semibold text-slate-600">
                        Kata Sandi
                    </label>
                    <input
                        type="password"
                        name="password"
                        placeholder="Masukkan kata sandi"
                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition-all focus:border-2 focus:border-emerald-500"
                        required
                        autocomplete="current-password"
                    >
                    @error('password')
                        <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between pt-1 text-xs">
                    <label class="flex cursor-pointer select-none items-center gap-2 text-slate-500">
                        <input
                            type="checkbox"
                            name="remember"
                            value="1"
                            @checked(old('remember'))
                            class="h-4 w-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500"
                        >
                        Ingat saya
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="font-semibold text-emerald-600 transition hover:text-emerald-700">
                            Lupa password?
                        </a>
                    @endif
                </div>

                <div class="pt-2">
                    <button
                        type="submit"
                        class="w-full rounded-xl bg-[#0e9f6e] py-3.5 text-sm font-semibold text-white shadow-md transition-colors duration-200 hover:bg-[#0b8a5c]"
                    >
                        Masuk
                    </button>
                </div>
            </form>

            <p class="mt-8 text-center text-[11px] tracking-wide text-slate-400">
                &copy; 2026 Sistem Informasi Desa
            </p>
        </div>
    </div>
</div>

@if ($errors->has('email') || $errors->has('password'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const message = @js($errors->first('email') ?: $errors->first('password'));

            if (window.Swal) {
                Swal.fire({
                    icon: 'error',
                    title: 'Login gagal',
                    text: message || 'Email atau kata sandi tidak sesuai.',
                    confirmButtonText: 'Coba Lagi',
                    confirmButtonColor: '#0e9f6e',
                });

                return;
            }

            alert(message || 'Email atau kata sandi tidak sesuai.');
        });
    </script>
@endif
</body>
</html>
