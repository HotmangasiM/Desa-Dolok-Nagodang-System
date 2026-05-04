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

        return view('public.news.show', [
            'title' => $newsItem->title,
            'newsItem' => $newsItem,
        ]);
    }
}