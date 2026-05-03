@extends('layouts.admin')

@section('content')
@if (session('success'))
    <div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
        {{ session('success') }}
    </div>
@endif

<div class="space-y-6">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div class="text-sm text-slate-500">
            Aksi cepat berita desa
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <button
                type="button"
                class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-medium text-slate-700 hover:bg-slate-50 shadow-sm transition">
                ⬇ Export
            </button>

            <a href="{{ route('admin.news.create') }}"
            class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-5 py-3 text-sm font-semibold text-white hover:bg-emerald-700 shadow-lg shadow-emerald-600/20 transition">
                ＋ Tambah Berita
            </a>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
        <div class="rounded-2xl bg-white border border-slate-200 p-5 shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Total Berita</p>
                    <h3 class="mt-3 text-3xl font-bold text-slate-800">{{ number_format($allNews) }}</h3>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-emerald-100 flex items-center justify-center text-2xl">
                    📰
                </div>
            </div>
            <p class="mt-4 text-sm text-slate-500">Total seluruh berita desa</p>
        </div>

        <div class="rounded-2xl bg-white border border-slate-200 p-5 shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Draft</p>
                    <h3 class="mt-3 text-3xl font-bold text-slate-800">{{ number_format($draftNews) }}</h3>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-amber-100 flex items-center justify-center text-2xl">
                    ✍️
                </div>
            </div>
            <p class="mt-4 text-sm text-slate-500">Berita yang belum dipublikasikan</p>
        </div>

        <div class="rounded-2xl bg-white border border-slate-200 p-5 shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Published</p>
                    <h3 class="mt-3 text-3xl font-bold text-slate-800">{{ number_format($publishedNews) }}</h3>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-sky-100 flex items-center justify-center text-2xl">
                    🚀
                </div>
            </div>
            <p class="mt-4 text-sm text-slate-500">Berita yang sudah tayang</p>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="rounded-2xl bg-white border border-slate-200 shadow-sm p-5">
        <div class="flex items-center justify-between mb-5">
            <div>
                <h2 class="text-lg font-bold text-slate-800">Filter & Pencarian</h2>
                <p class="text-sm text-slate-500 mt-1">Gunakan filter untuk mempermudah pencarian berita.</p>
            </div>
        </div>

        <form method="GET" action="{{ route('admin.news.index') }}" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
            <div class="xl:col-span-2">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Cari Berita</label>
                <input
                    type="text"
                    name="search"
                    value="{{ $filters['search'] ?? '' }}"
                    placeholder="Cari berdasarkan judul atau slug"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                >
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Status</label>
                <select
                    name="status"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                >
                    <option value="">Semua</option>
                    <option value="draft" {{ ($filters['status'] ?? '') === 'draft' ? 'selected' : '' }}>draft</option>
                    <option value="published" {{ ($filters['status'] ?? '') === 'published' ? 'selected' : '' }}>published</option>
                </select>
            </div>

            <div class="flex items-end gap-3">
                <button class="w-full rounded-xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white hover:bg-slate-800 transition">
                    Terapkan
                </button>
            </div>
        </form>
    </div>

    <!-- Table Card -->
    <div class="rounded-2xl bg-white border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-200 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h2 class="text-lg font-bold text-slate-800">Daftar Berita</h2>
                <p class="text-sm text-slate-500 mt-1">Data berita desa yang tersedia di sistem.</p>
            </div>

            <div class="inline-flex items-center gap-2 rounded-xl bg-slate-100 px-3 py-2 text-sm text-slate-600">
                <span>Menampilkan</span>
                <span class="font-semibold text-slate-800">{{ $news->count() }}</span>
                <span>data</span>
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
                        <th class="px-5 py-4 text-left font-semibold">Published At</th>
                        <th class="px-5 py-4 text-center font-semibold">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse ($news as $index => $item)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="px-5 py-4">
                                {{ ($news->firstItem() ?? 0) + $index }}
                            </td>

                            <td class="px-5 py-4">
                                @if($item->image)
                                    <img src="{{ asset('storage/' . $item->image) }}"
                                        alt="{{ $item->title }}"
                                        class="w-20 h-12 object-cover rounded-lg border border-slate-200 shadow-sm">
                                @else
                                    <span class="text-slate-400 text-xs">No Image</span>
                                @endif
                            </td>

                            <td class="px-5 py-4">
                                <div>
                                    <p class="font-semibold text-slate-800">{{ $item->title }}</p>
                                    <p class="text-xs text-slate-500 mt-1">
                                        {{ \Illuminate\Support\Str::limit(strip_tags($item->content), 80) }}
                                    </p>
                                </div>
                            </td>

                            <td class="px-5 py-4 font-medium text-slate-700">
                                {{ $item->slug }}
                            </td>

                            <td class="px-5 py-4">
                                @if ($item->status === 'published')
                                    <span class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                                        published
                                    </span>
                                @else
                                    <span class="inline-flex rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">
                                        draft
                                    </span>
                                @endif
                            </td>

                            <td class="px-5 py-4 text-slate-600">
                                {{ $item->published_at ? $item->published_at->format('d M Y H:i') : '-' }}
                            </td>

                            <td class="px-5 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.news.edit', $item->id) }}"
                                       class="rounded-lg bg-sky-50 px-3 py-2 text-sky-700 font-medium hover:bg-sky-100 transition">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.news.destroy', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn-delete rounded-lg bg-rose-50 px-3 py-2 text-rose-700 font-medium hover:bg-rose-100 transition"
                                            data-name="{{ $item->title }}"
                                        >
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-8 text-center text-slate-500">
                                Data berita belum tersedia.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-5 py-4 border-t border-slate-200 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <p class="text-sm text-slate-500">
                Showing {{ $news->firstItem() ?? 0 }} to {{ $news->lastItem() ?? 0 }} of {{ $news->total() }} entries
            </p>

            <div>
                {{ $news->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div id="deleteModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/50 px-4">
    <div class="w-full max-w-md rounded-2xl bg-white shadow-2xl">
        <div class="p-6 border-b border-slate-200">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-full bg-rose-100 flex items-center justify-center text-2xl">
                    ⚠️
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-800">Konfirmasi Hapus</h3>
                    <p class="text-sm text-slate-500">Tindakan ini akan melakukan soft delete data berita.</p>
                </div>
            </div>
        </div>

        <div class="p-6">
            <p class="text-sm text-slate-600 leading-6">
                Apakah kamu yakin ingin menghapus berita
                <span id="newsTitle" class="font-semibold text-slate-800"></span>?
            </p>
        </div>

        <form id="deleteNewsForm" method="POST" action="">
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
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    if (typeof Swal === 'undefined') {
        console.error('SweetAlert tidak ter-load!');
        return;
    }

    document.addEventListener('click', function (e) {

        const button = e.target.closest('.btn-delete');
        if (!button) return;

        e.preventDefault();

        const form = button.closest('form');
        const nama = button.dataset.name || 'data ini';

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