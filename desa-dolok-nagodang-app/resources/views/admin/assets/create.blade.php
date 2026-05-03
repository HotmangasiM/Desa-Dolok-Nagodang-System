@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div>
            <a href="{{ route('admin.assets.index') }}"
               class="inline-flex items-center gap-2 text-sm font-medium text-slate-500 hover:text-slate-700 mb-3">
                ← Kembali ke Inventaris Desa
            </a>

            <h1 class="text-3xl font-bold tracking-tight text-slate-800">Tambah Inventaris Desa</h1>
            <p class="text-sm text-slate-500 mt-2">
                Lengkapi form berikut untuk menambahkan data inventaris baru.
            </p>
        </div>
    </div> -->

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

    <form method="POST" action="{{ route('admin.assets.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="rounded-2xl bg-white border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200">
                <h2 class="text-lg font-bold text-slate-800">Informasi Inventaris</h2>
                <p class="text-sm text-slate-500 mt-1">Masukkan informasi utama aset inventaris desa.</p>
            </div>

            <div class="p-6 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Nama Barang <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="item_name"
                        value="{{ old('item_name') }}"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                        placeholder="Masukkan nama barang"
                    >
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Kode Barang <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="item_code"
                        value="{{ old('item_code') }}"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                        placeholder="Masukkan kode barang"
                    >
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Kategori</label>
                    <input
                        type="text"
                        name="category"
                        value="{{ old('category') }}"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                        placeholder="Contoh: Elektronik"
                    >
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Jumlah <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="number"
                        name="quantity"
                        min="0"
                        value="{{ old('quantity', 0) }}"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                    >
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Kondisi <span class="text-rose-500">*</span>
                    </label>
                    <select
                        name="condition"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                    >
                        <option value="">Pilih Kondisi</option>
                        <option value="good" {{ old('condition') === 'good' ? 'selected' : '' }}>good</option>
                        <option value="damaged" {{ old('condition') === 'damaged' ? 'selected' : '' }}>damaged</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Lokasi</label>
                    <input
                        type="text"
                        name="location"
                        value="{{ old('location') }}"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                        placeholder="Contoh: Ruang Admin"
                    >
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Perolehan</label>
                    <input
                        type="date"
                        name="acquisition_date"
                        value="{{ old('acquisition_date') }}"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                    >
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Sumber</label>
                    <input
                        type="text"
                        name="source"
                        value="{{ old('source') }}"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                        placeholder="Contoh: Dana Desa"
                    >
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nilai Aset</label>
                    <input
                        type="number"
                        step="0.01"
                        name="asset_value"
                        value="{{ old('asset_value') }}"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                        placeholder="Contoh: 15000000"
                    >
                </div>

                <div class="md:col-span-2 xl:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Foto Aset
                    </label>

                    <input
                        type="file"
                        name="asset_photo"
                        accept="image/*"
                        onchange="previewAssetImage(event)"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                    >

                    <p class="text-xs text-slate-500 mt-2">
                        Format: JPG, PNG, JPEG (max 2MB)
                    </p>

                    <!-- Preview -->
                    <div class="mt-4">
                        <img id="assetPreview"
                            class="hidden w-40 h-28 object-cover rounded-xl border border-slate-200 shadow-sm">
                    </div>
                </div>

                <div class="xl:col-span-3">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Catatan</label>
                    <textarea
                        name="notes"
                        rows="3"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm leading-6 focus:outline-none focus:ring-2 focus:ring-emerald-500"
                        placeholder="Catatan tambahan inventaris..."
                    >{{ old('notes') }}</textarea>
                </div>

                <div class="xl:col-span-3">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Deskripsi</label>
                    <textarea
                        name="description"
                        rows="4"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm leading-6 focus:outline-none focus:ring-2 focus:ring-emerald-500"
                        placeholder="Deskripsi detail aset inventaris..."
                    >{{ old('description') }}</textarea>
                </div>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row items-center justify-end gap-3">
            <a href="{{ route('admin.assets.index') }}"
               class="w-full sm:w-auto inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-5 py-3 text-sm font-medium text-slate-700 hover:bg-slate-50 transition">
                Batal
            </a>

            <button
                type="submit"
                class="w-full sm:w-auto inline-flex items-center justify-center rounded-xl bg-emerald-600 px-5 py-3 text-sm font-semibold text-white hover:bg-emerald-700 shadow-lg shadow-emerald-600/20 transition">
                Simpan Inventaris
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    if (typeof Swal === 'undefined') {
        console.error('SweetAlert tidak ter-load!');
        return;
    }

    // Tangkap SEMUA form submit
    document.addEventListener('submit', function (e) {

        const form = e.target;

        // hanya target form create (optional filter)
        if (!form.action.includes('assets')) return;

        // cegah submit dulu
        e.preventDefault();

        // supaya tidak loop
        if (form.dataset.confirmed === 'true') return;

        Swal.fire({
            title: 'Konfirmasi Tambah Data',
            text: 'Apakah Anda yakin ingin menyimpan data inventaris ini?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, simpan',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#10b981',
            cancelButtonColor: '#6b7280',
            reverseButtons: true
        }).then((result) => {

            if (result.isConfirmed) {

                form.dataset.confirmed = 'true';

                Swal.fire({
                    title: 'Menyimpan...',
                    text: 'Mohon tunggu',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                form.submit();
            }

        });

    });

});
</script>
@endpush