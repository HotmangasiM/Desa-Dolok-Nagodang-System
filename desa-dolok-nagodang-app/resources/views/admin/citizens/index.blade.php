@extends('layouts.admin')

@section('content')
@if (session('success'))
    <div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
        {{ session('success') }}
    </div>
@endif
<div class="space-y-6">
    <!-- Header actions -->
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div class="text-sm text-slate-500">
                Aksi cepat data penduduk
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <button
                    type="button"
                    class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-medium text-slate-700 hover:bg-slate-50 shadow-sm transition">
                    ⬇ Export
                </button>

                <a href="{{ route('admin.citizens.create') }}"
                class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-5 py-3 text-sm font-semibold text-white hover:bg-emerald-700 shadow-lg shadow-emerald-600/20 transition">
                    ＋ Tambah Penduduk
                </a>
            </div>
        </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5">
        <div class="rounded-2xl bg-white border border-slate-200 p-5 shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Total Penduduk</p>
                    <h3 class="mt-3 text-3xl font-bold text-slate-800">{{ number_format((int) $allCitizens) }}</h3>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-emerald-100 flex items-center justify-center text-2xl">
                    👥
                </div>
            </div>
            <p class="mt-4 text-sm text-emerald-600 font-medium">+12 bulan ini</p>
        </div>

        <div class="rounded-2xl bg-white border border-slate-200 p-5 shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Laki-laki</p>
                    <h3 class="mt-3 text-3xl font-bold text-slate-800">{{ number_format((int) $maleCitizens) }}</h3>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-sky-100 flex items-center justify-center text-2xl">
                    👨
                </div>
            </div>
            <p class="mt-4 text-sm text-slate-500">49.8% dari total penduduk</p>
        </div>

        <div class="rounded-2xl bg-white border border-slate-200 p-5 shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Perempuan</p>
                    <h3 class="mt-3 text-3xl font-bold text-slate-800">{{ number_format((int) $femaleCitizens) }}</h3>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-pink-100 flex items-center justify-center text-2xl">
                    👩
                </div>
            </div>
            <p class="mt-4 text-sm text-slate-500">50.2% dari total penduduk</p>
        </div>

        <div class="rounded-2xl bg-white border border-slate-200 p-5 shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Data Aktif</p>
                    <h3 class="mt-3 text-3xl font-bold text-slate-800">{{ number_format((int) $activeCitizens) }}</h3>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-violet-100 flex items-center justify-center text-2xl">
                    ✅
                </div>
            </div>
            <p class="mt-4 text-sm text-slate-500">Belum termasuk data terhapus</p>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="rounded-2xl bg-white border border-slate-200 shadow-sm p-5">
        <div class="flex items-center justify-between mb-5">
            <div>
                <h2 class="text-lg font-bold text-slate-800">Filter & Pencarian</h2>
                <p class="text-sm text-slate-500 mt-1">Gunakan filter untuk mempermudah pencarian data.</p>
            </div>
        </div>
            <form method="GET" action="{{ route('admin.citizens.index') }}" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-4">
                <div class="xl:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Cari Penduduk</label>
                    <input
                        type="text"
                        name="search"
                        value="{{ $filters['search'] ?? '' }}"
                        placeholder="Cari berdasarkan nama atau NIK"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                    >
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Jenis Kelamin</label>
                    <select name="gender" class="...">
                        <option value="">Semua</option>
                        <option value="Laki-laki" {{ ($filters['gender'] ?? '') === 'Laki-laki' ? 'selected' : '' }}>
                            Laki-laki
                        </option>
                        <option value="Perempuan" {{ ($filters['gender'] ?? '') === 'Perempuan' ? 'selected' : '' }}>
                            Perempuan
                        </option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Status Hidup</label>
                    <select
                        name="life_status"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                    >
                        <option value="">Semua</option>
                        <option value="alive" {{ ($filters['life_status'] ?? '') === 'alive' ? 'selected' : '' }}>alive</option>
                        <option value="deceased" {{ ($filters['life_status'] ?? '') === 'deceased' ? 'selected' : '' }}>deceased</option>
                    </select>
                </div>

                <div class="flex items-end gap-3">
                    <button type="submit" class="w-full rounded-xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white hover:bg-slate-800 transition">
                        Terapkan
                    </button>
                </div>
            </form>
    </div>

    <!-- Table Card -->
    <div class="rounded-2xl bg-white border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-200 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h2 class="text-lg font-bold text-slate-800">Daftar Penduduk</h2>
                <p class="text-sm text-slate-500 mt-1">Preview data statis untuk desain admin panel.</p>
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
                        <th class="px-5 py-4 text-left font-semibold">Email</th>
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
                                <div>
                                    <p class="font-semibold text-slate-800">{{ $citizen->full_name }}</p>
                                    <!-- <p class="text-xs text-slate-500 mt-1">{{ $citizen->village ?? '-' }}</p> -->
                                </div>
                            </td>
                            <td class="px-5 py-4">{{ $citizen->gender }}</td>
                            <td class="px-5 py-4">{{ $citizen->phone ?? '-' }}</td>
                            <td class="px-5 py-4">{{ $citizen->email ?? '-' }}</td>
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
                                    <a href="{{ route('admin.citizens.edit', $citizen->id) }}"  class="rounded-lg bg-sky-50 px-3 py-2 text-sky-700 font-medium hover:bg-sky-100 transition">
                                        Edit
                                    </a>

                                    <button
                                        type="button"
                                        class="rounded-lg bg-rose-50 px-3 py-2 text-rose-700 font-medium hover:bg-rose-100 transition"
                                        onclick="openDeleteModal('{{ $citizen->id }}', '{{ addslashes($citizen->full_name) }}')"
                                    >
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-5 py-8 text-center text-slate-500">
                                Data penduduk belum tersedia.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-5 py-4 border-t border-slate-200 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <p class="text-sm text-slate-500">
                Showing {{ $citizens->firstItem() ?? 0 }} to {{ $citizens->lastItem() ?? 0 }} of {{ $citizens->total() }} entries
            </p>

            <div>
                {{ $citizens->withQueryString()->links() }}
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
                    <p class="text-sm text-slate-500">Tindakan ini akan melakukan soft delete data.</p>
                </div>
            </div>
        </div>

        <div class="p-6">
            <p class="text-sm text-slate-600 leading-6">
                Apakah kamu yakin ingin menghapus data penduduk
                <span id="citizenName" class="font-semibold text-slate-800"></span>?
            </p>
        </div>

        <form id="deleteCitizenForm" method="POST" action="">
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
<script>
    function openDeleteModal(id, name) {
        document.getElementById('citizenName').textContent = name;
        document.getElementById('deleteCitizenForm').action = `/admin/citizens/${id}`;
        const modal = document.getElementById('deleteModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');
        modal.classList.remove('flex');
        modal.classList.add('hidden');
    }

    window.addEventListener('click', function (e) {
        const modal = document.getElementById('deleteModal');
        if (e.target === modal) {
            closeDeleteModal();
        }
    });
</script>
@endpush