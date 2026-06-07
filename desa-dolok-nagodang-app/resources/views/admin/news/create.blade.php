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

    <form method="POST" action="{{ route('admin.news.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="rounded-2xl bg-white border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200">
                <h2 class="text-lg font-bold text-slate-800">Informasi Berita</h2>
                <p class="text-sm text-slate-500 mt-1">Masukkan informasi utama berita desa.</p>
            </div>

            <div class="p-6 grid grid-cols-1 xl:grid-cols-3 gap-5">
                <div class="xl:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Judul Berita <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="title"
                        value="{{ old('title') }}"
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
                        <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>
                            Draf
                        </option>
                        <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>
                            Diunggah
                        </option>
                    </select>
                </div>

                <div class="xl:col-span-3">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Thumbnail / Gambar
                    </label>

                    <input
                        type="file"
                        name="image"
                        accept=".jpg,.jpeg,.png,image/jpeg,image/png"
                        onchange="previewImage(event)"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                    >

                    <p class="text-xs text-slate-500 mt-2">
                        Format: JPG, PNG, JPEG (max 2MB)
                    </p>

                    <div class="mt-4">
                        <img id="imagePreview"
                             class="hidden w-40 h-28 object-cover rounded-xl border border-slate-200 shadow-sm">
                    </div>
                </div>

                <div class="xl:col-span-3">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Diunggah</label>
                    <input
                        type="datetime-local"
                        name="published_at"
                        value="{{ old('published_at') }}"
                        min="{{ now()->startOfDay()->format('Y-m-d\TH:i') }}"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                    >
                </div>

                <div class="xl:col-span-3">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Konten Berita <span class="text-rose-500">*</span>
                    </label>
                    @include('admin.news.partials.rich-text-editor', [
                        'content' => old('content'),
                        'editorId' => 'newsContentCreateEditor',
                        'inputId' => 'newsContentCreateInput',
                    ])
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
                Simpan Berita
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
function previewImage(event) {
    const input = event.target;
    const preview = document.getElementById('imagePreview');

    if (!input.files || !input.files[0] || !preview) return;

    const allowedTypes = ['image/jpeg', 'image/png'];
    const file = input.files[0];

    if (!allowedTypes.includes(file.type)) {
        input.value = '';
        preview.classList.add('hidden');
        alert('Thumbnail hanya boleh menggunakan format JPG, JPEG, atau PNG.');
        return;
    }

    const reader = new FileReader();

    reader.onload = function (e) {
        preview.src = e.target.result;
        preview.classList.remove('hidden');
    };

    reader.readAsDataURL(file);
}

document.addEventListener('DOMContentLoaded', function () {

    if (typeof Swal === 'undefined') {
        console.error('SweetAlert tidak ter-load!');
        return;
    }

    document.addEventListener('submit', function (e) {
        const form = e.target;

        if (!form.action.includes('news')) return;

        if (form.dataset.confirmed === 'true') return;

        e.preventDefault();

        const judul = form.querySelector('input[name="title"]')?.value || 'berita ini';

        Swal.fire({
            title: 'Konfirmasi Tambah Berita',
            text: `Apakah Anda yakin ingin menyimpan "${judul}"?`,
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
