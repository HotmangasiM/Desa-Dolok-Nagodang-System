<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\View\View;

class PublicNewsController extends Controller
{
    public function index(): View
    {
        $news = News::where('status', 'published')
            ->latest('published_at')
            ->latest('id')
            ->paginate(9);

        return view('public.news.index', [
            'title' => 'Berita Desa',
            'news' => $news,
        ]);
    }

    public function show(string $slug): View
    {
        $newsItem = News::where('status', 'published')
            ->where('slug', $slug)
            ->firstOrFail();

        $relatedNews = News::where('status', 'published')
            ->where('id', '!=', $newsItem->id)
            ->latest('published_at')
            ->latest('id')
            ->take(3)
            ->get();

        return view('public.news.show', [
            'title' => $newsItem->title,
            'newsItem' => $newsItem,
            'relatedNews' => $relatedNews,
        ]);
    }
}