@extends('layouts.public')

@section('content')

{{-- HERO --}}
<section class="bg-emerald-950 text-white">

    <div class="max-w-7xl mx-auto px-4 py-10 md:py-12">

        <p class="inline-flex rounded-full bg-white/10 px-3 py-1 text-xs text-emerald-100 border border-white/10">
            Pembangunan Desa
        </p>

        <h1 class="mt-4 text-3xl md:text-4xl font-bold leading-tight">
            Infrastruktur Desa
        </h1>

        <p class="mt-3 max-w-2xl text-sm md:text-base text-emerald-100 leading-6">
            Informasi pembangunan, infrastruktur, fasilitas desa,
            dan dokumentasi kegiatan pembangunan Desa Dolok Nagodang.
        </p>

    </div>

</section>

{{-- SEARCH --}}
<section class="max-w-7xl mx-auto px-4 mt-8 relative z-10">

    <div class="rounded-3xl bg-white border border-slate-200 p-5 shadow-sm">

        <form
            method="GET"
            action="{{ route('public.infrastruktur.index') }}"
            class="flex flex-col md:flex-row gap-3"
        >

            <input
                type="text"
                name="search"
                value="{{ $search ?? '' }}"
                placeholder="Cari pembangunan desa..."
                class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
            >

            <button
                type="submit"
                class="rounded-xl bg-emerald-600 px-5 py-3 text-sm font-semibold text-white hover:bg-emerald-700 transition"
            >
                Cari
            </button>

            @if(!empty($search))
                <a
                    href="{{ route('public.infrastruktur.index') }}"
                    class="rounded-xl border border-slate-300 px-5 py-3 text-sm font-semibold text-slate-700 text-center hover:bg-slate-50 transition"
                >
                    Reset
                </a>
            @endif

        </form>

    </div>

</section>

{{-- CONTENT --}}
<section class="max-w-7xl mx-auto px-4 py-16">

    {{-- GRID --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

        @forelse ($infrastructures as $item)

            <a
                href="{{ route('public.infrastruktur.show', $item->slug) }}"
                class="group rounded-3xl bg-white border border-slate-200 shadow-sm overflow-hidden hover:shadow-xl hover:-translate-y-1 transition duration-300"
            >

                {{-- IMAGE --}}
                <div class="aspect-[4/3] bg-slate-100 overflow-hidden">

                    @if ($item->image)

                        <img
                            src="{{ asset('storage/' . $item->image) }}"
                            alt="{{ $item->nama_barang }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                        >

                    @else
                        <div class="flex h-full w-full items-center justify-center bg-slate-100 text-slate-400">
                            <i data-lucide="building-2" class="h-14 w-14"></i>
                        </div>
                    @endif

                </div>

                {{-- CONTENT --}}
                <div class="p-5">

                    {{-- META --}}
                    <div class="flex items-center justify-between gap-3">

                        <div class="flex items-center gap-2 text-xs text-slate-500">

                            <i data-lucide="calendar-days" class="w-4 h-4"></i>

                            <span>
                                    {{ $item->created_at ? $item->created_at->format('d M Y') : '-' }}
                            </span>
                        </div>

                        <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">
                            {{ $item->jenis_barang ?: 'Infrastruktur' }}
                        </span>

                    </div>

                    {{-- TITLE --}}
                    <h2 class="mt-4 text-xl font-bold text-slate-800 leading-snug group-hover:text-emerald-700 transition">

                        {{ $item->nama_barang }}

                    </h2>

                    {{-- DESCRIPTION --}}
                    <p class="mt-3 text-sm text-slate-500 leading-7">
                        {{ \Illuminate\Support\Str::limit(strip_tags($item->content), 120) ?: 'Informasi pembangunan desa akan ditampilkan di sini.' }}

                    </p>

                    {{-- FOOTER --}}
                    <div class="mt-5 flex items-center justify-between">

                        <div class="text-sm text-slate-400">
                            Detail pembangunan
                        </div>

                        <div class="flex items-center gap-2 text-sm font-semibold text-emerald-700">
                            <span>Lihat detail</span>
                            <i data-lucide="arrow-right" class="h-4 w-4"></i>
                        </div>

                    </div>

                </div>

            </a>

        @empty

            {{-- EMPTY --}}
            <div class="md:col-span-2 xl:col-span-3">

                <div class="rounded-3xl bg-white border border-slate-200 p-12 text-center shadow-sm">

                    <div class="flex justify-center text-slate-400">
                        <i data-lucide="building-2" class="h-14 w-14"></i>
                    </div>

                    <h3 class="mt-5 text-xl font-bold text-slate-800">
                        Data Infrastruktur Belum Tersedia
                    </h3>

                    <p class="mt-3 text-slate-500 leading-7 max-w-xl mx-auto">
                        Data pembangunan desa akan ditampilkan di halaman ini
                        setelah admin menambahkan data infrastruktur desa.
                    </p>

                </div>

            </div>

        @endforelse

    </div>

    {{-- PAGINATION --}}
    @if(method_exists($infrastructures, 'links'))

        <div class="mt-10">
            {{ $infrastructures->links() }}
        </div>

    @endif

</section>

@endsection

