@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    @php($hasActiveFilters = collect($filters ?? [])->filter(fn ($value) => filled($value))->isNotEmpty())

    {{-- HEADER --}}
    <div class="flex flex-wrap items-center justify-between gap-3">

        <div class="text-sm text-slate-500 flex items-center gap-2">
            <i data-lucide="archive" class="w-4 h-4"></i>
            Aksi cepat inventaris desa
        </div>

        <div class="flex flex-wrap items-center gap-3">

            <button
                type="button"
                disabled
                aria-disabled="true"
                title="Fitur export sedang disiapkan"
                class="inline-flex cursor-not-allowed items-center gap-2 rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-medium text-slate-400 shadow-sm">

                <i data-lucide="file-down" class="w-4 h-4"></i>
                Export
            </button>

            <a href="{{ route('admin.assets.create') }}"
               class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-5 py-3 text-sm font-semibold text-white hover:bg-emerald-700 shadow-lg shadow-emerald-600/20 transition">

                <i data-lucide="plus-circle" class="w-4 h-4"></i>
                Tambah Inventaris
            </a>

        </div>

    </div>

    {{-- STATS --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

        <div class="rounded-2xl bg-white border border-slate-200 p-5 shadow-sm">
            <div class="flex items-start justify-between">

                <div>
                    <p class="text-sm font-medium text-slate-500">Total Inventaris</p>
                    <h3 class="mt-3 text-3xl font-bold text-slate-800">
                        {{ number_format($allAssets) }}
                    </h3>
                </div>

                <div class="w-12 h-12 rounded-2xl bg-emerald-100 flex items-center justify-center">
                    <i data-lucide="building-2" class="w-6 h-6 text-emerald-600"></i>
                </div>

            </div>

            <p class="mt-4 text-sm text-slate-500">Total seluruh aset desa</p>
        </div>

        <div class="rounded-2xl bg-white border border-slate-200 p-5 shadow-sm">
            <div class="flex items-start justify-between">

                <div>
                    <p class="text-sm font-medium text-slate-500">Kondisi Baik</p>
                    <h3 class="mt-3 text-3xl font-bold text-slate-800">
                        {{ number_format($goodAssets) }}
                    </h3>
                </div>

                <div class="w-12 h-12 rounded-2xl bg-sky-100 flex items-center justify-center">
                    <i data-lucide="check-circle" class="w-6 h-6 text-sky-600"></i>
                </div>

            </div>

            <p class="mt-4 text-sm text-slate-500">Aset dalam kondisi baik</p>
        </div>

        <div class="rounded-2xl bg-white border border-slate-200 p-5 shadow-sm">
            <div class="flex items-start justify-between">

                <div>
                    <p class="text-sm font-medium text-slate-500">Kondisi Rusak</p>
                    <h3 class="mt-3 text-3xl font-bold text-slate-800">
                        {{ number_format($damagedAssets) }}
                    </h3>
                </div>

                <div class="w-12 h-12 rounded-2xl bg-rose-100 flex items-center justify-center">
                    <i data-lucide="alert-triangle" class="w-6 h-6 text-rose-600"></i>
                </div>

            </div>

            <p class="mt-4 text-sm text-slate-500">Aset yang perlu perbaikan</p>
        </div>

    </div>

    {{-- FILTER --}}
    <div class="rounded-2xl bg-white border border-slate-200 shadow-sm p-5">

        <div class="mb-5">
            <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                <i data-lucide="filter" class="w-5 h-5"></i>
                Filter & Pencarian
            </h2>
            <p class="text-sm text-slate-500 mt-1">
                Gunakan filter untuk mempermudah pencarian inventaris.
            </p>
        </div>

        <form method="GET" action="{{ route('admin.assets.index') }}"
              class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-4">

            <div class="xl:col-span-2">
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Cari Inventaris
                </label>

                <input
                    type="text"
                    name="search"
                    value="{{ $filters['search'] ?? '' }}"
                    placeholder="Nama barang, kode, kategori"
                    maxlength="100"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Kategori
                </label>

                <input
                    type="text"
                    name="category"
                    value="{{ $filters['category'] ?? '' }}"
                    placeholder="Contoh: Elektronik"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Kondisi
                </label>

                <select name="condition"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">

                    <option value="">Semua</option>
                    <option value="good" {{ ($filters['condition'] ?? '') === 'good' ? 'selected' : '' }}>
                        Baik
                    </option>
                    <option value="damaged" {{ ($filters['condition'] ?? '') === 'damaged' ? 'selected' : '' }}>
                        Rusak
                    </option>

                </select>

            </div>

            <div class="flex items-end gap-3">

                <button class="flex-1 rounded-xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white hover:bg-slate-800 transition">
                    Terapkan
                </button>

                <a href="{{ route('admin.assets.index') }}"
                   class="rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">
                    Reset
                </a>

            </div>

        </form>

    </div>

    {{-- TABLE --}}
    <div class="rounded-2xl bg-white border border-slate-200 shadow-sm overflow-hidden">

        <div class="px-5 py-4 border-b border-slate-200 flex flex-col md:flex-row md:items-center md:justify-between gap-3">

            <div>
                <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                    <i data-lucide="table" class="w-5 h-5"></i>
                    Daftar Inventaris
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Data aset desa yang tersedia di sistem.
                </p>
            </div>

            <div class="inline-flex items-center gap-2 rounded-xl bg-slate-100 px-3 py-2 text-sm text-slate-600">
                <i data-lucide="database" class="w-4 h-4"></i>
                <span class="font-semibold text-slate-800">{{ $assets->count() }}</span>
                data
            </div>

        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">

                <thead class="bg-slate-50 text-slate-600">
                    <tr>
                        <th class="px-5 py-4 text-left font-semibold">No</th>
                        <th class="px-5 py-4 text-left font-semibold">Foto</th>
                        <th class="px-5 py-4 text-left font-semibold">Kode</th>
                        <th class="px-5 py-4 text-left font-semibold">Nama</th>
                        <th class="px-5 py-4 text-left font-semibold">Kategori</th>
                        <th class="px-5 py-4 text-left font-semibold">Jumlah</th>
                        <th class="px-5 py-4 text-left font-semibold">Kondisi</th>
                        <th class="px-5 py-4 text-left font-semibold">Lokasi</th>
                        <th class="px-5 py-4 text-center font-semibold">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">

                @forelse ($assets as $index => $asset)
                    <tr class="hover:bg-slate-50 transition">

                        <td class="px-5 py-4">
                            {{ ($assets->firstItem() ?? 0) + $index }}
                        </td>

                        <td class="px-5 py-4">
                            @if($asset->asset_photo)
                                <img src="{{ asset('storage/' . $asset->asset_photo) }}"
                                     class="w-16 h-12 object-cover rounded-lg border">
                            @else
                                <span class="text-slate-400 text-xs">Tidak Ada Gambar</span>
                            @endif
                        </td>

                        <td class="px-5 py-4 font-medium text-slate-700">
                            {{ $asset->item_code }}
                        </td>

                        <td class="px-5 py-4">
                            <p class="font-semibold text-slate-800">{{ $asset->item_name }}</p>
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
                            @elseif ($asset->condition === 'damaged')
                                <span class="inline-flex rounded-full bg-rose-100 px-3 py-1 text-xs font-semibold text-rose-700">
                                    Rusak
                                </span>
                            @else
                                <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">
                                    -
                                </span>
                            @endif
                        </td>

                        <td class="px-5 py-4 text-slate-600">
                            {{ $asset->location ?? '-' }}
                        </td>

                        <td class="px-5 py-4">
                            <div class="flex items-center justify-center gap-2">

                                <a href="{{ route('admin.assets.edit', $asset->id) }}"
                                   class="inline-flex items-center gap-1 rounded-lg bg-sky-50 px-3 py-2 text-sky-700 font-medium hover:bg-sky-100 transition text-xs">

                                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                                    Edit
                                </a>

                                <form action="{{ route('admin.assets.destroy', $asset->id) }}" method="POST" data-delete-form>
                                    @csrf
                                    @method('DELETE')

                                    <button type="button"
                                        class="btn-delete inline-flex items-center gap-1 rounded-lg bg-rose-50 px-3 py-2 text-rose-700 font-medium hover:bg-rose-100 transition text-xs"
                                        data-name="{{ $asset->item_name }}">

                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        Hapus
                                    </button>

                                </form>

                            </div>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="px-5 py-8 text-center text-slate-500">
                            {{ $hasActiveFilters ? 'Tidak ada data inventaris yang cocok dengan filter pencarian.' : 'Data inventaris belum tersedia.' }}
                        </td>
                    </tr>
                @endforelse

                </tbody>

            </table>
        </div>

        {{-- PAGINATION --}}
        <div class="px-5 py-4 border-t border-slate-200 flex flex-col md:flex-row md:items-center md:justify-between gap-3">

            <p class="text-sm text-slate-500">
                Menampilkan {{ $assets->firstItem() ?? 0 }}
                sampai {{ $assets->lastItem() ?? 0 }}
                dari {{ $assets->total() }} data
            </p>

            <div>
                {{ $assets->withQueryString()->links() }}
            </div>

        </div>

    </div>

</div>
@endsection
