@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div>
            <a href="{{ route('admin.letters.index') }}"
               class="inline-flex items-center gap-2 text-sm font-medium text-slate-500 hover:text-slate-700 mb-3">
                ← Kembali ke Surat Elektronik
            </a>

            <h1 class="text-3xl font-bold tracking-tight text-slate-800">Tambah Surat Elektronik</h1>
            <p class="text-sm text-slate-500 mt-2">
                Lengkapi form berikut untuk menambahkan data surat baru.
            </p>
        </div>
    </div>

    @if ($errors->any())
        <div class="rounded-2xl border border-rose-200 bg-rose-50 px-5 py-4 text-sm text-rose-700">
            <div class="font-semibold mb-2">Terjadi kesalahan pada input:</div>
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.letters.store') }}" method="POST" class="space-y-6">
        @csrf

        <div class="rounded-2xl bg-white border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200">
                <h2 class="text-lg font-bold text-slate-800">Informasi Surat</h2>
                <p class="text-sm text-slate-500 mt-1">Masukkan informasi utama surat elektronik.</p>
            </div>

            <div class="p-6 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Nomor Surat 
                    </label>
                    <input
                        type="text"
                        value="Otomatis dibuat setelah data disimpan"
                        readonly
                        class="w-full rounded-xl border border-slate-200 bg-slate-100 px-4 py-3 text-sm text-slate-500"
                    >
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Jenis Surat <span class="text-rose-500">*</span>
                    </label>
                    <select
                        name="letter_type_id"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                    >
                        <option value="">Pilih Jenis Surat</option>
                        @foreach ($letterTypes as $type)
                            <option value="{{ $type->id }}" {{ (string)old('letter_type_id') === (string)$type->id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Pemohon <span class="text-rose-500">*</span>
                    </label>
                    <select
                        name="citizen_id"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                    >
                        <option value="">Pilih Penduduk</option>
                        @foreach ($citizens as $citizen)
                            <option value="{{ $citizen->id }}" {{ (string)old('citizen_id') === (string)$citizen->id ? 'selected' : '' }}>
                                {{ $citizen->full_name }} - {{ $citizen->nik }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-2 xl:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Subjek <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="subject"
                        value="{{ old('subject') }}"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                        placeholder="Masukkan subjek surat"
                    >
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Status <span class="text-rose-500">*</span>
                    </label>
                    <select
                        name="status"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                    >
                        <option value="">Pilih Status</option>
                        <option value="submitted" {{ old('status') === 'submitted' ? 'selected' : '' }}>submitted</option>
                        <option value="processed" {{ old('status') === 'processed' ? 'selected' : '' }}>processed</option>
                        <option value="approved" {{ old('status') === 'approved' ? 'selected' : '' }}>approved</option>
                        <option value="rejected" {{ old('status') === 'rejected' ? 'selected' : '' }}>rejected</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Pengajuan</label>
                    <input
                        type="date"
                        name="submission_date"
                        value="{{ old('submission_date') }}"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                    >
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Persetujuan</label>
                    <input
                        type="date"
                        name="approval_date"
                        value="{{ old('approval_date') }}"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                    >
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Approved By</label>
                    <input
                        type="number"
                        name="approved_by"
                        value="{{ old('approved_by') }}"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                        placeholder="Masukkan ID approver"
                    >
                </div>

                <div class="md:col-span-2 xl:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">File Hasil</label>
                    <input
                        type="text"
                        name="result_file"
                        value="{{ old('result_file') }}"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                        placeholder="Contoh: letters/surat-001.pdf"
                    >
                </div>

                <div class="xl:col-span-3">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Deskripsi</label>
                    <textarea
                        name="description"
                        rows="4"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm leading-6 focus:outline-none focus:ring-2 focus:ring-emerald-500"
                        placeholder="Deskripsi surat..."
                    >{{ old('description') }}</textarea>
                </div>

                <div class="xl:col-span-3">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Catatan</label>
                    <textarea
                        name="notes"
                        rows="4"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm leading-6 focus:outline-none focus:ring-2 focus:ring-emerald-500"
                        placeholder="Catatan tambahan..."
                    >{{ old('notes') }}</textarea>
                </div>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row items-center justify-end gap-3">
            <a href="{{ route('admin.letters.index') }}"
               class="w-full sm:w-auto inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-5 py-3 text-sm font-medium text-slate-700 hover:bg-slate-50 transition">
                Batal
            </a>

            <button
                type="submit"
                class="w-full sm:w-auto inline-flex items-center justify-center rounded-xl bg-emerald-600 px-5 py-3 text-sm font-semibold text-white hover:bg-emerald-700 shadow-lg shadow-emerald-600/20 transition">
                Simpan Surat
            </button>
        </div>
    </form>
</div>
@endsection