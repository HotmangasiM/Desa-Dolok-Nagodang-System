<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Desa</title>

    <script src="https://cdn.tailwindcss.com"></script>
    
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
</head>

<body class="min-h-screen overflow-x-hidden bg-[#f4f7f4] font-sans antialiased">

<div class="relative min-h-screen w-full flex flex-col lg:flex-row items-center justify-between px-6 py-12 lg:px-24">
    
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('storage/dummy/login2.jpg') }}"
             class="h-full w-full object-cover brightness-[0.85] contrast-[1.02]" 
             alt="Desa Pemandangan" />
        
        <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/35 to-transparent hidden lg:block"></div>
        <div class="absolute inset-0 bg-black/50 lg:hidden"></div>
    </div>

    <div class="absolute right-0 top-12 z-0 h-[450px] w-[450px] rounded-full bg-emerald-400/25 blur-[130px] pointer-events-none hidden lg:block"></div>


    <div class="relative z-10 w-full lg:max-w-xl text-white mb-12 lg:mb-0">
        
        <div class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 backdrop-blur-md px-4 py-2">
            <div class="h-2.5 w-2.5 rounded-full bg-emerald-400 animate-pulse"></div>
            <span class="text-xs font-medium tracking-wide text-white/90">
                Sistem Informasi Desa
            </span>
        </div>

        <h1 class="mt-8 text-4xl lg:text-6xl font-bold tracking-tight leading-tight">
            Desa Digital
            <span class="block text-[#4ade80] mt-1 font-extrabold">
                Dolok Nagodang
            </span>
        </h1>

        <p class="mt-6 text-sm lg:text-base leading-relaxed text-slate-200/95 max-w-lg">
            Platform digital desa untuk pelayanan masyarakat, administrasi, transparansi informasi, dan pengelolaan data secara modern, cepat, dan terintegrasi.
        </p>

        <div class="mt-8 max-w-md rounded-2xl border border-white/10 bg-white/5 backdrop-blur-md p-5 shadow-xl relative overflow-hidden">
            <div class="absolute top-2 left-4 text-5xl text-emerald-400/30 font-serif select-none">“</div>
            <p class="text-xs lg:text-sm italic leading-relaxed text-slate-200 pl-4">
                Transformasi digital desa dimulai dari pelayanan yang transparan, modern, dan mudah diakses masyarakat.
            </p>
        </div>
    </div>


    <div class="relative z-10 w-full max-w-[440px] lg:mr-4">
        
        <div class="rounded-[32px] border border-white/60 bg-white/80 backdrop-blur-xl px-8 py-10 shadow-[0_20px_50px_rgba(0,0,0,0.12)]">

            <div class="text-center mb-8">
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
                    <label class="text-xs font-semibold text-slate-600 block mb-1.5">
                        Email
                    </label>
                    <input type="email"
                           name="email"
                           value="email@desa.id"
                           placeholder="email@desa.id"
                           class="w-full rounded-xl border-2 border-emerald-500 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition-all" 
                           required>
                </div>

                <div>
                    <label class="text-xs font-semibold text-slate-600 block mb-1.5">
                        Kata Sandi
                    </label>
                    <input type="password"
                           name="password"
                           placeholder="••••••••"
                           class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition-all focus:border-emerald-500 focus:border-2" 
                           required>
                </div>

                <div class="flex items-center justify-between text-xs pt-1">
                    <label class="flex items-center gap-2 text-slate-500 cursor-pointer select-none">
                        <input type="checkbox" class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500 h-4 w-4">
                        Ingat saya
                    </label>
                    <a href="#" class="font-semibold text-emerald-600 hover:text-emerald-700 transition">
                        Lupa?
                    </a>
                </div>

                <div class="pt-2">
                    <button type="submit"
                            class="w-full rounded-xl bg-[#0e9f6e] py-3.5 text-white font-semibold text-sm shadow-md hover:bg-[#0b8a5c] transition-colors duration-200">
                        Masuk
                    </button>
                </div>
            </form>

            <p class="mt-8 text-center text-[11px] text-slate-400 tracking-wide">
                © 2026 Sistem Informasi Desa
            </p>

        </div>
    </div>

</div>

</body>
</html>