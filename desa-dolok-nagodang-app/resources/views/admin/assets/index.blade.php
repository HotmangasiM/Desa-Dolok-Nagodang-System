@extends('layouts.admin')

@section('content')

<div class="space-y-6">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div class="text-sm text-slate-500">
            Aksi cepat inventaris desa
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <button
                type="button"
                class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-medium text-slate-700 hover:bg-slate-50 shadow-sm transition">
                ⬇ Export
            </button>

            <a href="{{ route('admin.assets.create') }}"
               class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-5 py-3 text-sm font-semibold text-white hover:bg-emerald-700 shadow-lg shadow-emerald-600/20 transition">
                ＋ Tambah Inventaris
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <div class="rounded-2xl bg-white border border-slate-200 p-5 shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Total Inventaris</p>
                    <h3 class="mt-3 text-3xl font-bold text-slate-800">{{ number_format($allAssets) }}</h3>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-emerald-100 flex items-center justify-center text-2xl">
                    🏢
                </div>
            </div>
            <p class="mt-4 text-sm text-slate-500">Total seluruh aset desa</p>
        </div>

        <div class="rounded-2xl bg-white border border-slate-200 p-5 shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Kondisi Baik</p>
                    <h3 class="mt-3 text-3xl font-bold text-slate-800">{{ number_format($goodAssets) }}</h3>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-sky-100 flex items-center justify-center text-2xl">
                    ✅
                </div>
            </div>
            <p class="mt-4 text-sm text-slate-500">Aset dalam kondisi baik</p>
        </div>

        <div class="rounded-2xl bg-white border border-slate-200 p-5 shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Kondisi Rusak</p>
                    <h3 class="mt-3 text-3xl font-bold text-slate-800">{{ number_format($damagedAssets) }}</h3>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-rose-100 flex items-center justify-center text-2xl">
                    ⚠️
                </div>
            </div>
            <p class="mt-4 text-sm text-slate-500">Aset yang perlu perhatian</p>
        </div>
    </div>

    <div class="rounded-2xl bg-white border border-slate-200 shadow-sm p-5">
        <div class="flex items-center justify-between mb-5">
            <div>
                <h2 class="text-lg font-bold text-slate-800">Filter & Pencarian</h2>
                <p class="text-sm text-slate-500 mt-1">Gunakan filter untuk mempermudah pencarian inventaris.</p>
            </div>
        </div>

        <form method="GET" action="{{ route('admin.assets.index') }}" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-4">
            <div class="xl:col-span-2">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Cari Inventaris</label>
                <input
                    type="text"
                    name="search"
                    value="{{ $filters['search'] ?? '' }}"
                    placeholder="Cari nama barang, kode, atau kategori"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                >
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Kategori</label>
                <input
                    type="text"
                    name="category"
                    value="{{ $filters['category'] ?? '' }}"
                    placeholder="Contoh: Elektronik"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                >
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Kondisi</label>
                <select
                    name="condition"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                >
                    <option value="">Semua</option>
                    <option value="good" {{ ($filters['condition'] ?? '') === 'good' ? 'selected' : '' }}>Baik</option>
                    <option value="damaged" {{ ($filters['condition'] ?? '') === 'damaged' ? 'selected' : '' }}>Rusak</option>
                </select>
            </div>

            <div class="flex items-end gap-3">
                <button class="w-full rounded-xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white hover:bg-slate-800 transition">
                    Terapkan
                </button>
            </div>
        </form>
    </div>

    <div class="rounded-2xl bg-white border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-200 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h2 class="text-lg font-bold text-slate-800">Daftar Inventaris</h2>
                <p class="text-sm text-slate-500 mt-1">Data aset inventaris desa yang tersedia di sistem.</p>
            </div>

            <div class="inline-flex items-center gap-2 rounded-xl bg-slate-100 px-3 py-2 text-sm text-slate-600">
                <span>Menampilkan</span>
                <span class="font-semibold text-slate-800">{{ $assets->count() }}</span>
                <span>data</span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 text-slate-600">
                    <tr>
                        <th class="px-5 py-4 text-left font-semibold">No</th>
                        <th class="px-5 py-4 text-left font-semibold">Foto</th>
                        <th class="px-5 py-4 text-left font-semibold">Kode</th>
                        <th class="px-5 py-4 text-left font-semibold">Nama Barang</th>
                        <th class="px-5 py-4 text-left font-semibold">Kategori</th>
                        <th class="px-5 py-4 text-left font-semibold">Jumlah</th>
                        <th class="px-5 py-4 text-left font-semibold">Kondisi</th>
                        <th class="px-5 py-4 text-left font-semibold">Lokasi</th>
                        <th class="px-5 py-4 text-center font-semibold">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse ($assets as $index => $asset)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="px-5 py-4">
                                {{ ($assets->firstItem() ?? 0) + $index }}
                            </td>

                            <td class="px-5 py-4">
                                @if($asset->asset_photo)
                                    <img src="{{ asset('storage/' . $asset->asset_photo) }}"
                                         alt="{{ $asset->item_name }}"
                                         class="w-16 h-12 object-cover rounded-lg border border-slate-200 shadow-sm">
                                @else
                                    <span class="text-slate-400 text-xs">No Image</span>
                                @endif
                            </td>

                            <td class="px-5 py-4 font-medium text-slate-700">
                                {{ $asset->item_code }}
                            </td>

                            <td class="px-5 py-4">
                                <div>
                                    <p class="font-semibold text-slate-800">{{ $asset->item_name }}</p>
                                    <!-- <p class="text-xs text-slate-500 mt-1">
                                        {{ $asset->description ? \Illuminate\Support\Str::limit(strip_tags($asset->description), 60) : '-' }}
                                    </p> -->
                                </div>
                            </td>

                            <td class="px-5 py-4 text-slate-600">
                                {{ $asset->category ?? '-' }}
                            </td>

                            <td class="px-5 py-4 text-slate-600">
                                {{ $asset->quantity }}
                            </td>

                            <td class="px-5 py-4">
                                @if ($asset->condition === 'good')
                                    <span class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                                        Baik
                                    </span>
                                @else
                                    <span class="inline-flex rounded-full bg-rose-100 px-3 py-1 text-xs font-semibold text-rose-700">
                                        Rusak
                                    </span>
                                @endif
                            </td>

                            <td class="px-5 py-4 text-slate-600">
                                {{ $asset->location ?? '-' }}
                            </td>

                            <td class="px-5 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.assets.edit', $asset->id) }}"
                                       class="rounded-lg bg-sky-50 px-3 py-2 text-sky-700 font-medium hover:bg-sky-100 transition">
                                        Edit
                                    </a>

                                  <form action="{{ route('admin.assets.destroy', $asset->id) }}" 
                                    method="POST" 
                                    class="inline delete-form">
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="button"
                                        class="btn-delete rounded-lg bg-rose-50 px-3 py-2 text-rose-700 font-medium hover:bg-rose-100 transition"
                                        data-name="{{ $asset->item_name }}"
                                    >
                                        Delete
                                    </button>
                                </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-5 py-8 text-center text-slate-500">
                                Data inventaris belum tersedia.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-5 py-4 border-t border-slate-200 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <p class="text-sm text-slate-500">
                Showing {{ $assets->firstItem() ?? 0 }} to {{ $assets->lastItem() ?? 0 }} of {{ $assets->total() }} entries
            </p>

            <div>
                {{ $assets->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    // Pastikan SweetAlert ada
    if (typeof Swal === 'undefined') {
        console.error('SweetAlert tidak ter-load!');
        return;
    }

    // Tangkap semua klik tombol delete
    document.addEventListener('click', function (e) {

        const button = e.target.closest('.btn-delete');

        if (!button) return;

        e.preventDefault();

        const form = button.closest('form');
        const nama = button.dataset.name || 'data ini';

        if (!form) {
            console.error('Form tidak ditemukan!');
            return;
        }

        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: `Apakah Anda yakin ingin menghapus "${nama}"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            reverseButtons: true
        }).then((result) => {

            if (result.isConfirmed) {

                Swal.fire({
                    title: 'Menghapus...',
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
