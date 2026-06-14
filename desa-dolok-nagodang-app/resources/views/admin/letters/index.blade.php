@extends('layouts.admin')

@section('content')
<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex flex-wrap items-center justify-between gap-3">

        <div class="text-sm text-slate-500 flex items-center gap-2">
            <i data-lucide="mail" class="w-4 h-4"></i>
            Aksi cepat surat elektronik
        </div>

        <div class="flex flex-wrap items-center gap-3">

            <button
                type="button"
                disabled
                aria-disabled="true"
                title="Fitur export sedang disiapkan"
                class="inline-flex cursor-not-allowed items-center gap-2 rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-medium text-slate-400 shadow-sm">

                <i data-lucide="file-down" class="w-4 h-4"></i>
                Export
            </button>

            <a href="{{ route('admin.letters.create') }}"
               class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-5 py-3 text-sm font-semibold text-white hover:bg-emerald-700 shadow-lg shadow-emerald-600/20 transition">

                <i data-lucide="file-plus" class="w-4 h-4"></i>
                Tambah Surat
            </a>

        </div>

    </div>

    {{-- SUMMARY --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

        <div class="rounded-2xl bg-white border border-slate-200 p-5 shadow-sm">
            <div class="flex items-start justify-between">

                <div>
                    <p class="text-sm font-medium text-slate-500">Total Surat</p>
                    <h3 class="mt-3 text-3xl font-bold text-slate-800">
                        {{ number_format($allLetters) }}
                    </h3>
                </div>

                <div class="w-12 h-12 rounded-2xl bg-emerald-100 flex items-center justify-center">
                    <i data-lucide="file-text" class="w-6 h-6 text-emerald-600"></i>
                </div>

            </div>
            <p class="mt-4 text-sm text-slate-500">Total seluruh surat elektronik</p>
        </div>

        <div class="rounded-2xl bg-white border border-slate-200 p-5 shadow-sm">
            <div class="flex items-start justify-between">

                <div>
                    <p class="text-sm font-medium text-slate-500">Diajukan</p>
                    <h3 class="mt-3 text-3xl font-bold text-slate-800">
                        {{ number_format($submittedLetters) }}
                    </h3>
                </div>

                <div class="w-12 h-12 rounded-2xl bg-amber-100 flex items-center justify-center">
                    <i data-lucide="send" class="w-6 h-6 text-amber-600"></i>
                </div>

            </div>
            <p class="mt-4 text-sm text-slate-500">Surat yang baru diajukan</p>
        </div>

        <div class="rounded-2xl bg-white border border-slate-200 p-5 shadow-sm">
            <div class="flex items-start justify-between">

                <div>
                    <p class="text-sm font-medium text-slate-500">Selesai</p>
                    <h3 class="mt-3 text-3xl font-bold text-slate-800">
                        {{ number_format($completedLetters) }}
                    </h3>
                </div>

                <div class="w-12 h-12 rounded-2xl bg-sky-100 flex items-center justify-center">
                    <i data-lucide="check-circle" class="w-6 h-6 text-sky-600"></i>
                </div>

            </div>
            <p class="mt-4 text-sm text-slate-500">Surat yang sudah selesai dibuat</p>
        </div>

    </div>

    {{-- FILTER --}}
    <div class="rounded-2xl bg-white border border-slate-200 shadow-sm p-5">

        <div class="mb-5">
            <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                <i data-lucide="filter" class="w-5 h-5"></i>
                Filter & Pencarian
            </h2>
            <p class="text-sm text-slate-500 mt-1">
                Gunakan filter untuk mempermudah pencarian surat.
            </p>
        </div>

        <form method="GET" action="{{ route('admin.letters.index') }}"
              class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-4">

            <div class="xl:col-span-2">
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Cari Surat
                </label>

                <input
                    type="text"
                    name="search"
                    value="{{ $filters['search'] ?? '' }}"
                    placeholder="Nomor surat, subjek, nama, NIK"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Jenis Surat
                </label>

                <select name="letter_type_id"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">

                    <option value="">Semua</option>
                    @foreach ($letterTypes as $type)
                        <option value="{{ $type->id }}"
                            {{ (string)($filters['letter_type_id'] ?? '') === (string)$type->id ? 'selected' : '' }}>
                            {{ $type->name }}
                        </option>
                    @endforeach

                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Status
                </label>

                <select name="status"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">

                    <option value="">Semua</option>
                    <option value="submitted" {{ ($filters['status'] ?? '') === 'submitted' ? 'selected' : '' }}>
                        Diajukan
                    </option>
                    <option value="completed" {{ ($filters['status'] ?? '') === 'completed' ? 'selected' : '' }}>
                        Selesai
                    </option>

                </select>
            </div>

            <div class="flex items-end gap-3">

                <button class="flex-1 rounded-xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white hover:bg-slate-800 transition">
                    Terapkan
                </button>

                <a href="{{ route('admin.letters.index') }}"
                   class="rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">
                    Reset
                </a>

            </div>

        </form>

    </div>

    {{-- TABLE --}}
    <div class="rounded-2xl bg-white border border-slate-200 shadow-sm overflow-hidden">

        <div class="px-5 py-4 border-b border-slate-200 flex flex-col md:flex-row md:items-center md:justify-between gap-3">

            <div>
                <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                    <i data-lucide="table" class="w-5 h-5"></i>
                    Daftar Surat
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Data surat elektronik yang tersedia di sistem.
                </p>
            </div>

            <div class="inline-flex items-center gap-2 rounded-xl bg-slate-100 px-3 py-2 text-sm text-slate-600">
                <i data-lucide="database" class="w-4 h-4"></i>
                <span class="font-semibold text-slate-800">{{ $letters->count() }}</span>
                data
            </div>

        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">

                <thead class="bg-slate-50 text-slate-600">
                    <tr>
                        <th class="px-5 py-4 text-left font-semibold">No</th>
                        <th class="px-5 py-4 text-left font-semibold">Nomor Surat</th>
                        <th class="px-5 py-4 text-left font-semibold">Jenis</th>
                        <th class="px-5 py-4 text-left font-semibold">Pemohon</th>
                        <th class="px-5 py-4 text-left font-semibold">Subjek</th>
                        <th class="px-5 py-4 text-left font-semibold">Status</th>
                        <th class="px-5 py-4 text-left font-semibold">Tanggal</th>
                        <th class="px-5 py-4 text-center font-semibold">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">

                @forelse ($letters as $index => $letter)
                    <tr class="hover:bg-slate-50 transition">

                        <td class="px-5 py-4">
                            {{ ($letters->firstItem() ?? 0) + $index }}
                        </td>

                        <td class="px-5 py-4 font-medium text-slate-700">
                            {{ $letter->letter_number }}
                        </td>

                        <td class="px-5 py-4 text-slate-600">
                            {{ optional($letter->letterType)->name ?? '-' }}
                        </td>

                        <td class="px-5 py-4">
                            <p class="font-semibold text-slate-800">
                                {{ optional($letter->citizen)->full_name ?? '-' }}
                            </p>
                            <p class="text-xs text-slate-500">
                                {{ optional($letter->citizen)->nik ?? '-' }}
                            </p>
                        </td>

                        <td class="px-5 py-4 text-slate-600">
                            {{ $letter->subject ?? '-' }}
                        </td>

                        <td class="px-5 py-4">
                            @if (strtolower($letter->status) === 'completed')
                                <span class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                                    Selesai
                                </span>
                            @elseif (strtolower($letter->status) === 'submitted')
                                <span class="inline-flex rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">
                                    Diajukan
                                </span>
                            @else
                                <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">
                                    -
                                </span>
                            @endif
                        </td>

                        <td class="px-5 py-4 text-slate-600">
                            {{ $letter->submission_date ? $letter->submission_date->format('d M Y') : '-' }}
                        </td>

                        <td class="px-5 py-4">
                            <div class="flex items-center justify-center gap-2 flex-wrap">

                                <a href="{{ route('admin.letters.preview-pdf', $letter->id) }}"
                                   target="_blank"
                                   class="inline-flex items-center gap-1 rounded-lg bg-violet-50 px-3 py-2 text-violet-700 font-medium hover:bg-violet-100 transition text-xs">

                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                    Lihat
                                </a>

                                @if($letter->result_file)
                                    <a href="{{ asset('storage/' . $letter->result_file) }}"
                                       target="_blank"
                                       class="inline-flex items-center gap-1 rounded-lg bg-green-50 px-3 py-2 text-green-700 font-medium hover:bg-green-100 transition text-xs">

                                        <i data-lucide="download" class="w-4 h-4"></i>
                                        File
                                    </a>
                                @else
                                    <a href="{{ route('admin.letters.download-pdf', $letter->id) }}"
                                       class="inline-flex items-center gap-1 rounded-lg bg-emerald-50 px-3 py-2 text-emerald-700 font-medium hover:bg-emerald-100 transition text-xs">

                                        <i data-lucide="file-down" class="w-4 h-4"></i>
                                        PDF
                                    </a>
                                @endif

                                <form action="{{ route('admin.letters.destroy', $letter->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <button type="button"
                                        class="btn-delete inline-flex items-center gap-1 rounded-lg bg-rose-50 px-3 py-2 text-rose-700 font-medium hover:bg-rose-100 transition text-xs"
                                        data-name="{{ $letter->letter_number }}">

                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        Hapus
                                    </button>
                                </form>

                            </div>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-5 py-8 text-center text-slate-500">
                            Data surat belum tersedia.
                        </td>
                    </tr>
                @endforelse

                </tbody>

            </table>
        </div>

        {{-- PAGINATION --}}
        <div class="px-5 py-4 border-t border-slate-200 flex flex-col md:flex-row md:items-center md:justify-between gap-3">

            <p class="text-sm text-slate-500">
                Menampilkan {{ $letters->firstItem() ?? 0 }}
                sampai {{ $letters->lastItem() ?? 0 }}
                dari {{ $letters->total() }} data
            </p>

            <div>
                {{ $letters->withQueryString()->links() }}
            </div>

        </div>

    </div>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    if (typeof Swal === 'undefined') return;

    document.addEventListener('click', function (e) {

        const button = e.target.closest('.btn-delete');
        if (!button) return;

        e.preventDefault();

        const form = button.closest('form');
        const nama = button.dataset.name || 'surat ini';

        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: `Hapus "${nama}"?`,
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
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading()
                });

                form.submit();
            }
        });

    });

});
</script>
@endpush