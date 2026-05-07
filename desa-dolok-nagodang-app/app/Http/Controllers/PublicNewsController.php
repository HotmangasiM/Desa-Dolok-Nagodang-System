<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\View\View;

class PublicNewsController extends Controller
{
    public function index(): View
    {
        $search = request('search');

        $news = News::where('status', 'published')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
                });
            })
            ->latest('published_at')
            ->latest('id')
            ->paginate(9)
            ->withQueryString();

        return view('public.news.index', [
            'title' => 'Berita Desa',
            'news' => $news,
            'search' => $search,
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