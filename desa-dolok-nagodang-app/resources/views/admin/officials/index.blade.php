@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div class="text-sm text-slate-500">
            Aksi cepat data aparat desa
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <button
                type="button"
                disabled
                aria-disabled="true"
                title="Fitur export sedang disiapkan"
                class="inline-flex cursor-not-allowed items-center gap-2 rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-medium text-slate-400 shadow-sm">
                <i data-lucide="download" class="w-4 h-4"></i>
                Export
            </button>

            <a href="{{ route('admin.officials.create') }}"
            class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-5 py-3 text-sm font-semibold text-white hover:bg-emerald-700 shadow-lg shadow-emerald-600/20 transition">
                <i data-lucide="plus" class="w-4 h-4"></i>
                Tambah Aparat Desa
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <div class="rounded-2xl bg-white border border-slate-200 p-5 shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Total Aparat</p>
                    <h3 class="mt-3 text-3xl font-bold text-slate-800">{{ number_format($allOfficials) }}</h3>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-emerald-100 flex items-center justify-center text-2xl">
                    🧑‍💼
                </div>
            </div>
            <p class="mt-4 text-sm text-slate-500">Total seluruh aparat desa</p>
        </div>

        <div class="rounded-2xl bg-white border border-slate-200 p-5 shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Memiliki Jabatan</p>
                    <h3 class="mt-3 text-3xl font-bold text-slate-800">{{ number_format($officialWithPosition) }}</h3>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-sky-100 flex items-center justify-center text-2xl">
                    🏷️
                </div>
            </div>
            <p class="mt-4 text-sm text-slate-500">Profil yang sudah memiliki jabatan</p>
        </div>

        <div class="rounded-2xl bg-white border border-slate-200 p-5 shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Memiliki Kontak</p>
                    <h3 class="mt-3 text-3xl font-bold text-slate-800">{{ number_format($officialWithPhone) }}</h3>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-violet-100 flex items-center justify-center text-2xl">
                    ☎️
                </div>
            </div>
            <p class="mt-4 text-sm text-slate-500">Profil dengan nomor telepon terisi</p>
        </div>
    </div>

    <div class="rounded-2xl bg-white border border-slate-200 shadow-sm p-5">
        <div class="flex items-center justify-between mb-5">
            <div>
                <h2 class="text-lg font-bold text-slate-800">Filter & Pencarian</h2>
                <p class="text-sm text-slate-500 mt-1">Gunakan filter untuk mempermudah pencarian aparat desa.</p>
            </div>
        </div>

        <form method="GET" action="{{ route('admin.officials.index') }}" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">

            <div class="xl:col-span-2">
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Cari Aparat
                </label>

                <input
                    type="text"
                    name="search"
                    value="{{ $filters['search'] ?? '' }}"
                    placeholder="Cari berdasarkan nama, jabatan, atau email"
                    maxlength="100"
                    oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Jabatan</label>
                <input
                    type="text"
                    name="position"
                    value="{{ $filters['position'] ?? '' }}"
                    placeholder="Contoh: Kepala Desa"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                >
            </div>

            <div class="flex items-end gap-3">
                <button class="flex-1 rounded-xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white hover:bg-slate-800 transition">
                    Terapkan
                </button>
                <a href="{{ route('admin.officials.index') }}"
                   class="rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <div class="rounded-2xl bg-white border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-200 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h2 class="text-lg font-bold text-slate-800">Daftar Aparat Desa</h2>
                <p class="text-sm text-slate-500 mt-1">Data aparat desa yang tersedia di sistem.</p>
            </div>

            <div class="inline-flex items-center gap-2 rounded-xl bg-slate-100 px-3 py-2 text-sm text-slate-600">
                <span>Menampilkan</span>
                <span class="font-semibold text-slate-800">{{ $officials->count() }}</span>
                <span>data</span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 text-slate-600">
                    <tr>
                        <th class="px-5 py-4 text-left font-semibold">No</th>
                        <th class="px-5 py-4 text-left font-semibold">Nama</th>
                        <th class="px-5 py-4 text-left font-semibold">Jabatan</th>
                        <th class="px-5 py-4 text-left font-semibold">No. Telepon</th>
                        <th class="px-5 py-4 text-left font-semibold">Email</th>
                        <th class="px-5 py-4 text-left font-semibold">Alamat</th>
                        <th class="px-5 py-4 text-center font-semibold">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse ($officials as $index => $official)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="px-5 py-4">
                                {{ ($officials->firstItem() ?? 0) + $index }}
                            </td>

                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold">
                                            {{ strtoupper(substr($official->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-semibold text-slate-800">{{ $official->name }}</p>
                                            <!-- <p class="text-xs text-slate-500 mt-1">
                                                {{ $official->photo ?? 'Tanpa foto' }}
                                            </p> -->
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-5 py-4 text-slate-600">
                                {{ $official->position ?? '-' }}
                            </td>

                            <td class="px-5 py-4 text-slate-600">
                                {{ $official->phone ?? '-' }}
                            </td>

                            <td class="px-5 py-4 text-slate-600">
                                {{ $official->email ?? '-' }}
                            </td>

                            <td class="px-5 py-4 text-slate-600">
                                <!-- @if ($official->term_start || $official->term_end)
                                    {{ $official->term_start ? $official->term_start->format('d M Y') : '-' }}
                                    s/d
                                    {{ $official->term_end ? $official->term_end->format('d M Y') : '-' }}
                                @else
                                    -
                                @endif -->
                                {{ $official->address ?? '-' }}
                            </td>

                            <td class="px-5 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.officials.edit', $official->id) }}"
                                       class="rounded-lg bg-sky-50 px-3 py-2 text-sky-700 font-medium hover:bg-sky-100 transition">
                                        Edit
                                    </a>

                        <form action="{{ route('admin.officials.destroy', $official->id) }}" method="POST">
                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="btn-delete rounded-lg bg-rose-50 px-3 py-2 text-rose-700 font-medium hover:bg-rose-100 transition"
                                data-name="{{ $official->name }}"
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
                                Data aparat desa belum tersedia.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-5 py-4 border-t border-slate-200 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <p class="text-sm text-slate-500">
                Menampilkan {{ $officials->firstItem() ?? 0 }} sampai {{ $officials->lastItem() ?? 0 }} dari {{ $officials->total() }} data
            </p>

            <div>
                {{ $officials->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    // Pastikan SweetAlert ada
    if (typeof Swal === 'undefined') {
        console.error('SweetAlert tidak ter-load!');
        return;
    }

    // Tangkap semua klik tombol delete
    document.addEventListener('click', function (e) {

        const button = e.target.closest('.btn-delete');

        if (!button) return;

        e.preventDefault();

        const form = button.closest('form');
        const nama = button.dataset.name || 'data ini';

        if (!form) {
            console.error('Form tidak ditemukan!');
            return;
        }

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
