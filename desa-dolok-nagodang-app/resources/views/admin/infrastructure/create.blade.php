@extends('layouts.admin')

@section('content')
<div class="space-y-6">

    {{-- ERROR --}}
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

    <form action="{{ route('admin.infrastructure.store') }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf

        <div class="rounded-2xl bg-white border border-slate-200 shadow-sm overflow-hidden">

            {{-- HEADER --}}
            <div class="px-6 py-4 border-b border-slate-200">
                <h2 class="text-lg font-bold text-slate-800">
                    Informasi Infrastruktur
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Tambahkan data pembangunan atau fasilitas desa.
                </p>
            </div>

            {{-- FORM --}}
            <div class="p-6 grid grid-cols-1 xl:grid-cols-3 gap-5">

                {{-- TITLE --}}
                <div class="xl:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Judul Infrastruktur
                        <span class="text-rose-500">*</span>
                    </label>

                    <input
                        type="text"
                        name="title"
                        value="{{ old('title') }}"
                        placeholder="Contoh: Pembangunan Jalan Desa"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm
                               focus:outline-none focus:ring-2 focus:ring-emerald-500"
                    >
                </div>

                {{-- STATUS --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Status
                        <span class="text-rose-500">*</span>
                    </label>

                    <select
                        name="status"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm
                               focus:outline-none focus:ring-2 focus:ring-emerald-500"
                    >
                        <option value="">Pilih Status</option>

                        <option value="draft"
                            {{ old('status') == 'draft' ? 'selected' : '' }}>
                            Draf
                        </option>

                        <option value="publish"
                            {{ old('status') == 'publish' ? 'selected' : '' }}>
                            Dipublikasikan
                        </option>
                    </select>
                </div>

                {{-- IMAGE --}}
                <div class="xl:col-span-3">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Foto Infrastruktur
                    </label>

                    <input
                        type="file"
                        name="image"
                        id="imageInput"
                        accept="image/*"
                        onchange="previewImage(event)"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm
                               focus:outline-none focus:ring-2 focus:ring-emerald-500"
                    >

                    <p class="text-xs text-slate-500 mt-2">
                        Format: JPG, PNG, JPEG (max 2MB)
                    </p>

                    <div class="mt-4">
                        <img
                            id="imagePreview"
                            class="hidden w-48 h-32 object-cover rounded-xl border border-slate-200 shadow-sm"
                        >
                    </div>
                </div>

                {{-- CONTENT --}}
                <div class="xl:col-span-3">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Deskripsi Infrastruktur
                        <span class="text-rose-500">*</span>
                    </label>

                    <textarea
                        name="content"
                        rows="10"
                        placeholder="Tulis deskripsi pembangunan atau fasilitas desa..."
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm leading-6
                               focus:outline-none focus:ring-2 focus:ring-emerald-500"
                    >{{ old('content') }}</textarea>
                </div>

            </div>
        </div>

        {{-- BUTTON --}}
        <div class="flex flex-col sm:flex-row items-center justify-end gap-3">

            <a href="{{ route('admin.infrastructure.index') }}"
               class="w-full sm:w-auto inline-flex items-center justify-center
                      rounded-xl border border-slate-300 bg-white px-5 py-3
                      text-sm font-medium text-slate-700 hover:bg-slate-50 transition">
                Batal
            </a>

            <button
                type="submit"
                class="w-full sm:w-auto inline-flex items-center justify-center
                       rounded-xl bg-emerald-600 px-5 py-3 text-sm font-semibold
                       text-white hover:bg-emerald-700
                       shadow-lg shadow-emerald-600/20 transition">
                Simpan Infrastruktur
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

    if (!input.files || !input.files[0]) return;

    const reader = new FileReader();

    reader.onload = function(e) {
        preview.src = e.target.result;
        preview.classList.remove('hidden');
    };

    reader.readAsDataURL(input.files[0]);
}

document.addEventListener('DOMContentLoaded', function () {

    if (typeof Swal === 'undefined') return;

    document.addEventListener('submit', function (e) {

        const form = e.target;

        if (!form.action.includes('infrastructure')) return;

        if (form.dataset.confirmed === 'true') return;

        e.preventDefault();

        const title =
            form.querySelector('input[name="title"]')?.value ||
            'data infrastruktur';

        Swal.fire({
            title: 'Konfirmasi Simpan',
            text: `Apakah Anda yakin ingin menyimpan "${title}"?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Simpan',
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
<script>
document.getElementById('imageInput').addEventListener('change', function (e) {
    const file = e.target.files[0];

    if (file && file.size > 2 * 1024 * 1024) {

        Swal.fire({
            icon: 'error',
            title: 'File terlalu besar',
            text: 'Maksimal ukuran gambar adalah 2MB'
        });

        e.target.value = '';
        document.getElementById('imagePreview').classList.add('hidden');
    }
});
</script>
@endpush
