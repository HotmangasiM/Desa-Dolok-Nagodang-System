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

    <a href="{{ route('public.news.index') }}"
       class="font-medium hover:text-emerald-700 transition">
        Berita Desa
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
        Detail Berita
    </span>

</div>


                    {{-- Title --}}
                    <div class="mt-5">

                        <h1 class="text-3xl md:text-5xl font-black leading-tight tracking-tight text-slate-900">
                            {{ $newsItem->title }}
                        </h1>

                    </div>


                    {{-- Meta --}}
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
                                {{ $newsItem->published_at ? $newsItem->published_at->format('d F Y') : '-' }}
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
                                      d="M5.121 17.804A9 9 0 1118.88 17.804M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>

                            </svg>

                            <span>
                                Administrator
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
                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="1.8"
                                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>

                            </svg>

                            <span>
                                {{ $newsItem->views ?? 0 }} kali dilihat
                            </span>

                        </div>

                    </div>

                </div>



                {{-- IMAGE --}}
                @if ($newsItem->image)

                    <div class="mt-8">

                        <img
                            src="{{ asset('storage/' . $newsItem->image) }}"
                            alt="{{ $newsItem->title }}"
                            class="w-full rounded-2xl object-cover max-h-[520px]"
                        >

                    </div>

                @endif



                {{-- ARTICLE --}}
                <!-- <article class="mt-8"> -->

                    {{-- Lead --}}
                    <!-- <div>

                        <p class="text-xl leading-9 text-slate-600">
                            {{ \Illuminate\Support\Str::limit(strip_tags($newsItem->content), 220) }}
                        </p>

                    </div> -->


                    {{-- Content --}}
                    <div class="mt-8 text-[18px] leading-9 text-slate-700 whitespace-pre-line">

                        {{ $newsItem->content }}

                    </div>


                    {{-- Footer --}}
                    <div class="mt-12 pt-6 border-t border-slate-200">

                        <a href="{{ route('public.news.index') }}"
                           class="inline-flex items-center text-sm font-semibold text-emerald-700 hover:text-emerald-800 transition">
                            ← Kembali ke Daftar Berita
                        </a>

                    </div>

                </article>

            </div>



            {{-- SIDEBAR --}}
            <aside class="lg:col-span-4">

                @if ($relatedNews->count())

                    <div class="sticky top-24">

                        {{-- Heading --}}
                        <div class="mb-5">

                            <h2 class="text-2xl font-bold text-slate-900">
                                Berita Lainnya
                            </h2>

                            <p class="mt-1 text-sm text-slate-500">
                                Informasi terbaru dari desa.
                            </p>

                        </div>


                        {{-- List --}}
                        <div class="space-y-5">

                            @foreach ($relatedNews as $item)

                                <a href="{{ route('public.news.show', $item->slug) }}"
                                   class="flex gap-4 group">

                                    {{-- Image --}}
                                    <div class="w-32 h-24 rounded-xl overflow-hidden bg-slate-100 shrink-0">

                                        @if ($item->image)

                                            <img
                                                src="{{ asset('storage/' . $item->image) }}"
                                                alt="{{ $item->title }}"
                                                class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                                            >

                                        @endif

                                    </div>


                                    {{-- Content --}}
                                    <div class="min-w-0">

                                        <p class="text-xs text-slate-400">
                                            {{ $item->published_at ? $item->published_at->format('d M Y') : '-' }}
                                        </p>

                                        <h3 class="mt-1 text-base font-bold leading-6 text-slate-800 group-hover:text-emerald-700 transition line-clamp-2">
                                            {{ $item->title }}
                                        </h3>

                                        <p class="mt-2 text-sm leading-6 text-slate-500 line-clamp-2">
                                            {{ \Illuminate\Support\Str::limit(strip_tags($item->content), 75) }}
                                        </p>

                                    </div>

                                </a>

                            @endforeach

                        </div>

                    </div>

                @endif

            </aside>

        </div>

    </div>

</section>

@endsection