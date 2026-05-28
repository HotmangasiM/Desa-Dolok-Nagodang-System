@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div>
            <a href="{{ route('admin.officials.index') }}"
               class="inline-flex items-center gap-2 text-sm font-medium text-slate-500 hover:text-slate-700 mb-3">
                ← Kembali ke Aparat Desa
            </a>

            <h1 class="text-3xl font-bold tracking-tight text-slate-800">Tambah Aparat Desa</h1>
            <p class="text-sm text-slate-500 mt-2">
                Lengkapi form berikut untuk menambahkan profil aparat desa baru.
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

    <form action="{{ route('admin.officials.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="rounded-2xl bg-white border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200">
                <h2 class="text-lg font-bold text-slate-800">Informasi Aparat</h2>
                <p class="text-sm text-slate-500 mt-1">Masukkan informasi utama aparat desa.</p>
            </div>

            <div class="p-6 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Nama <span class="text-rose-500">*</span>
                    </label>

                    <input
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        maxlength="100"
                        oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')"
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
                        value="{{ old('position') }}"
                        maxlength="100"
                        oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                        placeholder="Contoh: Kepala Desa"
                    >
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Foto</label>

                    <input
                        type="file"
                        name="photo"
                        accept="image/*"
                        onchange="previewImage(event)"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                    >

                    <img id="photoPreview" class="mt-3 w-32 h-32 object-cover rounded-xl hidden" />
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        No. HP
                    </label>

                    <input
                        type="text"
                        name="phone"
                        value="{{ old('phone') }}"
                        maxlength="15"
                        inputmode="numeric"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                        placeholder="Masukkan nomor telepon"
                    >
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                        placeholder="Masukkan email"
                    >
                </div>

                <div class="md:col-span-2 xl:col-span-1">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Alamat
                    </label>

                    <input
                        type="text"
                        name="address"
                        value="{{ old('address') }}"
                        maxlength="255"
                        oninput="this.value = this.value.replace(/[^a-zA-Z0-9\s.,\/-]/g, '')"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                        placeholder="Masukkan alamat"
                    >
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Mulai Masa Jabatan</label>
                    <input
                        type="date"
                        name="term_start"
                        value="{{ old('term_start') }}"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                    >
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Selesai Masa Jabatan</label>
                    <input
                        type="date"
                        name="term_end"
                        value="{{ old('term_end') }}"
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
                        min="0"
                        step="1"
                        onkeydown="return false;"
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
                Simpan Aparat
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

    // ✅ TOAST SUCCESS (setelah redirect dari controller)
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


    // ✅ CONFIRM SUBMIT CREATE (APARAT)
    document.addEventListener('submit', function (e) {

        const form = e.target;

        // hanya target form officials
        if (!form.action.includes('officials')) return;

        // cegah submit awal
        if (form.dataset.confirmed === 'true') return;

        e.preventDefault();

        Swal.fire({
            title: 'Simpan Data?',
            html: `
                <p class="text-sm text-slate-600">
                    Pastikan data aparat sudah benar sebelum disimpan.
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