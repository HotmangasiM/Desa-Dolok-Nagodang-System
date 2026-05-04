@extends('layouts.public')

@section('content')
<section class="bg-emerald-900 text-white">
    <div class="max-w-7xl mx-auto px-4 py-16">
        <h1 class="text-4xl font-bold">Berita Desa</h1>
        <p class="mt-3 text-emerald-100">
            Informasi dan kabar terbaru dari Desa Dolok Nagodang.
        </p>
    </div>
</section>

<section class="max-w-7xl mx-auto px-4 py-12">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @forelse ($news as $item)
            <a href="{{ route('public.news.show', $item->slug) }}"
               class="rounded-3xl bg-white border border-slate-200 shadow-sm overflow-hidden hover:shadow-md transition">
                <div class="aspect-video bg-slate-100">
                    @if ($item->image)
                        <img src="{{ asset('storage/' . $item->image) }}"
                             class="w-full h-full object-cover"
                             alt="{{ $item->title }}">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-4xl">
                            📰
                        </div>
                    @endif
                </div>

                <div class="p-5">
                    <p class="text-xs text-slate-500">
                        {{ $item->published_at ? $item->published_at->format('d M Y') : '-' }}
                    </p>

                    <h2 class="mt-2 text-lg font-bold text-slate-800">
                        {{ $item->title }}
                    </h2>

                    <p class="mt-2 text-sm text-slate-500 leading-6">
                        {{ \Illuminate\Support\Str::limit(strip_tags($item->content), 120) }}
                    </p>
                </div>
            </a>
        @empty
            <div class="md:col-span-3 rounded-2xl bg-white border border-slate-200 p-10 text-center text-slate-500">
                Belum ada berita yang dipublikasikan.
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $news->links() }}
    </div>
</section>
@endsection