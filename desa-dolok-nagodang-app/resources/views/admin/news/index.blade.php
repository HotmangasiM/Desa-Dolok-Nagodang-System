@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    @php($hasActiveFilters = collect($filters ?? [])->filter(fn ($value) => filled($value))->isNotEmpty())

    {{-- HEADER --}}
    <div class="flex flex-wrap items-center justify-between gap-3">

        <div class="text-sm text-slate-500 flex items-center gap-2">
            <i data-lucide="newspaper" class="w-4 h-4"></i>
            Aksi cepat berita desa
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

            <a href="{{ route('admin.news.create') }}"
               class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-5 py-3 text-sm font-semibold text-white hover:bg-emerald-700 shadow-lg shadow-emerald-600/20 transition">

                <i data-lucide="plus-circle" class="w-4 h-4"></i>
                Tambah Berita
            </a>

        </div>

    </div>

    {{-- STATS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">

        <div class="rounded-2xl bg-white border border-slate-200 p-5 shadow-sm">
            <div class="flex items-start justify-between">

                <div>
                    <p class="text-sm font-medium text-slate-500">Total Berita</p>
                    <h3 class="mt-3 text-3xl font-bold text-slate-800">
                        {{ number_format($allNews) }}
                    </h3>
                </div>

                <div class="w-12 h-12 rounded-2xl bg-emerald-100 flex items-center justify-center">
                    <i data-lucide="file-text" class="w-6 h-6 text-emerald-600"></i>
                </div>

            </div>

            <p class="mt-4 text-sm text-slate-500">Total seluruh berita desa</p>
        </div>

        <div class="rounded-2xl bg-white border border-slate-200 p-5 shadow-sm">
            <div class="flex items-start justify-between">

                <div>
                    <p class="text-sm font-medium text-slate-500">Draf</p>
                    <h3 class="mt-3 text-3xl font-bold text-slate-800">
                        {{ number_format($draftNews) }}
                    </h3>
                </div>

                <div class="w-12 h-12 rounded-2xl bg-amber-100 flex items-center justify-center">
                    <i data-lucide="edit-3" class="w-6 h-6 text-amber-600"></i>
                </div>

            </div>

            <p class="mt-4 text-sm text-slate-500">Berita belum dipublikasikan</p>
        </div>

        <div class="rounded-2xl bg-white border border-slate-200 p-5 shadow-sm">
            <div class="flex items-start justify-between">

                <div>
                    <p class="text-sm font-medium text-slate-500">Dipublikasikan</p>
                    <h3 class="mt-3 text-3xl font-bold text-slate-800">
                        {{ number_format($publishedNews) }}
                    </h3>
                </div>

                <div class="w-12 h-12 rounded-2xl bg-sky-100 flex items-center justify-center">
                    <i data-lucide="send" class="w-6 h-6 text-sky-600"></i>
                </div>

            </div>

            <p class="mt-4 text-sm text-slate-500">Berita yang sudah tayang</p>
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
                Gunakan filter untuk mempermudah pencarian berita.
            </p>
        </div>

        <form method="GET" action="{{ route('admin.news.index') }}"
              class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">

            <div class="xl:col-span-2">
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Cari Berita
                </label>

                <input
                    type="text"
                    name="search"
                    value="{{ $filters['search'] ?? '' }}"
                    placeholder="Judul atau slug berita"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Status
                </label>

                <select name="status"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">

                    <option value="">Semua</option>
                    <option value="draft" {{ ($filters['status'] ?? '') === 'draft' ? 'selected' : '' }}>
                        Draf
                    </option>
                    <option value="published" {{ ($filters['status'] ?? '') === 'published' ? 'selected' : '' }}>
                        Dipublikasikan
                    </option>

                </select>
            </div>

            <div class="flex items-end gap-3">

                <button class="flex-1 rounded-xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white hover:bg-slate-800 transition">
                    Terapkan
                </button>

                <a href="{{ route('admin.news.index') }}"
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
                    Daftar Berita
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Data berita desa yang tersedia di sistem.
                </p>
            </div>

            <div class="inline-flex items-center gap-2 rounded-xl bg-slate-100 px-3 py-2 text-sm text-slate-600">
                <i data-lucide="database" class="w-4 h-4"></i>
                <span class="font-semibold text-slate-800">{{ $news->count() }}</span>
                data
            </div>

        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">

                <thead class="bg-slate-50 text-slate-600">
                    <tr>
                        <th class="px-5 py-4 text-left font-semibold">No</th>
                        <th class="px-5 py-4 text-left font-semibold">Thumbnail</th>
                        <th class="px-5 py-4 text-left font-semibold">Judul</th>
                        <th class="px-5 py-4 text-left font-semibold">Slug</th>
                        <th class="px-5 py-4 text-left font-semibold">Status</th>
                        <th class="px-5 py-4 text-left font-semibold">Tanggal</th>
                        <th class="px-5 py-4 text-center font-semibold">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">

                @forelse ($news as $index => $item)
                    <tr class="hover:bg-slate-50 transition">

                        <td class="px-5 py-4">
                            {{ ($news->firstItem() ?? 0) + $index }}
                        </td>

                        <td class="px-5 py-4">
                            @if($item->image)
                                <img src="{{ asset('storage/' . $item->image) }}"
                                     class="w-20 h-12 object-cover rounded-lg border">
                            @else
                            <span class="text-slate-400 text-xs">Tidak Ada Gambar</span>
                            @endif
                        </td>

                        <td class="px-5 py-4">
                            <p class="font-semibold text-slate-800">{{ $item->title }}</p>
                            <p class="text-xs text-slate-500">
                                {{ \Illuminate\Support\Str::limit(strip_tags($item->content), 80) }}
                            </p>
                        </td>

                        <td class="px-5 py-4 text-slate-600">
                            {{ $item->slug }}
                        </td>

                        <td class="px-5 py-4">
                            @if($item->status === 'published')
                                <span class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                                    Dipublikasikan
                                </span>
                            @else
                                <span class="inline-flex rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">
                                    Draft
                                </span>
                            @endif
                        </td>

                        <td class="px-5 py-4 text-slate-600">
                            {{ $item->published_at ? $item->published_at->format('d M Y H:i') : '-' }}
                        </td>

                        <td class="px-5 py-4">
                            <div class="flex items-center justify-center gap-2">

                                <a href="{{ route('admin.news.edit', $item->id) }}"
                                   class="inline-flex items-center gap-1 rounded-lg bg-sky-50 px-3 py-2 text-sky-700 font-medium hover:bg-sky-100 transition text-xs">

                                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                                    Edit
                                </a>

                                <form action="{{ route('admin.news.destroy', $item->id) }}" method="POST" data-delete-form>
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        class="btn-delete inline-flex items-center gap-1 rounded-lg bg-rose-50 px-3 py-2 text-rose-700 font-medium hover:bg-rose-100 transition text-xs"
                                        data-name="{{ $item->title }}">

                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        Hapus
                                    </button>

                                </form>

                            </div>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-5 py-8 text-center text-slate-500">
                            {{ $hasActiveFilters ? 'Tidak ada data berita yang cocok dengan filter pencarian.' : 'Data berita belum tersedia.' }}
                        </td>
                    </tr>
                @endforelse

                </tbody>

            </table>
        </div>

        {{-- PAGINATION --}}
        <div class="px-5 py-4 border-t border-slate-200 flex flex-col md:flex-row md:items-center md:justify-between gap-3">

            <p class="text-sm text-slate-500">
                Menampilkan {{ $news->firstItem() ?? 0 }}
                sampai {{ $news->lastItem() ?? 0 }}
                dari {{ $news->total() }} data
            </p>

            <div>
                {{ $news->withQueryString()->links() }}
            </div>

        </div>

    </div>

</div>
@endsection
