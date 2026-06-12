@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">
                Infrastruktur Desa
            </h1>
            <p class="text-sm text-slate-500 mt-1">
                Kelola data pembangunan dan fasilitas desa.
            </p>
        </div>

        <a href="{{ route('admin.infrastructure.create') }}"
           class="inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-600 px-5 py-3 text-sm font-semibold text-white hover:bg-emerald-700 shadow-lg shadow-emerald-600/20 transition">
            <i data-lucide="plus" class="w-4 h-4"></i>
            Tambah Infrastruktur
        </a>
    </div>

    @if(session('success'))
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm text-slate-500">Total Infrastruktur</p>
                    <h2 class="text-3xl font-bold text-slate-800 mt-2">
                        {{ number_format($allInfrastructure ?? $data->total()) }}
                    </h2>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-emerald-100 flex items-center justify-center text-emerald-700">
                    <i data-lucide="building-2" class="w-6 h-6"></i>
                </div>
            </div>
        </div>

        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm text-slate-500">Dipublikasikan</p>
                    <h2 class="text-3xl font-bold text-emerald-600 mt-2">
                        {{ number_format($publishedInfrastructure ?? 0) }}
                    </h2>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-sky-100 flex items-center justify-center text-sky-700">
                    <i data-lucide="send" class="w-6 h-6"></i>
                </div>
            </div>
        </div>

        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm text-slate-500">Draf</p>
                    <h2 class="text-3xl font-bold text-amber-500 mt-2">
                        {{ number_format($draftInfrastructure ?? 0) }}
                    </h2>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-amber-100 flex items-center justify-center text-amber-700">
                    <i data-lucide="file-pen-line" class="w-6 h-6"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
        <form method="GET" action="{{ route('admin.infrastructure.index') }}">
            <div class="flex flex-col md:flex-row gap-3">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari judul infrastruktur"
                    class="flex-1 rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                >

                <button
                    type="submit"
                    class="rounded-xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white hover:bg-slate-800 transition">
                    Cari
                </button>

                <a href="{{ route('admin.infrastructure.index') }}"
                   class="rounded-xl border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-5 py-4 text-left font-semibold text-slate-600">No</th>
                        <th class="px-5 py-4 text-left font-semibold text-slate-600">Gambar</th>
                        <th class="px-5 py-4 text-left font-semibold text-slate-600">Judul</th>
                        <th class="px-5 py-4 text-left font-semibold text-slate-600">Status</th>
                        <th class="px-5 py-4 text-left font-semibold text-slate-600">Tanggal</th>
                        <th class="px-5 py-4 text-center font-semibold text-slate-600">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($data as $index => $item)
                        <tr class="border-b border-slate-100 hover:bg-slate-50 transition">
                            <td class="px-5 py-4">
                                {{ ($data->firstItem() ?? 0) + $index }}
                            </td>

                            <td class="px-5 py-4">
                                @if($item->image)
                                    <img
                                        src="{{ asset('storage/'.$item->image) }}"
                                        alt="{{ $item->title }}"
                                        class="w-20 h-14 object-cover rounded-xl border border-slate-200"
                                    >
                                @else
                                    <div class="w-20 h-14 rounded-xl bg-slate-100 flex items-center justify-center text-xs text-slate-400">
                                        Tanpa Gambar
                                    </div>
                                @endif
                            </td>

                            <td class="px-5 py-4">
                                <div class="font-semibold text-slate-800">
                                    {{ $item->title }}
                                </div>
                                <div class="text-xs text-slate-500 mt-1 max-w-md">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($item->content), 80) }}
                                </div>
                            </td>

                            <td class="px-5 py-4">
                                @if($item->status == 'publish')
                                    <span class="inline-flex items-center rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                                        Dipublikasikan
                                    </span>
                                @else
                                    <span class="inline-flex items-center rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">
                                        Draf
                                    </span>
                                @endif
                            </td>

                            <td class="px-5 py-4 text-slate-500">
                                {{ $item->created_at->format('d M Y') }}
                            </td>

                            <td class="px-5 py-4">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('admin.infrastructure.edit', $item->id) }}"
                                       class="inline-flex items-center rounded-lg bg-sky-50 px-3 py-2 text-xs font-medium text-sky-700 hover:bg-sky-100">
                                        Edit
                                    </a>

                                    <form method="POST" action="{{ route('admin.infrastructure.destroy', $item->id) }}" class="delete-form">
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            data-name="{{ $item->title }}"
                                            class="inline-flex items-center rounded-lg bg-rose-50 px-3 py-2 text-xs font-medium text-rose-700 hover:bg-rose-100">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-16 text-center">
                                <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-slate-100 text-slate-400">
                                    <i data-lucide="building-2" class="w-6 h-6"></i>
                                </div>
                                <h3 class="text-lg font-semibold text-slate-700">
                                    Belum Ada Data Infrastruktur
                                </h3>
                                <p class="text-sm text-slate-500 mt-2">
                                    Silakan tambahkan data infrastruktur pertama.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-5 py-4 border-t border-slate-200">
            {{ $data->links() }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const name = this.querySelector('button').dataset.name;

            Swal.fire({
                title: 'Hapus Data?',
                text: `Data "${name}" akan dihapus permanen.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b'
            }).then((result) => {
                if(result.isConfirmed){
                    Swal.fire({
                        title: 'Menghapus...',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        didOpen: () => Swal.showLoading()
                    });

                    form.submit();
                }
            });
        });
    });
});
</script>
@endpush
