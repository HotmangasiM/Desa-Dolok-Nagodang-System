@extends('layouts.public')

@section('content')

<section class="bg-white">

    <div class="max-w-7xl mx-auto px-4 lg:px-6 py-6">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">

            {{-- MAIN CONTENT --}}
            <div class="lg:col-span-8">

                {{-- HERO --}}
                <div>

                    {{-- Breadcrumb --}}
                    <div class="flex items-center flex-wrap gap-2 text-sm text-slate-500">

                        <a href="{{ route('public.home') }}"
                           class="font-medium hover:text-emerald-700 transition">
                            Beranda
                        </a>

                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="w-4 h-4 text-slate-400"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M9 5l7 7-7 7"/>

                        </svg>

                        <a href="{{ route('infrastruktur.index') }}"
                           class="font-medium hover:text-emerald-700 transition">
                            Infrastruktur Desa
                        </a>

                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="w-4 h-4 text-slate-400"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M9 5l7 7-7 7"/>

                        </svg>

                        <span class="text-slate-700 line-clamp-1">
                            Detail Pembangunan
                        </span>

                    </div>


                    {{-- TITLE --}}
                    <div class="mt-5">

                        <div class="inline-flex items-center rounded-full bg-emerald-50 px-4 py-2 text-sm font-semibold text-emerald-700 border border-emerald-100">

                            {{ $infrastructure->category ?? 'Infrastruktur Desa' }}

                        </div>

                        <h1 class="mt-5 text-3xl md:text-5xl font-black leading-tight tracking-tight text-slate-900">

                            {{ $infrastructure->title }}

                        </h1>

                    </div>


                    {{-- META --}}
                    <div class="mt-6 flex flex-wrap items-center gap-6 text-sm text-slate-500">

                        {{-- TANGGAL --}}
                        <div class="flex items-center gap-2">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="w-5 h-5 text-slate-400"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="1.8"
                                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>

                            </svg>

                            <span>
                                {{ $infrastructure->date ?? '-' }}
                            </span>

                        </div>


                        {{-- STATUS --}}
                        <div class="flex items-center gap-2">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="w-5 h-5 text-slate-400"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="1.8"
                                      d="M9 12l2 2 4-4"/>

                            </svg>

                            <span>
                                {{ $infrastructure->status ?? 'Selesai' }}
                            </span>

                        </div>


                        {{-- LOKASI --}}
                        <div class="flex items-center gap-2">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="w-5 h-5 text-slate-400"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="1.8"
                                      d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="1.8"
                                      d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>

                            </svg>

                            <span>
                                {{ $infrastructure->location ?? 'Desa Dolok Nagodang' }}
                            </span>

                        </div>

                    </div>

                </div>



                {{-- IMAGE --}}
                @if ($infrastructure->image)

                    <div class="mt-8">

                        <img
                            src="{{ asset('storage/' . $infrastructure->image) }}"
                            alt="{{ $infrastructure->title }}"
                            class="w-full rounded-3xl object-cover max-h-[560px]"
                        >

                    </div>

                @else

                    <div class="mt-8 rounded-3xl bg-slate-100 aspect-video flex items-center justify-center text-7xl">
                        🏗️
                    </div>

                @endif



                {{-- ARTICLE --}}
                <article class="mt-10">

                    {{-- LEAD --}}
                    <div class="rounded-3xl bg-emerald-50 border border-emerald-100 p-6">

                        <p class="text-lg md:text-xl leading-9 text-slate-700">

                            {{ $infrastructure->short_description ?? 'Informasi pembangunan dan infrastruktur desa akan ditampilkan pada halaman ini.' }}

                        </p>

                    </div>


                    {{-- CONTENT --}}
                    <div class="mt-10 text-[17px] leading-9 text-slate-700 whitespace-pre-line">

                        {{ $infrastructure->description ?? 'Konten detail pembangunan desa belum tersedia.' }}

                    </div>


                    {{-- FOOTER --}}
                    <div class="mt-14 pt-6 border-t border-slate-200">

                        <a href="{{ route('infrastruktur.index') }}"
                           class="inline-flex items-center text-sm font-semibold text-emerald-700 hover:text-emerald-800 transition">

                            ← Kembali ke Infrastruktur Desa

                        </a>

                    </div>

                </article>

            </div>



            {{-- SIDEBAR --}}
            <aside class="lg:col-span-4">

                <div class="sticky top-24 space-y-6">

                    {{-- INFO CARD --}}
                    <div class="rounded-3xl bg-emerald-950 p-7 text-white">

                        <p class="text-sm font-semibold text-emerald-200">
                            Informasi Pembangunan
                        </p>

                        <div class="mt-6 space-y-5">

                            <div>

                                <p class="text-sm text-emerald-200">
                                    Kategori
                                </p>

                                <h3 class="mt-1 text-lg font-bold">
                                    {{ $infrastructure->category ?? 'Infrastruktur' }}
                                </h3>

                            </div>

                            <div>

                                <p class="text-sm text-emerald-200">
                                    Status
                                </p>

                                <h3 class="mt-1 text-lg font-bold">
                                    {{ $infrastructure->status ?? 'Selesai' }}
                                </h3>

                            </div>

                            <div>

                                <p class="text-sm text-emerald-200">
                                    Lokasi
                                </p>

                                <h3 class="mt-1 text-lg font-bold">
                                    {{ $infrastructure->location ?? 'Desa Dolok Nagodang' }}
                                </h3>

                            </div>

                        </div>

                    </div>


                    {{-- PEMBANGUNAN LAINNYA --}}
                    @if(isset($relatedInfrastructures) && $relatedInfrastructures->count())

                        <div>

                            <div class="mb-5">

                                <h2 class="text-2xl font-bold text-slate-900">
                                    Pembangunan Lainnya
                                </h2>

                                <p class="mt-1 text-sm text-slate-500">
                                    Infrastruktur desa lainnya.
                                </p>

                            </div>


                            <div class="space-y-5">

                                @foreach ($relatedInfrastructures as $item)

                                    <a href="{{ route('infrastruktur.show', $item->slug) }}"
                                       class="flex gap-4 group">

                                        {{-- IMAGE --}}
                                        <div class="w-32 h-24 rounded-2xl overflow-hidden bg-slate-100 shrink-0">

                                            @if ($item->image)

                                                <img
                                                    src="{{ asset('storage/' . $item->image) }}"
                                                    alt="{{ $item->title }}"
                                                    class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                                                >

                                            @else

                                                <div class="w-full h-full flex items-center justify-center text-3xl">
                                                    🏗️
                                                </div>

                                            @endif

                                        </div>


                                        {{-- CONTENT --}}
                                        <div class="min-w-0">

                                            <p class="text-xs text-slate-400">
                                                {{ $item->date ?? '-' }}
                                            </p>

                                            <h3 class="mt-1 text-base font-bold leading-6 text-slate-800 group-hover:text-emerald-700 transition line-clamp-2">

                                                {{ $item->title }}

                                            </h3>

                                            <p class="mt-2 text-sm leading-6 text-slate-500 line-clamp-2">

                                                {{ \Illuminate\Support\Str::limit(strip_tags($item->description), 70) }}

                                            </p>

                                        </div>

                                    </a>

                                @endforeach

                            </div>

                        </div>

                    @endif

                </div>

            </aside>

        </div>

    </div>

</section>

@endsection