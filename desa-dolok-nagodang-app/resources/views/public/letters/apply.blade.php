@extends('layouts.public')

@section('content')
<section class="bg-emerald-950 text-white">
    <div class="max-w-7xl mx-auto px-4 py-16">
        <a href="{{ route('public.letters.show', $letterType->code) }}"
           class="mb-5 inline-flex items-center gap-2 text-sm text-emerald-100 hover:text-white">
            <i data-lucide="arrow-left" class="h-4 w-4"></i>
            Kembali ke Detail Surat
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
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-amber-100 text-amber-700">
                        <i data-lucide="construction" class="h-6 w-6"></i>
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
                    <div class="flex items-start gap-3">
                        <div class="mt-0.5 flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-emerald-100 text-emerald-700">
                            <i data-lucide="badge-check" class="h-5 w-5"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-emerald-900">Pengajuan berhasil dikirim</p>
                            <p class="mt-1 leading-6">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 rounded-2xl border border-rose-200 bg-rose-50 px-5 py-4 text-sm text-rose-700">
                    <div class="flex items-start gap-3">
                        <div class="mt-0.5 flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-rose-100 text-rose-700">
                            <i data-lucide="alert-circle" class="h-5 w-5"></i>
                        </div>
                        <div class="min-w-0">
                            <div class="mb-2 font-semibold text-rose-900">Terjadi kesalahan pada pengajuan</div>
                            <ul class="list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('public.letters.storeApplication', $letterType->code) }}" class="space-y-6" data-inline-validate>
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
                        inputmode="numeric"
                        required
                        data-required-label="NIK Pemohon"
                        data-sanitize="digits"
                        data-pattern="^\d{16}$"
                        data-pattern-message="NIK pemohon harus terdiri dari 16 digit angka."
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                        placeholder="Masukkan NIK"
                    >
                    @error('nik')
                        <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Nama Lengkap
                    </label>
                    <input
                        type="text"
                        name="full_name"
                        value="{{ old('full_name') }}"
                        required
                        data-required-label="Nama Lengkap"
                        data-pattern="^[A-Za-z\\s'.-]+$"
                        data-pattern-message="Nama lengkap hanya boleh berisi huruf, spasi, titik, apostrof, dan tanda hubung."
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                        placeholder="Masukkan nama lengkap"
                    >
                    @error('full_name')
                        <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Nomor HP / WhatsApp
                    </label>
                    <input
                        type="text"
                        name="phone"
                        value="{{ old('phone') }}"
                        inputmode="numeric"
                        maxlength="15"
                        data-sanitize="digits"
                        data-pattern="^\d{10,15}$"
                        data-pattern-message="Nomor HP / WhatsApp harus terdiri dari 10 sampai 15 digit angka."
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                        placeholder="Contoh: 08xxxxxxxxxx"
                    >
                    @error('phone')
                        <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
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
                    @error('purpose')
                        <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
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
