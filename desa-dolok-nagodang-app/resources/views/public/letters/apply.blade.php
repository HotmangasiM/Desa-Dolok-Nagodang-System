@extends('layouts.public')

@section('content')
<section class="bg-emerald-950 text-white">
    <div class="max-w-7xl mx-auto px-4 py-16">
        <a href="{{ route('public.letters.show', $letterType->code) }}"
           class="inline-flex text-sm text-emerald-100 hover:text-white mb-5">
            ← Kembali ke Detail Surat
        </a>

        <p class="inline-flex rounded-full bg-white/10 px-4 py-2 text-sm text-emerald-100 border border-white/10">
            Pengajuan Online
        </p>

        <h1 class="mt-6 text-4xl md:text-5xl font-bold leading-tight">
            {{ $letterType->name }}
        </h1>

        <p class="mt-5 max-w-3xl text-emerald-100 leading-7">
            Informasi pengajuan surat online untuk layanan {{ $letterType->name }}.
        </p>
    </div>
</section>

<section class="max-w-4xl mx-auto px-4 py-16">
    <div class="rounded-3xl bg-white border border-slate-200 p-8 shadow-sm">

        @if (!config('features.public_letter_submission'))
            <div class="rounded-2xl bg-amber-50 border border-amber-200 p-6 text-amber-800">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-amber-100 flex items-center justify-center text-2xl shrink-0">
                        🚧
                    </div>

                    <div>
                        <h2 class="text-xl font-bold text-amber-900">
                            Pengajuan Online Segera Hadir
                        </h2>

                        <p class="mt-3 text-sm leading-6">
                            Fitur pengajuan surat online sedang dalam tahap persiapan dan validasi.
                            Untuk sementara, warga dapat melihat informasi persyaratan surat dan melakukan pengajuan langsung melalui kantor desa.
                        </p>

                        <div class="mt-5 rounded-xl bg-white/70 border border-amber-200 p-4 text-sm">
                            <p class="font-semibold text-amber-900">Informasi layanan saat ini:</p>
                            <ul class="mt-2 list-disc list-inside space-y-1">
                                <li>Jenis surat: {{ $letterType->name }}</li>
                                <li>Kode surat: {{ $letterType->code }}</li>
                                <li>Lokasi pengajuan: Kantor Desa Dolok Nagodang</li>
                                <li>Jam layanan: Senin - Jumat, 08.00 - 15.00</li>
                            </ul>
                        </div>

                        <div class="mt-6 flex flex-col sm:flex-row gap-3">
                            <a href="{{ route('public.letters.show', $letterType->code) }}"
                               class="inline-flex justify-center rounded-xl bg-emerald-600 px-5 py-3 text-sm font-semibold text-white hover:bg-emerald-700 transition">
                                Lihat Detail Persyaratan
                            </a>

                            <a href="{{ route('public.letters') }}"
                               class="inline-flex justify-center rounded-xl border border-amber-300 bg-white px-5 py-3 text-sm font-semibold text-amber-800 hover:bg-amber-50 transition">
                                Layanan Surat Lain
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @else
            @if (session('success'))
                <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm text-emerald-700">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 rounded-2xl border border-rose-200 bg-rose-50 px-5 py-4 text-sm text-rose-700">
                    <div class="font-semibold mb-2">Terjadi kesalahan:</div>
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('public.letters.storeApplication', $letterType->code) }}" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        NIK Pemohon
                    </label>
                    <input
                        type="text"
                        name="nik"
                        value="{{ old('nik') }}"
                        maxlength="16"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                        placeholder="Masukkan NIK"
                    >
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Nama Lengkap
                    </label>
                    <input
                        type="text"
                        name="full_name"
                        value="{{ old('full_name') }}"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                        placeholder="Masukkan nama lengkap"
                    >
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Nomor HP / WhatsApp
                    </label>
                    <input
                        type="text"
                        name="phone"
                        value="{{ old('phone') }}"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                        placeholder="Contoh: 08xxxxxxxxxx"
                    >
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Keperluan
                    </label>
                    <textarea
                        name="purpose"
                        rows="4"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm leading-6 focus:outline-none focus:ring-2 focus:ring-emerald-500"
                        placeholder="Jelaskan keperluan pengajuan surat"
                    >{{ old('purpose') }}</textarea>
                </div>

                <div class="rounded-2xl bg-sky-50 border border-sky-200 p-5 text-sm text-sky-800">
                    Pengajuan akan masuk ke menu Surat Elektronik admin dengan status
                    <strong>SUBMITTED</strong> untuk diverifikasi oleh petugas desa.
                </div>

                <div class="flex justify-end">
                    <button
                        type="submit"
                        class="rounded-xl bg-emerald-600 px-5 py-3 text-sm font-semibold text-white hover:bg-emerald-700 transition">
                        Kirim Pengajuan
                    </button>
                </div>
            </form>
        @endif

    </div>
</section>
@endsection