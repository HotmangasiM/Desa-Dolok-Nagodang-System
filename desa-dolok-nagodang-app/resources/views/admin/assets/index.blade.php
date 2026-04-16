@extends('layouts.admin')

@section('content')
@if (session('success'))
    <div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
        {{ session('success') }}
    </div>
@endif

<div class="space-y-6">
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold tracking-tight text-slate-800">Inventaris Desa</h1>
            <p class="text-sm text-slate-500 mt-2">
                Kelola data aset dan inventaris desa secara terpusat.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <button class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-medium text-slate-700 hover:bg-slate-50 shadow-sm transition">
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
                    <option value="good" {{ ($filters['condition'] ?? '') === 'good' ? 'selected' : '' }}>good</option>
                    <option value="damaged" {{ ($filters['condition'] ?? '') === 'damaged' ? 'selected' : '' }}>damaged</option>
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

                            <td class="px-5 py-4 font-medium text-slate-700">
                                {{ $asset->item_code }}
                            </td>

                            <td class="px-5 py-4">
                                <div>
                                    <p class="font-semibold text-slate-800">{{ $asset->item_name }}</p>
                                    <p class="text-xs text-slate-500 mt-1">
                                        {{ $asset->description ? \Illuminate\Support\Str::limit(strip_tags($asset->description), 60) : '-' }}
                                    </p>
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
                                        good
                                    </span>
                                @else
                                    <span class="inline-flex rounded-full bg-rose-100 px-3 py-1 text-xs font-semibold text-rose-700">
                                        damaged
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

                                    <button
                                        type="button"
                                        class="rounded-lg bg-rose-50 px-3 py-2 text-rose-700 font-medium hover:bg-rose-100 transition"
                                        onclick="openDeleteModal('{{ $asset->id }}', '{{ addslashes($asset->item_name) }}')"
                                    >
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-5 py-8 text-center text-slate-500">
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

<div id="deleteModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/50 px-4">
    <div class="w-full max-w-md rounded-2xl bg-white shadow-2xl">
        <div class="p-6 border-b border-slate-200">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-full bg-rose-100 flex items-center justify-center text-2xl">
                    ⚠️
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-800">Konfirmasi Hapus</h3>
                    <p class="text-sm text-slate-500">Tindakan ini akan melakukan soft delete data inventaris.</p>
                </div>
            </div>
        </div>

        <div class="p-6">
            <p class="text-sm text-slate-600 leading-6">
                Apakah kamu yakin ingin menghapus inventaris
                <span id="assetName" class="font-semibold text-slate-800"></span>?
            </p>
        </div>

        <form id="deleteAssetForm" method="POST" action="">
            @csrf
            @method('DELETE')

            <div class="px-6 pb-6 flex items-center justify-end gap-3">
                <button
                    type="button"
                    onclick="closeDeleteModal()"
                    class="rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50 transition"
                >
                    Batal
                </button>

                <button
                    type="submit"
                    class="rounded-xl bg-rose-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-rose-700 transition"
                >
                    Ya, Hapus
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function openDeleteModal(id, name) {
        document.getElementById('assetName').textContent = name;
        document.getElementById('deleteAssetForm').action = `/admin/assets/${id}`;
        const modal = document.getElementById('deleteModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');
        modal.classList.remove('flex');
        modal.classList.add('hidden');
    }

    window.addEventListener('click', function (e) {
        const modal = document.getElementById('deleteModal');
        if (e.target === modal) {
            closeDeleteModal();
        }
    });
</script>
@endpush