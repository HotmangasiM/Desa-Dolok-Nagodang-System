@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div>
            <a href="{{ route('admin.news.index') }}"
               class="inline-flex items-center gap-2 text-sm font-medium text-slate-500 hover:text-slate-700 mb-3">
                ← Kembali ke Berita Desa
            </a>

            <h1 class="text-3xl font-bold tracking-tight text-slate-800">Edit Berita Desa</h1>
            <p class="text-sm text-slate-500 mt-2">
                Perbarui informasi berita yang sudah tersimpan di sistem.
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

    <form action="{{ route('admin.news.update', $news->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="rounded-2xl bg-white border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200">
                <h2 class="text-lg font-bold text-slate-800">Informasi Berita</h2>
                <p class="text-sm text-slate-500 mt-1">Perbarui informasi utama berita desa.</p>
            </div>

            <div class="p-6 grid grid-cols-1 xl:grid-cols-3 gap-5">
                <div class="xl:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Judul Berita <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="title"
                        value="{{ old('title', $news->title) }}"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                        placeholder="Masukkan judul berita"
                    >
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Status <span class="text-rose-500">*</span>
                    </label>
                    <select
                        name="status"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                    >
                        <option value="">Pilih Status</option>
                        <option value="draft" {{ old('status', $news->status) === 'draft' ? 'selected' : '' }}>draft</option>
                        <option value="published" {{ old('status', $news->status) === 'published' ? 'selected' : '' }}>published</option>
                    </select>
                </div>

                <div class="xl:col-span-3">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Thumbnail / Gambar</label>

                    <div class="mb-3">
                        @if($news->image)
                            <img
                                src="{{ asset('storage/' . $news->image) }}"
                                alt="{{ $news->title }}"
                                class="w-40 h-28 rounded-xl object-cover border border-slate-200 shadow-sm"
                            >
                            <p class="mt-2 text-xs text-slate-500">Thumbnail saat ini</p>
                        @else
                            <div class="w-40 h-28 rounded-xl bg-slate-100 text-slate-400 flex items-center justify-center text-sm border border-slate-200">
                                No Image
                            </div>
                        @endif
                    </div>

                    <input
                        type="file"
                        name="image"
                        accept="image/*"
                        onchange="previewNewsImage(event)"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                    >

                    <p class="text-xs text-slate-500 mt-2">
                        Kosongkan jika tidak ingin mengganti gambar. Format: JPG, PNG, JPEG max 2MB.
                    </p>

                    <img
                        id="newsImagePreview"
                        class="hidden mt-3 w-40 h-28 rounded-xl object-cover border border-slate-200 shadow-sm"
                    >
                </div>

                <div class="xl:col-span-3">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Diunggah</label>
                    <input
                        type="datetime-local"
                        name="published_at"
                        value="{{ old('published_at', $news->published_at ? $news->published_at->format('Y-m-d\TH:i') : '') }}"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                    >
                </div>

                <div class="xl:col-span-3">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Konten Berita <span class="text-rose-500">*</span>
                    </label>
                    <textarea
                        name="content"
                        rows="12"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm leading-6 focus:outline-none focus:ring-2 focus:ring-emerald-500"
                        placeholder="Tulis isi berita desa di sini..."
                    >{{ old('content', $news->content) }}</textarea>
                </div>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row items-center justify-end gap-3">
            <a href="{{ route('admin.news.index') }}"
               class="w-full sm:w-auto inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-5 py-3 text-sm font-medium text-slate-700 hover:bg-slate-50 transition">
                Batal
            </a>

            <button
                type="submit"
                class="w-full sm:w-auto inline-flex items-center justify-center rounded-xl bg-emerald-600 px-5 py-3 text-sm font-semibold text-white hover:bg-emerald-700 shadow-lg shadow-emerald-600/20 transition">
                Simpan Perubahan
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

    document.addEventListener('submit', function (e) {

        const form = e.target;

        // 🔥 target khusus form edit berita
        if (!form.action.includes('news')) return;

        // kalau sudah dikonfirmasi, lanjut submit
        if (form.dataset.confirmed === 'true') return;

        e.preventDefault();

        const judul = form.querySelector('input[name="title"]')?.value || 'berita ini';

        Swal.fire({
            title: 'Konfirmasi Perubahan',
            text: `Simpan perubahan untuk "${judul}"?`,
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