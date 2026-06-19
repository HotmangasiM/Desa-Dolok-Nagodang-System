@extends('layouts.admin')
@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    @php($yearOptions = range(now()->year, 1900))

    {{-- HEADER --}}
    <div>
        <h1 class="text-2xl font-bold text-slate-800">
            Tambah Data Pembangunan Infrastruktur Desa
        </h1>

        <p class="text-sm text-slate-500 mt-1">
            Input data aset desa sesuai laporan inventaris desa.
        </p>
    </div>

    {{-- ERROR --}}
    @if ($errors->any())
        <div class="rounded-2xl border border-rose-200 bg-rose-50 p-5">
            <div class="font-semibold text-rose-700 mb-2">
                Terjadi kesalahan:
            </div>

            <ul class="list-disc list-inside text-sm text-rose-600 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
    id="infrastructureCreateForm"
    action="{{ route('admin.infrastructure.store') }}"
    method="POST"
    enctype="multipart/form-data"
    data-inline-validate
>
        @csrf

        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

            {{-- CARD HEADER --}}
            <div class="px-6 py-5 border-b border-slate-200">
                <h2 class="font-semibold text-slate-800">
                    Informasi Infrastruktur
                </h2>
            </div>

            {{-- FORM CONTENT --}}
            <div class="p-6">

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">

                    {{-- NAMA BARANG --}}
                    <div class="xl:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Nama Barang <span class="text-rose-500">*</span>
                        </label>

                        <input
                            type="text"
                            name="nama_barang"
                            value="{{ old('nama_barang') }}"
                            required
                            data-required-label="Nama Barang"
                            data-alpha-num-space-only
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                        >
                        @include('admin.partials.field-error', ['field' => 'nama_barang'])
                    </div>

                    {{-- KODE BARANG --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Kode Barang
                        </label>

                        <input
                            type="text"
                            name="kode_barang"
                            value="{{ old('kode_barang') }}"
                            data-code-only
                            class="w-full rounded-xl border border-slate-300 px-4 py-3"
                        >
                    </div>

                    {{-- JENIS --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Jenis Barang / Merk
                        </label>

                        <input
                            type="text"
                            name="jenis_barang"
                            value="{{ old('jenis_barang') }}"
                            data-alpha-num-space-only
                            class="w-full rounded-xl border border-slate-300 px-4 py-3"
                        >
                    </div>

                    {{-- JUMLAH --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Jumlah / Luas
                        </label>

                        <input
                            type="text"
                            name="jumlah_luas"
                            value="{{ old('jumlah_luas') }}"
                            data-alpha-num-space-only
                            class="w-full rounded-xl border border-slate-300 px-4 py-3"
                        >
                    </div>

                    {{-- NILAI --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Nilai / Harga
                        </label>

                        <input
                            type="hidden"
                            name="nilai_harga"
                            id="nilai_harga"
                            value="{{ old('nilai_harga') }}"
                        >

                        <input
                            type="text"
                            id="nilai_harga_display"
                            value="{{ old('nilai_harga') ? 'Rp ' . number_format((float) old('nilai_harga'), 0, ',', '.') : '' }}"
                            inputmode="numeric"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3"
                            placeholder="Contoh: Rp 17.000.000"
                        >
                    </div>

                    {{-- TAHUN --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Tahun Pengadaan
                        </label>

                        <select
                            name="tahun_pengadaan"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3"
                        >
                            <option value="">Pilih Tahun</option>
                            @foreach ($yearOptions as $year)
                                <option value="{{ $year }}" {{ (string) old('tahun_pengadaan') === (string) $year ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- KONDISI --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Kondisi <span class="text-rose-500">*</span>
                        </label>

                        <select
                            name="kondisi"
                            required
                            data-required-label="Kondisi"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3"
                        >
                            <option value="">Pilih Kondisi</option>
                            <option value="Baik" {{ old('kondisi') === 'Baik' ? 'selected' : '' }}>Baik</option>
                            <option value="Rusak Ringan" {{ old('kondisi') === 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                            <option value="Rusak Berat" {{ old('kondisi') === 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                        </select>
                        @include('admin.partials.field-error', ['field' => 'kondisi'])
                    </div>

                    {{-- KETERANGAN --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Keterangan
                        </label>

                        <select
                            name="keterangan"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3"
                        >
                            <option value="">Pilih</option>
                            <option value="ADD" {{ old('keterangan') === 'ADD' ? 'selected' : '' }}>ADD</option>
                            <option value="DD" {{ old('keterangan') === 'DD' ? 'selected' : '' }}>DD</option>
                            <option value="HIBAH" {{ old('keterangan') === 'HIBAH' ? 'selected' : '' }}>HIBAH</option>
                            <option value="SUMBANGAN" {{ old('keterangan') === 'SUMBANGAN' ? 'selected' : '' }}>SUMBANGAN</option>
                        </select>
                    </div>

                    {{-- STATUS --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Status Publish <span class="text-rose-500">*</span>
                        </label>

                        <select
                            name="status"
                            required
                            data-required-label="Status Publish"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3"
                        >
                            <option value="draft" {{ old('status', 'draft') === 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="publish" {{ old('status') === 'publish' ? 'selected' : '' }}>Publish</option>
                        </select>
                        @include('admin.partials.field-error', ['field' => 'status'])
                    </div>

                    {{-- FOTO --}}
                    <div class="xl:col-span-3">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Foto Aset <span class="text-rose-500">*</span>
                        </label>

                        <input
                            type="file"
                            name="image"
                            required
                            data-required-label="Foto Aset"
                            accept="image/*"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3"
                        >
                        @include('admin.partials.field-error', ['field' => 'image'])
                    </div>

                    {{-- MASALAH ASET --}}
                    <div class="xl:col-span-3">
                     <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Isi Konten Pembangunan / Deskripsi Lengkap
                    </label>

                    <textarea
                        name="content"
                        rows="10"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3"
                        placeholder="Masukkan deskripsi lengkap aset, sejarah pembangunan, sumber anggaran, manfaat, dan informasi lainnya..."
                    >{{ old('content') }}
                    </textarea>
                    </div>

                </div>

            </div>

        </div>

        {{-- BUTTON --}}
        <div class="flex justify-end gap-3 pt-2">

            <a href="{{ route('admin.infrastructure.index') }}"
               class="px-5 py-3 rounded-xl border border-slate-300 text-slate-700 hover:bg-slate-50">
                Batal
            </a>

            <button
            type="submit"
            id="btnSubmit"
            class="px-6 py-3 rounded-xl bg-emerald-600 text-white font-semibold hover:bg-emerald-700 shadow-lg shadow-emerald-600/20"
        >
            Simpan Data Infrastruktur
        </button>
        </div>

    </form>

</div>
@push('scripts')
<script>
function sanitizeAlphaNumSpace(value) {
    return value.replace(/[^\p{L}\p{N}\s]/gu, '').replace(/\s{2,}/g, ' ');
}

function sanitizeCodeValue(value) {
    return value.replace(/[^A-Za-z0-9\s\-\/]/g, '').replace(/\s{2,}/g, ' ');
}

function formatRupiah(value) {
    const numericValue = value.replace(/[^0-9]/g, '');

    if (!numericValue) {
        return {
            raw: '',
            formatted: ''
        };
    }

    return {
        raw: numericValue,
        formatted: 'Rp ' + new Intl.NumberFormat('id-ID').format(numericValue)
    };
}

document.addEventListener('DOMContentLoaded', function () {

    const form = document.querySelector('#infrastructureCreateForm');
    const nilaiHarga = document.getElementById('nilai_harga');
    const nilaiHargaDisplay = document.getElementById('nilai_harga_display');

    document.querySelectorAll('[data-alpha-num-space-only]').forEach(function (input) {
        input.addEventListener('input', function () {
            this.value = sanitizeAlphaNumSpace(this.value);
        });
    });

    document.querySelectorAll('[data-code-only]').forEach(function (input) {
        input.addEventListener('input', function () {
            this.value = sanitizeCodeValue(this.value);
        });
    });

    if (nilaiHarga && nilaiHargaDisplay) {
        nilaiHargaDisplay.addEventListener('input', function () {
            const result = formatRupiah(this.value);

            nilaiHarga.value = result.raw;
            this.value = result.formatted;
        });
    }

    if (!form) return;

    form.addEventListener('submit', function (e) {

        if (form.dataset.confirmed === 'true') {
            return;
        }

        if (nilaiHarga && nilaiHargaDisplay) {
            const result = formatRupiah(nilaiHargaDisplay.value);
            nilaiHarga.value = result.raw;
            nilaiHargaDisplay.value = result.formatted;
        }

        if (window.AdminInlineValidation && !window.AdminInlineValidation.validateForm(form)) {
            e.preventDefault();
            return;
        }

        if (typeof Swal === 'undefined') {
            form.dataset.confirmed = 'true';
            return;
        }

        e.preventDefault();

        Swal.fire({
            title: 'Konfirmasi Tambah Data',
            text: 'Apakah Anda yakin ingin menyimpan data pembangunan infrastruktur ini?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Simpan',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#10b981',
            cancelButtonColor: '#6b7280',
            reverseButtons: true
        }).then((result) => {

            if (result.isConfirmed) {

                form.dataset.confirmed = 'true';

                Swal.fire({
                    title: 'Menyimpan Data...',
                    text: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                if (form.requestSubmit) {
                    form.requestSubmit();
                } else {
                    form.submit();
                }
            }

        });

    });

});
</script>
@endpush
@endsection
