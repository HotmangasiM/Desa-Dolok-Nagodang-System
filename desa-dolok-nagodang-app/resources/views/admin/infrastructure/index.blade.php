@extends('layouts.admin')

@section('content')

<div class="space-y-6">

```
{{-- HEADER --}}
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

        <svg xmlns="http://www.w3.org/2000/svg"
             class="w-4 h-4"
             fill="none"
             viewBox="0 0 24 24"
             stroke="currentColor">
            <path stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M12 4v16m8-8H4"/>
        </svg>

        Tambah Infrastruktur
    </a>

</div>

{{-- FLASH MESSAGE --}}
@if(session('success'))
    <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm text-emerald-700">
        {{ session('success') }}
    </div>
@endif

{{-- STATISTIC --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-5">

    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
        <p class="text-sm text-slate-500">Total Infrastruktur</p>
        <h2 class="text-3xl font-bold text-slate-800 mt-2">
            {{ number_format($allInfrastructure ?? $data->total()) }}
        </h2>
    </div>

    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
        <p class="text-sm text-slate-500">Dipublikasikan</p>
        <h2 class="text-3xl font-bold text-emerald-600 mt-2">
            {{ number_format($publishedInfrastructure ?? 0) }}
        </h2>
    </div>

    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
        <p class="text-sm text-slate-500">Draft</p>
        <h2 class="text-3xl font-bold text-amber-500 mt-2">
            {{ number_format($draftInfrastructure ?? 0) }}
        </h2>
    </div>

</div>

{{-- SEARCH --}}
<div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-sm">

    <form method="GET"
          action="{{ route('admin.infrastructure.index') }}">

        <div class="flex flex-col md:flex-row gap-3">

            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari judul infrastruktur..."
                class="flex-1 rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
            >

            <button
                type="submit"
                class="rounded-xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white hover:bg-slate-800 transition">
                Cari
            </button>

        </div>

    </form>

</div>

{{-- TABLE --}}
<div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">

    <div class="overflow-x-auto">

        <table class="min-w-full text-sm">

            <thead class="bg-slate-50 border-b border-slate-200">

                <tr>

                    <th class="px-5 py-4 text-left font-semibold text-slate-600">
                        No
                    </th>

                    <th class="px-5 py-4 text-left font-semibold text-slate-600">
                        Gambar
                    </th>

                    <th class="px-5 py-4 text-left font-semibold text-slate-600">
                        Judul
                    </th>

                    <th class="px-5 py-4 text-left font-semibold text-slate-600">
                        Status
                    </th>

                    <th class="px-5 py-4 text-left font-semibold text-slate-600">
                        Tanggal
                    </th>

                    <th class="px-5 py-4 text-center font-semibold text-slate-600">
                        Aksi
                    </th>

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
                                    No Image
                                </div>

                            @endif

                        </td>

                        <td class="px-5 py-4">

                            <div class="font-semibold text-slate-800">
                                {{ $item->title }}
                            </div>

                            <div class="text-xs text-slate-500 mt-1">
                                {{ \Illuminate\Support\Str::limit(strip_tags($item->content), 80) }}
                            </div>

                        </td>

                        <td class="px-5 py-4">

                            @if($item->status == 'publish')

                                <span class="inline-flex items-center rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                                    Publish
                                </span>

                            @else

                                <span class="inline-flex items-center rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">
                                    Draft
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

                                <form method="POST"
                                      action="{{ route('admin.infrastructure.destroy', $item->id) }}"
                                      class="delete-form">

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

                            <div class="text-5xl mb-4">
                                🏗️
                            </div>

                            <h3 class="text-lg font-semibold text-slate-700">
                                Belum Ada Data Infrastruktur
                            </h3>

                            <p class="text-sm text-slate-500 mt-2">
                                Silakan tambahkan data infrastruktur pertama Anda.
                            </p>

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

{{-- PAGINATION --}}
<div>
    {{ $data->links() }}
</div>
```

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
