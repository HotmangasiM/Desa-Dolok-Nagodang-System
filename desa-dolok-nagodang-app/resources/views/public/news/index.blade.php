@extends('layouts.public')

@section('content')
<section class="bg-emerald-950 text-white">
    <div class="max-w-7xl mx-auto px-4 py-16">
        <p class="inline-flex rounded-full bg-white/10 px-4 py-2 text-sm text-emerald-100 border border-white/10">
            Informasi Desa
        </p>

        <h1 class="mt-6 text-4xl md:text-5xl font-bold leading-tight">
            Berita Desa
        </h1>

        <p class="mt-5 max-w-3xl text-emerald-100 leading-7">
            Kabar terbaru, kegiatan, dan informasi resmi dari Pemerintah Desa Dolok Nagodang.
        </p>
    </div>
</section>

<section class="max-w-7xl mx-auto px-4 py-16">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @forelse ($news as $item)
            <a href="{{ route('public.news.show', $item->slug) }}"
               class="group rounded-3xl bg-white border border-slate-200 shadow-sm overflow-hidden hover:shadow-lg hover:-translate-y-1 transition">
                <div class="aspect-video bg-slate-100 overflow-hidden">
                    @if ($item->image)
                        <img src="{{ asset('storage/' . $item->image) }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
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

                    <h2 class="mt-2 text-lg font-bold text-slate-800 leading-snug">
                        {{ $item->title }}
                    </h2>

                    <p class="mt-2 text-sm text-slate-500 leading-6">
                        {{ \Illuminate\Support\Str::limit(strip_tags($item->content), 120) }}
                    </p>

                    <p class="mt-4 text-sm font-semibold text-emerald-700">
                        Baca selengkapnya →
                    </p>
                </div>
            </a>
        @empty
            <div class="md:col-span-3 rounded-3xl bg-white border border-slate-200 p-10 text-center text-slate-500">
                Belum ada berita yang dipublikasikan.
            </div>
        @endforelse
    </div>

    <div class="mt-10">
        {{ $news->links() }}
    </div>
</section>
@endsection