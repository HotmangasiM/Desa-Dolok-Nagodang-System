@extends('layouts.public')

@section('content')
<section class="bg-emerald-950 text-white">
    <div class="max-w-4xl mx-auto px-4 py-16">
        <a href="{{ route('public.news.index') }}"
           class="inline-flex text-sm text-emerald-100 hover:text-white mb-5">
            ← Kembali ke Berita
        </a>

        <p class="inline-flex rounded-full bg-white/10 px-4 py-2 text-sm text-emerald-100 border border-white/10">
            Berita Desa
        </p>

        <h1 class="mt-6 text-4xl md:text-5xl font-bold leading-tight">
            {{ $newsItem->title }}
        </h1>

        <p class="mt-4 text-emerald-100">
            Dipublikasikan pada
            {{ $newsItem->published_at ? $newsItem->published_at->format('d M Y') : '-' }}
        </p>
    </div>
</section>

<section class="max-w-4xl mx-auto px-4 py-12">
    @if ($newsItem->image)
        <img src="{{ asset('storage/' . $newsItem->image) }}"
             class="w-full rounded-3xl border border-slate-200 shadow-sm object-cover"
             alt="{{ $newsItem->title }}">
    @endif

    <article class="mt-8 rounded-3xl bg-white border border-slate-200 p-8 shadow-sm">
        <div class="text-slate-700 leading-8 whitespace-pre-line">
            {{ $newsItem->content }}
        </div>
    </article>
</section>

@if ($relatedNews->count())
<section class="bg-slate-100/80 py-16">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex items-end justify-between gap-4">
            <div>
                <p class="text-sm font-semibold text-emerald-700">Berita Lainnya</p>
                <h2 class="mt-1 text-3xl font-bold text-slate-800">
                    Informasi Terkait
                </h2>
            </div>

            <a href="{{ route('public.news.index') }}"
               class="text-sm font-semibold text-emerald-700 hover:text-emerald-800">
                Lihat semua →
            </a>
        </div>

        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach ($relatedNews as $item)
                <a href="{{ route('public.news.show', $item->slug) }}"
                   class="rounded-3xl bg-white border border-slate-200 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-1 transition">
                    <div class="aspect-video bg-slate-100">
                        @if ($item->image)
                            <img src="{{ asset('storage/' . $item->image) }}"
                                 class="w-full h-full object-cover"
                                 alt="{{ $item->title }}">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-5xl">
                                📰
                            </div>
                        @endif
                    </div>

                    <div class="p-5">
                        <p class="text-xs text-slate-500">
                            {{ $item->published_at ? $item->published_at->format('d M Y') : '-' }}
                        </p>
                        <h3 class="mt-2 font-bold text-slate-800">
                            {{ $item->title }}
                        </h3>
                        <p class="mt-2 text-sm text-slate-500 leading-6">
                            {{ \Illuminate\Support\Str::limit(strip_tags($item->content), 100) }}
                        </p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection