@extends('layouts.public')

@section('content')
<section class="bg-emerald-900 text-white">
    <div class="max-w-4xl mx-auto px-4 py-16">
        <a href="{{ route('public.news.index') }}"
           class="inline-flex text-sm text-emerald-100 hover:text-white mb-5">
            ← Kembali ke Berita
        </a>

        <h1 class="text-4xl font-bold leading-tight">
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
        <div class="prose max-w-none text-slate-700 leading-7">
            {!! nl2br(e($newsItem->content)) !!}
        </div>
    </article>
</section>
@endsection