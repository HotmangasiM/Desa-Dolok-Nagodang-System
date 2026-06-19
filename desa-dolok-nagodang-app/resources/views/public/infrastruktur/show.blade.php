@extends('layouts.public')

@section('content')

<section class="bg-white">

    <div class="max-w-7xl mx-auto px-4 lg:px-6 py-6">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">

            {{-- MAIN CONTENT --}}
            <div class="lg:col-span-8">

                {{-- BREADCRUMB --}}
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

                    <a href="{{ route('public.infrastruktur.index') }}"
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
                        {{ $infrastructure->nama_barang }}
                    </span>

                </div>

                {{-- HEADER --}}
                <div class="mt-5">

                    <div class="inline-flex items-center rounded-full bg-emerald-50 px-4 py-2 text-sm font-semibold text-emerald-700 border border-emerald-100">
                        Infrastruktur Desa
                    </div>

                    <h1 class="mt-5 text-3xl md:text-5xl font-black leading-tight tracking-tight text-slate-900">
                        {{ $infrastructure->nama_barang }}
                    </h1>

                </div>

                {{-- META --}}
                <div class="mt-5 flex flex-wrap items-center gap-6 text-sm text-slate-500">

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
                            {{ $infrastructure->created_at->format('d F Y') }}
                        </span>

                    </div>

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
                            {{ ucfirst($infrastructure->status) }}
                        </span>

                    </div>

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
                            Desa Dolok Nagodang
                        </span>

                    </div>

                </div>

                {{-- IMAGE --}}
                @if ($infrastructure->image)

                    <div class="mt-8">

                        <img
                            src="{{ asset('storage/' . $infrastructure->image) }}"
                            alt="{{ $infrastructure->nama_barang }}"
                            class="w-full rounded-2xl object-cover max-h-[550px]"
                        >

                    </div>

                @endif

                {{-- ARTICLE --}}
                <article class="mt-10">

                    <!-- {{-- LEAD --}}
                    <div class="rounded-3xl bg-emerald-50 border border-emerald-100 p-6">

                        <p class="text-lg md:text-xl leading-9 text-slate-700">

                            {{ \Illuminate\Support\Str::limit(strip_tags($infrastructure->content), 220) }}

                        </p>

                    </div> -->

                    {{-- CONTENT --}}
                    <div class="mt-10 prose prose-lg max-w-none prose-slate">

                        {!! nl2br(e($infrastructure->content)) !!}

                    </div>

                    {{-- FOOTER --}}
                    <div class="mt-12 pt-6 border-t border-slate-200">

                        <a href="{{ route('public.infrastruktur.index') }}"
                           class="inline-flex items-center gap-2 text-sm font-semibold text-emerald-700 transition hover:text-emerald-800">
                            <i data-lucide="arrow-left" class="h-4 w-4"></i>
                            Kembali ke Infrastruktur Desa
                        </a>

                    </div>

                </article>

            </div>

           {{-- SIDEBAR --}}
<aside class="lg:col-span-4">

    @if(isset($relatedInfrastructures) && $relatedInfrastructures->count())

        <div class="sticky top-24">

            {{-- HEADING --}}
            <div class="mb-5">

                <h2 class="text-2xl font-bold text-slate-900">
                    Pembangunan Lainnya
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Informasi pembangunan dan infrastruktur terbaru desa.
                </p>

            </div>

            {{-- LIST --}}
            <div class="space-y-5">

                @foreach ($relatedInfrastructures as $item)

                    <a href="{{ route('public.infrastruktur.show', $item->slug) }}"
                       class="flex gap-4 group">

                        {{-- IMAGE --}}
                        <div class="w-32 h-24 rounded-xl overflow-hidden bg-slate-100 shrink-0">

                            @if($item->image)

                                <img
                                    src="{{ asset('storage/' . $item->image) }}"
                                    alt="{{ $item->nama_barang }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                                >

                            @else

                                <div class="w-full h-full flex items-center justify-center bg-slate-100">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         class="w-8 h-8 text-slate-400"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor">

                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              stroke-width="1.5"
                                              d="M3 7l9-4 9 4-9 4-9-4zm0 0v10l9 4 9-4V7"/>

                                    </svg>

                                </div>

                            @endif

                        </div>

                        {{-- CONTENT --}}
                        <div class="min-w-0">

                            <p class="text-xs text-slate-400">
                                {{ $item->created_at->format('d M Y') }}
                            </p>

                            <h3 class="mt-1 text-base font-bold leading-6 text-slate-800 group-hover:text-emerald-700 transition line-clamp-2">
                                {{ $item->nama_barang }}
                            </h3>

                            <p class="mt-2 text-sm leading-6 text-slate-500 line-clamp-2">
                                {{ \Illuminate\Support\Str::limit(strip_tags($item->content), 80) }}
                            </p>

                        </div>

                    </a>

                @endforeach

            </div>

            {{-- BUTTON --}}
            <div class="mt-8">

                <a href="{{ route('public.infrastruktur.index') }}"
                   class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-600 px-5 py-3 text-sm font-semibold text-white hover:bg-emerald-700 transition shadow-lg shadow-emerald-600/20">

                    Lihat Semua Infrastruktur

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="w-4 h-4"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M9 5l7 7-7 7"/>

                    </svg>

                </a>

            </div>

        </div>

    @else

        <!-- {{-- EMPTY STATE --}}
        <div class="sticky top-24">

            <div class="rounded-3xl border border-slate-200 bg-slate-50 p-8 text-center">

                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-white shadow-sm">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-8 w-8 text-slate-400"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="1.5"
                              d="M3 7l9-4 9 4-9 4-9-4zm0 0v10l9 4 9-4V7"/>

                    </svg>

                </div>

                <h3 class="mt-5 text-lg font-bold text-slate-700">
                    Belum Ada Infrastruktur Lainnya
                </h3>

                <p class="mt-2 text-sm text-slate-500">
                    Data pembangunan lainnya akan ditampilkan di sini.
                </p>

            </div>

        </div> -->

    @endif

</aside>

        </div>

    </div>

</section>

@endsection
