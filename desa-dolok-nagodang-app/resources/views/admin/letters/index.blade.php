@extends('layouts.admin')

@section('content')
@if (session('success'))
    <div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
        {{ session('success') }}
    </div>
@endif

<div class="space-y-6">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div class="text-sm text-slate-500">
            Aksi cepat surat elektronik
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <button
                type="button"
                class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-medium text-slate-700 hover:bg-slate-50 shadow-sm transition">
                ⬇ Export
            </button>

            <a href="{{ route('admin.letters.create') }}"
            class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-5 py-3 text-sm font-semibold text-white hover:bg-emerald-700 shadow-lg shadow-emerald-600/20 transition">
                ＋ Tambah Surat
            </a>
        </div>
    </div>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <div class="rounded-2xl bg-white border border-slate-200 p-5 shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Total Surat</p>
                    <h3 class="mt-3 text-3xl font-bold text-slate-800">{{ number_format($allLetters) }}</h3>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-emerald-100 flex items-center justify-center text-2xl">
                    📄
                </div>
            </div>
            <p class="mt-4 text-sm text-slate-500">Total seluruh surat elektronik</p>
        </div>

        <div class="rounded-2xl bg-white border border-slate-200 p-5 shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Submitted</p>
                    <h3 class="mt-3 text-3xl font-bold text-slate-800">{{ number_format($submittedLetters) }}</h3>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-amber-100 flex items-center justify-center text-2xl">
                    📨
                </div>
            </div>
            <p class="mt-4 text-sm text-slate-500">Surat yang baru diajukan</p>
        </div>

        <div class="rounded-2xl bg-white border border-slate-200 p-5 shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Completed</p>
                    <h3 class="mt-3 text-3xl font-bold text-slate-800">{{ number_format($completedLetters) }}</h3>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-sky-100 flex items-center justify-center text-2xl">
                    ✅
                </div>
            </div>
            <p class="mt-4 text-sm text-slate-500">Surat yang sudah selesai dibuat</p>
        </div>
    </div>

    {{-- Filter --}}
    <div class="rounded-2xl bg-white border border-slate-200 shadow-sm p-5">
        <div class="flex items-center justify-between mb-5">
            <div>
                <h2 class="text-lg font-bold text-slate-800">Filter & Pencarian</h2>
                <p class="text-sm text-slate-500 mt-1">Gunakan filter untuk mempermudah pencarian surat.</p>
            </div>
        </div>

        <form method="GET" action="{{ route('admin.letters.index') }}" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-4">
            <div class="xl:col-span-2">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Cari Surat</label>
                <input
                    type="text"
                    name="search"
                    value="{{ $filters['search'] ?? '' }}"
                    placeholder="Cari nomor surat, subjek, nama, atau NIK"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                >
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Jenis Surat</label>
                <select
                    name="letter_type_id"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                >
                    <option value="">Semua</option>
                    @foreach ($letterTypes as $type)
                        <option value="{{ $type->id }}" {{ (string) ($filters['letter_type_id'] ?? '') === (string) $type->id ? 'selected' : '' }}>
                            {{ $type->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Status</label>
                <select
                    name="status"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                >
                    <option value="">Semua</option>
                    <option value="submitted" {{ ($filters['status'] ?? '') === 'submitted' ? 'selected' : '' }}>submitted</option>
                    <option value="processed" {{ ($filters['status'] ?? '') === 'processed' ? 'selected' : '' }}>processed</option>
                    <option value="completed" {{ ($filters['status'] ?? '') === 'completed' ? 'selected' : '' }}>completed</option>
                </select>
            </div>

            <div class="flex items-end gap-3">
                <button class="w-full rounded-xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white hover:bg-slate-800 transition">
                    Terapkan
                </button>
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="rounded-2xl bg-white border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-200 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h2 class="text-lg font-bold text-slate-800">Daftar Surat</h2>
                <p class="text-sm text-slate-500 mt-1">Data surat elektronik yang tersedia di sistem.</p>
            </div>

            <div class="inline-flex items-center gap-2 rounded-xl bg-slate-100 px-3 py-2 text-sm text-slate-600">
                <span>Menampilkan</span>
                <span class="font-semibold text-slate-800">{{ $letters->count() }}</span>
                <span>data</span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 text-slate-600">
                    <tr>
                        <th class="px-5 py-4 text-left font-semibold">No</th>
                        <th class="px-5 py-4 text-left font-semibold">Nomor Surat</th>
                        <th class="px-5 py-4 text-left font-semibold">Jenis Surat</th>
                        <th class="px-5 py-4 text-left font-semibold">Pemohon</th>
                        <th class="px-5 py-4 text-left font-semibold">Subjek</th>
                        <th class="px-5 py-4 text-left font-semibold">Status</th>
                        <th class="px-5 py-4 text-left font-semibold">Tanggal</th>
                        <th class="px-5 py-4 text-center font-semibold">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse ($letters as $index => $letter)
                        <tr class="hover:bg-slate-50/80 transition">
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
                                <div>
                                    <p class="font-semibold text-slate-800">{{ optional($letter->citizen)->full_name ?? '-' }}</p>
                                    <p class="text-xs text-slate-500 mt-1">{{ optional($letter->citizen)->nik ?? '-' }}</p>
                                </div>
                            </td>

                            <td class="px-5 py-4 text-slate-600">
                                {{ $letter->subject ?? '-' }}
                            </td>

                            <td class="px-5 py-4">
                                @if ($letter->status === 'COMPLETED')
                                    <span class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                                        COMPLETED
                                    </span>
                                @elseif ($letter->status === 'SUBMITTED')
                                    <span class="inline-flex rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">
                                        SUBMITTED
                                    </span>
                                @elseif ($letter->status === 'PROCESSING')
                                    <span class="inline-flex rounded-full bg-sky-100 px-3 py-1 text-xs font-semibold text-sky-700">
                                        PROCESSING
                                    </span>
                                @else
                                    <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">
                                        {{ $letter->status ?? '-' }}
                                    </span>
                                @endif
                            </td>

                            <td class="px-5 py-4 text-slate-600">
                                {{ $letter->submission_date ? $letter->submission_date->format('d M Y') : '-' }}
                            </td>

                            <td class="px-5 py-4">
                                <div class="flex items-center justify-center gap-2 flex-wrap">
                                    <a href="{{ route('admin.letters.edit', $letter->id) }}"
                                       class="rounded-lg bg-sky-50 px-3 py-2 text-sky-700 font-medium hover:bg-sky-100 transition text-xs">
                                        Edit
                                    </a>

                                    <a href="{{ route('admin.letters.preview-pdf', $letter->id) }}"
                                       target="_blank"
                                       class="rounded-lg bg-violet-50 px-3 py-2 text-violet-700 font-medium hover:bg-violet-100 transition text-xs">
                                        Preview
                                    </a>

                                    @if($letter->result_file)
                                        <a href="{{ asset('storage/' . $letter->result_file) }}"
                                           target="_blank"
                                           class="rounded-lg bg-green-50 px-3 py-2 text-green-700 font-medium hover:bg-green-100 transition text-xs">
                                            Download File
                                        </a>

                                        <a href="{{ route('admin.letters.download-pdf', $letter->id) }}"
                                           class="rounded-lg bg-amber-50 px-3 py-2 text-amber-700 font-medium hover:bg-amber-100 transition text-xs">
                                            Regenerate
                                        </a>
                                    @else
                                        <a href="{{ route('admin.letters.download-pdf', $letter->id) }}"
                                           class="rounded-lg bg-emerald-50 px-3 py-2 text-emerald-700 font-medium hover:bg-emerald-100 transition text-xs">
                                            Generate PDF
                                        </a>
                                    @endif

                                    <button
                                        type="button"
                                        class="rounded-lg bg-rose-50 px-3 py-2 text-rose-700 font-medium hover:bg-rose-100 transition text-xs"
                                        onclick="openDeleteModal('{{ $letter->id }}', '{{ addslashes($letter->letter_number) }}')"
                                    >
                                        Delete
                                    </button>
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

        <div class="px-5 py-4 border-t border-slate-200 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <p class="text-sm text-slate-500">
                Showing {{ $letters->firstItem() ?? 0 }} to {{ $letters->lastItem() ?? 0 }} of {{ $letters->total() }} entries
            </p>

            <div>
                {{ $letters->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>

<div id="deleteModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/50 px-4">
    <div class="w-full max-w-md rounded-2xl bg-white shadow-2xl">
        <div class="p-6 border-b border-slate-200">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-full bg-rose-100 flex items-center justify-center text-2xl">
                    ⚠️
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-800">Konfirmasi Hapus</h3>
                    <p class="text-sm text-slate-500">Tindakan ini akan menghapus data surat.</p>
                </div>
            </div>
        </div>

        <div class="p-6">
            <p class="text-sm text-slate-600 leading-6">
                Apakah kamu yakin ingin menghapus surat
                <span id="letterNumber" class="font-semibold text-slate-800"></span>?
            </p>
        </div>

        <form id="deleteLetterForm" method="POST" action="">
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
    function openDeleteModal(id, number) {
        document.getElementById('letterNumber').textContent = number;
        document.getElementById('deleteLetterForm').action = `/admin/letters/${id}`;

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