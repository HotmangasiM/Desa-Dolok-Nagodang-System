@extends('layouts.admin')

@section('content')

<div class="space-y-6">

    {{-- ERROR --}}
    @if ($errors->any())
        <div class="rounded-2xl border border-rose-200 bg-rose-50 px-5 py-4 text-sm text-rose-700">
            <div class="font-semibold mb-2">
                Terjadi kesalahan pada input:
            </div>

            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        action="{{ route('admin.infrastructure.update', $item->id) }}"
        method="POST"
        enctype="multipart/form-data"
        id="infrastructureForm"
        class="space-y-6">

        @csrf
        @method('PUT')

        {{-- CARD --}}
        <div class="rounded-2xl bg-white border border-slate-200 shadow-sm overflow-hidden">

            {{-- HEADER --}}
            <div class="px-6 py-4 border-b border-slate-200">
                <h2 class="text-lg font-bold text-slate-800">
                    Informasi Infrastruktur
                </h2>

                <p class="text-sm text-slate-500 mt-1">
                    Perbarui data pembangunan dan fasilitas desa.
                </p>
            </div>

            {{-- CONTENT --}}
            <div class="p-6 grid grid-cols-1 xl:grid-cols-3 gap-5">

                {{-- JUDUL --}}
                <div class="xl:col-span-2">

                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Judul Infrastruktur
                        <span class="text-rose-500">*</span>
                    </label>

                    <input
                        type="text"
                        name="title"
                        value="{{ old('title', $item->title) }}"
                        placeholder="Masukkan judul pembangunan"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
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
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">

                        <option value="">Pilih Status</option>

                        <option value="draft"
                            {{ old('status', $item->status) == 'draft' ? 'selected' : '' }}>
                            Draft
                        </option>

                        <option value="publish"
                            {{ old('status', $item->status) == 'publish' ? 'selected' : '' }}>
                            Publish
                        </option>

                    </select>

                </div>

                {{-- GAMBAR --}}
                <div class="xl:col-span-3">

                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Foto Infrastruktur
                    </label>

                    {{-- OLD IMAGE --}}
                    <div class="mb-3">

                        @if($item->image)

                            <img
                                src="{{ asset('storage/'.$item->image) }}"
                                alt="{{ $item->title }}"
                                class="w-48 h-32 rounded-xl object-cover border border-slate-200 shadow-sm"
                            >

                            <p class="mt-2 text-xs text-slate-500">
                                Foto saat ini
                            </p>

                        @else

                            <div class="w-48 h-32 rounded-xl bg-slate-100 flex items-center justify-center text-slate-400 border border-slate-200">
                                No Image
                            </div>

                        @endif

                    </div>

                    <input
                        type="file"
                        name="image"
                        id="imageInput"
                        accept="image/*"
                        onchange="previewInfrastructureImage(event)"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                    >

                    <p class="text-xs text-slate-500 mt-2">
                        Kosongkan jika tidak ingin mengganti gambar.
                        Format JPG, JPEG, PNG, WEBP maksimal 2MB.
                    </p>

                    {{-- PREVIEW --}}
                    <img
                        id="imagePreview"
                        class="hidden mt-4 w-48 h-32 rounded-xl object-cover border border-slate-200 shadow-sm"
                    >

                </div>

                {{-- KONTEN --}}
                <div class="xl:col-span-3">

                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Deskripsi Infrastruktur
                        <span class="text-rose-500">*</span>
                    </label>

                    <textarea
                        name="content"
                        rows="12"
                        placeholder="Tulis informasi pembangunan desa..."
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm leading-6 focus:outline-none focus:ring-2 focus:ring-emerald-500"
                    >{{ old('content', $item->content) }}</textarea>

                </div>

            </div>

        </div>

        {{-- ACTION --}}
        <div class="flex flex-col sm:flex-row items-center justify-end gap-3">

            <a href="{{ route('admin.infrastructure.index') }}"
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

function previewInfrastructureImage(event)
{
    const input = event.target;
    const preview = document.getElementById('imagePreview');

    if (!input.files.length) return;

    const reader = new FileReader();

    reader.onload = function(e)
    {
        preview.src = e.target.result;
        preview.classList.remove('hidden');
    };

    reader.readAsDataURL(input.files[0]);
}

document.addEventListener('DOMContentLoaded', function () {

    const form = document.getElementById('infrastructureForm');

    form.addEventListener('submit', function(e){

        if(form.dataset.confirmed === 'true'){
            return;
        }

        e.preventDefault();

        const title =
            document.querySelector('input[name="title"]').value ||
            'data infrastruktur';

        Swal.fire({
            title: 'Simpan Perubahan?',
            text: `Perbarui data "${title}" ?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#10b981',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Simpan',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {

            if(result.isConfirmed){

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