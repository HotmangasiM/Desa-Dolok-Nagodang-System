@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div>
            <a href="{{ route('admin.officials.index') }}"
               class="inline-flex items-center gap-2 text-sm font-medium text-slate-500 hover:text-slate-700 mb-3">
                ← Kembali ke Aparat Desa
            </a>

            <h1 class="text-3xl font-bold tracking-tight text-slate-800">Edit Aparat Desa</h1>
            <p class="text-sm text-slate-500 mt-2">
                Perbarui informasi profil aparat desa yang sudah tersimpan.
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

    <form action="{{ route('admin.officials.update', $official->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="rounded-2xl bg-white border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200">
                <h2 class="text-lg font-bold text-slate-800">Informasi Aparat</h2>
                <p class="text-sm text-slate-500 mt-1">Perbarui informasi utama aparat desa.</p>
            </div>

            <div class="p-6 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Nama <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="name"
                        value="{{ old('name', $official->name) }}"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                        placeholder="Masukkan nama aparat"
                    >
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Jabatan <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="position"
                        value="{{ old('position', $official->position) }}"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                        placeholder="Contoh: Kepala Desa"
                    >
                </div>

                <div>
    <label class="block text-sm font-semibold text-slate-700 mb-2">Foto</label>

                <div class="mb-3">
                    @if($official->photo)
                        <img
                            src="{{ asset('storage/' . $official->photo) }}"
                            alt="{{ $official->name }}"
                            class="w-28 h-28 rounded-2xl object-cover border border-slate-200 shadow-sm"
                        >
                        <p class="mt-2 text-xs text-slate-500">
                            Foto saat ini
                        </p>
                    @else
                        <div class="w-28 h-28 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-3xl font-bold">
                            {{ strtoupper(substr($official->name, 0, 1)) }}
                        </div>
                        <p class="mt-2 text-xs text-slate-500">
                            Belum ada foto
                        </p>
                    @endif
                </div>

                <input
                    type="file"
                    name="photo"
                    accept="image/*"
                    onchange="previewOfficialPhoto(event)"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                >

                <p class="text-xs text-slate-500 mt-2">
                    Kosongkan jika tidak ingin mengganti foto. Format: JPG, PNG, JPEG max 2MB.
                </p>

                <img
                    id="officialPhotoPreview"
                    class="hidden mt-3 w-28 h-28 rounded-2xl object-cover border border-slate-200 shadow-sm"
                >
            </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">No. HP</label>
                    <input
                        type="text"
                        name="phone"
                        value="{{ old('phone', $official->phone) }}"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                        placeholder="Masukkan nomor telepon"
                    >
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email', $official->email) }}"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                        placeholder="Masukkan email"
                    >
                </div>

                <div class="md:col-span-2 xl:col-span-1">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Alamat</label>
                    <input
                        type="text"
                        name="address"
                        value="{{ old('address', $official->address) }}"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                        placeholder="Masukkan alamat"
                    >
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Mulai Masa Jabatan</label>
                    <input
                        type="date"
                        name="term_start"
                        value="{{ old('term_start', $official->term_start ? $official->term_start->format('Y-m-d') : '') }}"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                    >
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Selesai Masa Jabatan</label>
                    <input
                        type="date"
                        name="term_end"
                        value="{{ old('term_end', $official->term_end ? $official->term_end->format('Y-m-d') : '') }}"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                    >
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Urutan Tampil
                    </label>
                    <input
                        type="number"
                        name="sort_order"
                        value="{{ old('sort_order', $official->sort_order ?? 0) }}"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                        placeholder="Semakin kecil, tampil lebih atas"
                    >
                </div>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row items-center justify-end gap-3">
            <a href="{{ route('admin.officials.index') }}"
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    if (typeof Swal === 'undefined') {
        console.error('SweetAlert tidak ter-load!');
        return;
    }

    // ✅ TOAST SUCCESS (setelah update)
    @if(session('success'))
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 2500,
            timerProgressBar: true
        });
    @endif


    // ✅ CONFIRM EDIT
    document.addEventListener('submit', function (e) {

        const form = e.target;

        // target hanya form officials
        if (!form.action.includes('officials')) return;

        // cegah loop
        if (form.dataset.confirmed === 'true') return;

        e.preventDefault();

        // ambil nama aparat
        const nama = form.querySelector('input[name="name"]').value || 'data ini';

        Swal.fire({
            title: 'Simpan Perubahan?',
            html: `
                <p class="text-sm text-slate-600">
                    Perubahan untuk <b>${nama}</b> akan disimpan.
                </p>
            `,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, simpan',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#10b981',
            cancelButtonColor: '#6b7280',
            reverseButtons: true,
            focusCancel: true
        }).then((result) => {

            if (result.isConfirmed) {

                form.dataset.confirmed = 'true';

                Swal.fire({
                    title: 'Menyimpan...',
                    text: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
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