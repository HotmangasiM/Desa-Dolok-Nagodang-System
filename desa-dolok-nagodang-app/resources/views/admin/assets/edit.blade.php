@extends('layouts.admin')

@section('content')
<div class="space-y-6">
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

    <form action="{{ route('admin.assets.update', $asset->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="rounded-2xl bg-white border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200">
                <h2 class="text-lg font-bold text-slate-800">Informasi Inventaris</h2>
                <p class="text-sm text-slate-500 mt-1">Perbarui informasi utama aset inventaris desa.</p>
            </div>

            <div class="p-6 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Nama Barang <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="item_name" value="{{ old('item_name', $asset->item_name) }}"
                        data-letter-space-only
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                        placeholder="Masukkan nama barang">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Kode Barang <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="item_code" value="{{ old('item_code', $asset->item_code) }}"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                        placeholder="Masukkan kode barang">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Kategori</label>
                    <input type="text" name="category" value="{{ old('category', $asset->category) }}"
                        data-letter-space-only
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                        placeholder="Contoh: Elektronik">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Jumlah <span class="text-rose-500">*</span>
                    </label>
                    <input type="number" name="quantity" min="0" value="{{ old('quantity', $asset->quantity) }}"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Kondisi <span class="text-rose-500">*</span>
                    </label>
                    <select name="condition"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        <option value="">Pilih Kondisi</option>
                        <option value="good" {{ old('condition', $asset->condition) === 'good' ? 'selected' : '' }}>Baik</option>
                        <option value="damaged" {{ old('condition', $asset->condition) === 'damaged' ? 'selected' : '' }}>Rusak</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Lokasi</label>
                    <input type="text" name="location" value="{{ old('location', $asset->location) }}"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                        placeholder="Contoh: Ruang Admin">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Perolehan</label>
                    <input type="date" name="acquisition_date"
                        value="{{ old('acquisition_date', $asset->acquisition_date ? $asset->acquisition_date->format('Y-m-d') : '') }}"
                        max="{{ now()->toDateString() }}"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Sumber</label>
                    <input type="text" name="source" value="{{ old('source', $asset->source) }}"
                        data-letter-space-only
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                        placeholder="Contoh: Dana Desa">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Nilai Aset
                    </label>

                    <input
                        type="hidden"
                        name="asset_value"
                        id="asset_value"
                        value="{{ old('asset_value', (int) $asset->asset_value) }}"
                    >

                    <input
                        type="text"
                        id="asset_value_display"
                        value="{{ old('asset_value')
                            ? 'Rp ' . number_format((int) old('asset_value'), 0, ',', '.')
                            : ($asset->asset_value
                                ? 'Rp ' . number_format((int) $asset->asset_value, 0, ',', '.')
                                : '') }}"
                        inputmode="numeric"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                        placeholder="Contoh: Rp 100.000.000"
                    >
                </div>

                <div class="md:col-span-2 xl:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Foto Aset</label>

                    <div class="mb-3">
                        @if($asset->asset_photo)
                            <img src="{{ asset('storage/' . $asset->asset_photo) }}"
                                alt="{{ $asset->item_name }}"
                                class="w-40 h-28 rounded-xl object-cover border border-slate-200 shadow-sm">
                            <p class="mt-2 text-xs text-slate-500">Foto saat ini</p>
                        @else
                            <div class="w-40 h-28 rounded-xl bg-slate-100 text-slate-400 flex items-center justify-center text-sm border border-slate-200">
                                No Image
                            </div>
                        @endif
                    </div>

                    <input type="file" name="asset_photo" accept="image/*" onchange="previewAssetImage(event)"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">

                    <p class="text-xs text-slate-500 mt-2">
                        Kosongkan jika tidak ingin mengganti foto. Format: JPG, PNG, JPEG max 2MB.
                    </p>

                    <img id="assetImagePreview"
                        class="hidden mt-3 w-40 h-28 rounded-xl object-cover border border-slate-200 shadow-sm">
                </div>

                <div class="xl:col-span-3">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Catatan</label>
                    <textarea name="notes" rows="3"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm leading-6 focus:outline-none focus:ring-2 focus:ring-emerald-500"
                        placeholder="Catatan tambahan inventaris...">{{ old('notes', $asset->notes) }}</textarea>
                </div>

                <div class="xl:col-span-3">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Deskripsi</label>
                    <textarea name="description" rows="4"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm leading-6 focus:outline-none focus:ring-2 focus:ring-emerald-500"
                        placeholder="Deskripsi detail aset inventaris...">{{ old('description', $asset->description) }}</textarea>
                </div>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row items-center justify-end gap-3">
            <a href="{{ route('admin.assets.index') }}"
                class="w-full sm:w-auto inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-5 py-3 text-sm font-medium text-slate-700 hover:bg-slate-50 transition">
                Batal
            </a>

            <button type="submit"
                class="w-full sm:w-auto inline-flex items-center justify-center rounded-xl bg-emerald-600 px-5 py-3 text-sm font-semibold text-white hover:bg-emerald-700 shadow-lg shadow-emerald-600/20 transition">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
function previewAssetImage(event) {
    const input = event.target;
    const preview = document.getElementById('assetImagePreview');

    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
        };

        reader.readAsDataURL(input.files[0]);
    }
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

function sanitizeLetterSpaceInput(value) {
    return value.replace(/[^\p{L}\s]/gu, '').replace(/\s{2,}/g, ' ');
}

document.addEventListener('DOMContentLoaded', function () {
    const assetValue = document.getElementById('asset_value');
    const assetValueDisplay = document.getElementById('asset_value_display');

    document.querySelectorAll('[data-letter-space-only]').forEach(function (input) {
        input.addEventListener('input', function () {
            this.value = sanitizeLetterSpaceInput(this.value);
        });
    });

    if (assetValue && assetValueDisplay) {
        assetValueDisplay.addEventListener('input', function () {
            const result = formatRupiah(this.value);

            assetValue.value = result.raw;
            this.value = result.formatted;
        });
    }

    if (typeof Swal === 'undefined') {
        console.error('SweetAlert tidak ter-load!');
        return;
    }

    document.addEventListener('submit', function (e) {
        const form = e.target;

        if (!form.action.includes('assets')) return;

        if (assetValue && assetValueDisplay) {
            const result = formatRupiah(assetValueDisplay.value);
            assetValue.value = result.raw;
            assetValueDisplay.value = result.formatted;
        }

        if (form.dataset.confirmed === 'true') return;

        e.preventDefault();

        const nama = form.querySelector('input[name="item_name"]').value;

        Swal.fire({
            title: 'Konfirmasi Perubahan',
            text: `Simpan perubahan untuk "${nama}"?`,
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
                    showConfirmButton: false,
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
