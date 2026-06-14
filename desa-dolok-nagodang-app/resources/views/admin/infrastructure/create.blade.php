@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">

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
        action="{{ route('admin.infrastructure.store') }}"
        method="POST"
        enctype="multipart/form-data"
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
                            Nama Barang
                        </label>

                        <input
                            type="text"
                            name="nama_barang"
                            value="{{ old('nama_barang') }}"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                        >
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
                            class="w-full rounded-xl border border-slate-300 px-4 py-3"
                        >
                    </div>

                    {{-- NILAI --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Nilai / Harga
                        </label>

                        <input
                            type="number"
                            name="nilai_harga"
                            value="{{ old('nilai_harga') }}"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3"
                        >
                    </div>

                    {{-- TAHUN --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Tahun Pengadaan
                        </label>

                        <input
                            type="number"
                            name="tahun_pengadaan"
                            value="{{ old('tahun_pengadaan') }}"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3"
                        >
                    </div>

                    {{-- KONDISI --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Kondisi
                        </label>

                        <select
                            name="kondisi"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3"
                        >
                            <option value="">Pilih Kondisi</option>
                            <option value="Baik">Baik</option>
                            <option value="Rusak Ringan">Rusak Ringan</option>
                            <option value="Rusak Berat">Rusak Berat</option>
                        </select>
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
                            <option value="ADD">ADD</option>
                            <option value="DD">DD</option>
                            <option value="HIBAH">HIBAH</option>
                            <option value="SUMBANGAN">SUMBANGAN</option>
                        </select>
                    </div>

                    {{-- STATUS --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Status Publish
                        </label>

                        <select
                            name="status"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3"
                        >
                            <option value="draft">Draft</option>
                            <option value="publish">Publish</option>
                        </select>
                    </div>

                    {{-- FOTO --}}
                    <div class="xl:col-span-3">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Foto Aset
                        </label>

                        <input
                            type="file"
                            name="image"
                            accept="image/*"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3"
                        >
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
                class="px-6 py-3 rounded-xl bg-emerald-600 text-white font-semibold hover:bg-emerald-700 shadow-lg shadow-emerald-600/20"
            >
                Simpan Data Aset
            </button>

        </div>

    </form>

</div>
@endsection
```
