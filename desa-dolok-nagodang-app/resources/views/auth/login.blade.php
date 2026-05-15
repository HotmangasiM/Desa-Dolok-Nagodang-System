<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Desa</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-emerald-50">

<div class="min-h-screen grid lg:grid-cols-2">

    {{-- LEFT --}}
    <div class="relative hidden lg:flex overflow-hidden">

        <!-- IMAGE -->
        <img src="{{ asset('images/login1.jpg') }}"
             class="absolute inset-0 w-full h-full object-cover scale-105 brightness-110 contrast-110" />

        <!-- LIGHT OVERLAY -->
        <div class="absolute inset-0 bg-gradient-to-br from-white/40 via-white/10 to-transparent"></div>

        <!-- SMOOTH TRANSITION -->
        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/30 to-white"></div>
        <!-- CONTENT -->
<div class="relative z-10 flex items-center justify-center h-full px-16">

    <div class="max-w-xl space-y-10">

        <!-- ACCENT -->
        <div class="w-25 h-1.5 bg-gradient-to-r from-emerald-500 to-emerald-300 rounded-full"></div>

        <!-- TITLE -->
        <h1 class="text-5xl md:text-6xl font-extrabold leading-tight text-slate-800">
            Desa Digital
            <span class="block text-emerald-600 mt-2">
                Dolok Nagodang
            </span>
        </h1>

        <!-- DESCRIPTION -->
        <p class="text-slate-600 text-lg leading-relaxed max-w-lg">
            Platform terintegrasi untuk mengelola data desa secara modern,
            cepat, dan efisien dengan sistem yang rapi, aman, dan mudah digunakan.
        </p>

        <!-- CARD QUOTE -->
       <div class="bg-white/80 backdrop-blur-md border border-white/50 
            rounded-2xl p-5 shadow-xl max-w-md text-center">

    <div class="text-emerald-500 text-2xl mb-2">“</div>

    <p class="text-sm text-slate-600 italic leading-relaxed max-w-xs mx-auto">
        Transformasi digital desa dimulai dari sistem yang rapi,
        transparan, dan mudah diakses oleh masyarakat.
    </p>

</div>
    </div>

</div>
    </div>

    {{-- RIGHT --}}
    <div class="relative flex items-center justify-center px-6 py-12">

        <!-- SOFT GLOW -->
        <div class="absolute right-10 top-1/2 w-[400px] h-[400px] 
                    bg-emerald-300/30 blur-[120px] rounded-full"></div>

        <div class="relative w-full max-w-md">

            <!-- CARD -->
            <div class="bg-white/80 backdrop-blur-xl border border-slate-200 
                        shadow-xl rounded-3xl p-8">

                <!-- HEADER -->
                <div class="text-center mb-8">
                        <div class="flex justify-center mb-6">
                        <div class="bg-white p-4 rounded-2xl shadow-md border">
                            <img src="{{ asset('images/logo.jpg') }}" 
                                class="h-16 object-contain">
                        </div>
                    </div>

                    <h2 class="text-2xl font-bold text-slate-800">
                        Login Admin
                    </h2>

                    <p class="text-sm text-slate-500 mt-2">
                        Masuk untuk mengelola sistem desa
                    </p>
                </div>

                {{-- ALERT --}}
                @if (session('status'))
                    <div class="mb-4 text-sm text-emerald-700 bg-emerald-50 border border-emerald-200 px-4 py-3 rounded-xl">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 text-sm text-rose-700 bg-rose-50 border border-rose-200 px-4 py-3 rounded-xl">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- FORM -->
                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <!-- EMAIL -->
                    <div>
                        <label class="text-sm font-medium text-slate-600">Email</label>
                        <input type="email" name="email"
                               value="{{ old('email') }}"
                               required autofocus
                               class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm 
                                      focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 
                                      transition"
                               placeholder="email@desa.id">
                    </div>

                    <!-- PASSWORD -->
                    <div>
                        <label class="text-sm font-medium text-slate-600">Kata Sandi</label>
                        <input type="password" name="password"
                               required
                               class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm 
                                      focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 
                                      transition"
                               placeholder="••••••••">
                    </div>

                    <!-- OPTIONS -->
                    <div class="flex items-center justify-between text-sm text-slate-600">
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="remember"
                                   class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                            Ingat saya
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                               class="text-emerald-600 hover:text-emerald-700 font-medium">
                                Lupa?
                            </a>
                        @endif
                    </div>

                    <!-- BUTTON -->
                    <button type="submit"
                        class="w-full bg-gradient-to-r from-emerald-500 to-emerald-600 text-white 
                               py-3 rounded-xl font-semibold shadow-md 
                               hover:scale-[1.02] transition">
                        Masuk
                    </button>

                </form>

                <!-- FOOTER -->
                <p class="text-center text-xs text-slate-400 mt-6">
                    © {{ date('Y') }} Sistem Informasi Desa
                </p>

            </div>
        </div>
    </div>

</div>
</body>
</html>