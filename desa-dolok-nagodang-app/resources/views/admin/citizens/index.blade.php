@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div class="text-sm text-slate-500">
            Aksi cepat data penduduk
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

            <a href="{{ route('admin.citizens.create') }}"
               class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-5 py-3 text-sm font-semibold text-white hover:bg-emerald-700 shadow-lg shadow-emerald-600/20 transition">
                <i data-lucide="plus" class="w-4 h-4"></i>
                Tambah Penduduk
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5">
        <div class="rounded-2xl bg-white border border-slate-200 p-5 shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Total Penduduk</p>
                    <h3 class="mt-3 text-3xl font-bold text-slate-800">{{ number_format((int) $allCitizens) }}</h3>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-emerald-100 flex items-center justify-center text-emerald-700">
                    <i data-lucide="users" class="w-6 h-6"></i>
                </div>
            </div>
            <p class="mt-4 text-sm text-slate-500">Total data penduduk tersimpan</p>
        </div>

        <div class="rounded-2xl bg-white border border-slate-200 p-5 shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Laki-laki</p>
                    <h3 class="mt-3 text-3xl font-bold text-slate-800">{{ number_format((int) $maleCitizens) }}</h3>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-sky-100 flex items-center justify-center text-sky-700">
                    <i data-lucide="user" class="w-6 h-6"></i>
                </div>
            </div>
            <p class="mt-4 text-sm text-slate-500">{{ number_format((float) $maleCitizenPercentage, 1) }}% dari total penduduk</p>
        </div>

        <div class="rounded-2xl bg-white border border-slate-200 p-5 shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Perempuan</p>
                    <h3 class="mt-3 text-3xl font-bold text-slate-800">{{ number_format((int) $femaleCitizens) }}</h3>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-pink-100 flex items-center justify-center text-pink-700">
                    <i data-lucide="user-round" class="w-6 h-6"></i>
                </div>
            </div>
            <p class="mt-4 text-sm text-slate-500">{{ number_format((float) $femaleCitizenPercentage, 1) }}% dari total penduduk</p>
        </div>

        <div class="rounded-2xl bg-white border border-slate-200 p-5 shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Data Aktif</p>
                    <h3 class="mt-3 text-3xl font-bold text-slate-800">{{ number_format((int) $activeCitizens) }}</h3>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-violet-100 flex items-center justify-center text-violet-700">
                    <i data-lucide="circle-check" class="w-6 h-6"></i>
                </div>
            </div>
            <p class="mt-4 text-sm text-slate-500">Belum termasuk data terhapus</p>
        </div>
    </div>

    @if ($dusunStats->isNotEmpty())
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            @foreach ($dusunStats as $dusun)
                <div class="rounded-2xl bg-white border border-slate-200 p-5 shadow-sm">
                    <p class="text-sm font-medium text-slate-500">
                        Total Penduduk {{ $dusun->dusun }}
                    </p>
                    <h3 class="mt-2 text-3xl font-bold text-slate-800">
                        {{ number_format((int) $dusun->total) }}
                    </h3>
                </div>
            @endforeach
        </div>
    @endif

    <div class="rounded-2xl bg-white border border-slate-200 shadow-sm p-5">
        <div class="flex items-center justify-between mb-5">
            <div>
                <h2 class="text-lg font-bold text-slate-800">Filter & Pencarian</h2>
                <p class="text-sm text-slate-500 mt-1">Gunakan filter untuk mempermudah pencarian data.</p>
            </div>
        </div>

        <form method="GET" action="{{ route('admin.citizens.index') }}" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-4">
            <div class="xl:col-span-2">
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Cari Penduduk
                </label>

                <input
                    type="text"
                    name="search"
                    value="{{ $filters['search'] ?? '' }}"
                    placeholder="Cari berdasarkan nama, NIK, atau alamat"
                    maxlength="100"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                >
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Jenis Kelamin</label>
                <select
                    name="gender"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                >
                    <option value="">Semua</option>
                    <option value="Laki-laki" {{ ($filters['gender'] ?? '') === 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan" {{ ($filters['gender'] ?? '') === 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Status Hidup
                </label>

                <select
                    name="life_status"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                >
                    <option value="">Semua</option>
                    <option value="alive" {{ ($filters['life_status'] ?? '') === 'alive' ? 'selected' : '' }}>Hidup</option>
                    <option value="deceased" {{ ($filters['life_status'] ?? '') === 'deceased' ? 'selected' : '' }}>Meninggal Dunia</option>
                </select>
            </div>

            <div class="flex items-end gap-3">
                <button type="submit" class="flex-1 rounded-xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white hover:bg-slate-800 transition">
                    Terapkan
                </button>
                <a href="{{ route('admin.citizens.index') }}"
                   class="rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <div class="rounded-2xl bg-white border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-200 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h2 class="text-lg font-bold text-slate-800">Daftar Penduduk</h2>
                <p class="text-sm text-slate-500 mt-1">Data penduduk desa yang tersedia di sistem.</p>
            </div>

            <div class="inline-flex items-center gap-2 rounded-xl bg-slate-100 px-3 py-2 text-sm text-slate-600">
                <span>Menampilkan</span>
                <span class="font-semibold text-slate-800">{{ $citizens->count() }}</span>
                <span>data</span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 text-slate-600">
                    <tr>
                        <th class="px-5 py-4 text-left font-semibold">No</th>
                        <th class="px-5 py-4 text-left font-semibold">NIK</th>
                        <th class="px-5 py-4 text-left font-semibold">Nama Lengkap</th>
                        <th class="px-5 py-4 text-left font-semibold">Jenis Kelamin</th>
                        <th class="px-5 py-4 text-left font-semibold">Telepon</th>
                        <th class="px-5 py-4 text-left font-semibold">Alamat</th>
                        <th class="px-5 py-4 text-left font-semibold">Status</th>
                        <th class="px-5 py-4 text-center font-semibold">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse ($citizens as $index => $citizen)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="px-5 py-4">
                                {{ ($citizens->firstItem() ?? 0) + $index }}
                            </td>
                            <td class="px-5 py-4 font-medium text-slate-700">
                                {{ $citizen->nik }}
                            </td>
                            <td class="px-5 py-4">
                                <p class="font-semibold text-slate-800">{{ $citizen->full_name }}</p>
                            </td>
                            <td class="px-5 py-4">{{ $citizen->gender }}</td>
                            <td class="px-5 py-4">{{ $citizen->phone ?? '-' }}</td>
                            <td class="px-5 py-4 max-w-xs truncate">{{ $citizen->address ?? '-' }}</td>
                            <td class="px-5 py-4">
                                @if ($citizen->life_status === 'alive')
                                    <span class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                                        Hidup
                                    </span>
                                @else
                                    <span class="inline-flex rounded-full bg-slate-200 px-3 py-1 text-xs font-semibold text-slate-700">
                                        Meninggal
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.citizens.edit', $citizen->id) }}"
                                       class="rounded-lg bg-sky-50 px-3 py-2 text-sky-700 font-medium hover:bg-sky-100 transition">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.citizens.destroy', $citizen->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="button"
                                            class="btn-delete rounded-lg bg-rose-50 px-3 py-2 text-rose-700 font-medium hover:bg-rose-100 transition"
                                            data-name="{{ $citizen->full_name }}">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-5 py-10 text-center text-slate-500">
                                Data penduduk belum tersedia.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-5 py-4 border-t border-slate-200 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <p class="text-sm text-slate-500">
                Menampilkan {{ $citizens->firstItem() ?? 0 }} sampai {{ $citizens->lastItem() ?? 0 }} dari {{ $citizens->total() }} data
            </p>

            <div>
                {{ $citizens->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    if (typeof Swal === 'undefined') {
        console.error('SweetAlert tidak ter-load!');
        return;
    }

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
            html: `<p class="text-sm text-slate-600">Data <b>${nama}</b> akan dihapus.</p>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            reverseButtons: true,
            focusCancel: true
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Menghapus...',
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
