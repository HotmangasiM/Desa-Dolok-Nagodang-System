@extends('layouts.admin')
@section('content')
<div class="space-y-6">
    @php
        $hasActiveFilters = collect($filters ?? [])
            ->filter(function ($value) {
                return filled($value);
            })
            ->isNotEmpty();
    @endphp

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">
                Data Pembangunan Infrastruktur Desa
            </h1>

            <p class="text-sm text-slate-500 mt-1">
                Kelola seluruh data Infrastruktur Desa Dolok Nagodang.
            </p>
        </div>

        <a href="{{ route('admin.infrastructure.create') }}"
           class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-5 py-3 text-sm font-semibold text-white hover:bg-emerald-700 transition shadow-lg shadow-emerald-600/20">
            <i data-lucide="plus" class="w-4 h-4"></i>
            Tambah Data
        </a>
    </div>

    {{-- STATISTIK --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
            <p class="text-sm text-slate-500">Total Aset</p>

            <h2 class="text-3xl font-bold text-slate-800 mt-2">
                {{ number_format($allInfrastructure ?? $data->total()) }}
            </h2>
        </div>

        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
            <p class="text-sm text-slate-500">Dipublikasikan</p>

            <h2 class="text-3xl font-bold text-emerald-600 mt-2">
                {{ number_format($publishedInfrastructure ?? 0) }}
            </h2>
        </div>

        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
            <p class="text-sm text-slate-500">Draft</p>

            <h2 class="text-3xl font-bold text-amber-500 mt-2">
                {{ number_format($draftInfrastructure ?? 0) }}
            </h2>
        </div>

    </div>

    {{-- FILTER --}}
    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">

        <form method="GET"
              action="{{ route('admin.infrastructure.index') }}">

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-3">

                <input
                    type="text"
                    name="search"
                    value="{{ $filters['search'] ?? '' }}"
                    placeholder="Cari nama barang, kode barang atau jenis barang..."
                    class="rounded-xl border border-slate-300 px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none xl:col-span-2"
                >

                <select
                    name="status"
                    class="rounded-xl border border-slate-300 px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                >
                    <option value="">Semua Status</option>
                    <option value="publish" {{ ($filters['status'] ?? '') === 'publish' ? 'selected' : '' }}>Publish</option>
                    <option value="draft" {{ ($filters['status'] ?? '') === 'draft' ? 'selected' : '' }}>Draft</option>
                </select>

                <button
                    type="submit"
                    class="rounded-xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white hover:bg-slate-800">
                    Terapkan
                </button>

            </div>

            <div class="mt-3 flex justify-end">
                <a href="{{ route('admin.infrastructure.index') }}"
                   class="rounded-xl border border-slate-300 px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                    Reset
                </a>
            </div>

        </form>

    </div>

   {{-- TABLE --}}
<div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">

    <div class="overflow-x-auto">

        <table class="w-full text-sm">

            <thead class="bg-slate-50 border-b border-slate-200">

                <tr>

                    <th class="px-4 py-4 text-left font-semibold">No</th>
                    <th class="px-4 py-4 text-left font-semibold">Foto</th>
                    <th class="px-4 py-4 text-left font-semibold">Nama Barang</th>
                    <th class="px-4 py-4 text-left font-semibold">Jenis Barang</th>
                    <th class="px-4 py-4 text-left font-semibold">Jumlah/Luas</th>
                    <th class="px-4 py-4 text-left font-semibold">Nilai/Harga</th>
                    <th class="px-4 py-4 text-left font-semibold">Tahun</th>
                    <th class="px-4 py-4 text-center font-semibold">Kondisi</th>
                    <th class="px-4 py-4 text-left font-semibold">Keterangan</th>
                    <th class="px-4 py-4 text-left font-semibold">Status</th>
                    <th class="px-4 py-4 text-center font-semibold">Aksi</th>

                </tr>

            </thead>

            <tbody>

                @forelse($data as $index => $item)

                    <tr class="border-b border-slate-100 hover:bg-slate-50 transition">

                        <td class="px-4 py-5 align-middle">
                            {{ ($data->firstItem() ?? 0) + $index }}
                        </td>

                        <td class="px-4 py-5 align-middle">

                            @if($item->image)

                                <img
                                    src="{{ asset('storage/'.$item->image) }}"
                                    alt="{{ $item->nama_barang }}"
                                    class="w-24 h-16 rounded-xl object-cover border border-slate-200"
                                >

                            @else

                                <div class="w-24 h-16 rounded-xl bg-slate-100 flex items-center justify-center text-xs text-slate-400">
                                    Tidak Ada
                                </div>

                            @endif

                        </td>

                        <td class="px-4 py-5 align-middle font-semibold text-slate-800">
                            {{ $item->nama_barang }}
                        </td>

                        <td class="px-4 py-5 align-middle text-slate-700">
                            {{ $item->jenis_barang }}
                        </td>

                        <td class="px-4 py-5 align-middle">
                            {{ $item->jumlah_luas }}
                        </td>

                        <td class="px-4 py-5 align-middle">
                            Rp {{ number_format($item->nilai_harga ?? 0, 0, ',', '.') }}
                        </td>

                        <td class="px-4 py-5 align-middle">
                            {{ $item->tahun_pengadaan }}
                        </td>

                        {{-- KONDISI --}}
                        <td class="px-4 py-5 text-center align-middle">

                            @php
                                $badge = 'bg-slate-100 text-slate-700';

                                if ($item->kondisi === 'Baik') {
                                    $badge = 'bg-emerald-100 text-emerald-700';
                                } elseif ($item->kondisi === 'Rusak Ringan') {
                                    $badge = 'bg-amber-100 text-amber-700';
                                } elseif ($item->kondisi === 'Rusak Berat') {
                                    $badge = 'bg-rose-100 text-rose-700';
                                }
                            @endphp

                            <span
                                class="inline-flex
                                    items-center
                                    justify-center
                                    text-center
                                    px-4 py-1.5
                                    rounded-full
                                    text-xs font-semibold
                                    {{ $badge }}">
                                {{ $item->kondisi }}
                            </span>

                        </td>

                        {{-- KETERANGAN --}}
                        <td class="px-4 py-5 align-middle">

                            <span
                                class="inline-flex items-center
                                       rounded-full
                                       bg-slate-100
                                       px-3 py-1
                                       text-xs font-medium
                                       text-slate-700">
                                {{ $item->keterangan ?? '-' }}
                            </span>

                        </td>

                        {{-- STATUS --}}
                        <td class="px-4 py-5 align-middle">

                            @if($item->status === 'publish')

                                <span class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                                    Publish
                                </span>

                            @else

                                <span class="inline-flex rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">
                                    Draft
                                </span>

                            @endif

                        </td>

                        {{-- AKSI --}}
                        <td class="px-4 py-5 align-middle">

                            <div class="flex justify-center gap-2">

                                <a
                                    href="{{ route('admin.infrastructure.edit', $item->id) }}"
                                    class="rounded-lg bg-sky-100 px-4 py-2 text-xs font-medium text-sky-700 transition hover:bg-sky-200">
                                    Edit
                                </a>

                                <form
                                    action="{{ route('admin.infrastructure.destroy', $item->id) }}"
                                    method="POST"
                                    class="delete-form"
                                    data-delete-form>

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        data-name="{{ $item->nama_barang }}"
                                        class="btn-delete rounded-lg bg-rose-100 px-4 py-2 text-xs font-medium text-rose-700 transition hover:bg-rose-200">
                                        Hapus
                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="11" class="py-16 text-center text-slate-500">

                            {{ $hasActiveFilters
                                ? 'Tidak ada data infrastruktur yang cocok dengan filter pencarian.'
                                : 'Belum ada data infrastruktur desa.' }}

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    <div class="border-t border-slate-200 px-5 py-4">

        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">

            <p class="text-sm text-slate-500">
                Menampilkan {{ $data->firstItem() ?? 0 }}
                sampai {{ $data->lastItem() ?? 0 }}
                dari {{ $data->total() }} data
            </p>

            <div>
                {{ $data->links() }}
            </div>

        </div>

    </div>

</div>

</div>
@endsection
