<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNewsRequest;
use App\Http\Requests\UpdateNewsRequest;
use App\Models\News;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Str;

class AdminNewsPageController extends Controller
{
    public function index(Request $request): View
    {
        $filters = [
            'search' => $request->query('search'),
            'status' => $request->query('status'),
        ];

        $news = News::query()
            ->when($filters['search'], function ($query) use ($filters) {
                $query->where('title', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('content', 'like', '%' . $filters['search'] . '%');
            })
            ->when($filters['status'], function ($query) use ($filters) {
                $query->where('status', $filters['status']);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $allNews = News::count();
        $draftNews = News::where('status', 'draft')->count();
        $publishedNews = News::where('status', 'published')->count();

        return view('admin.news.index', [
            'title' => 'Admin Desa - Berita Desa',
            'pageTitle' => 'Berita Desa',
            'pageDescription' => 'Kelola informasi dan berita yang ditampilkan di sistem desa.',
            'breadcrumbs' => [
                ['label' => 'Berita Desa', 'url' => null],
            ],

            'news' => $news,
            'filters' => $filters,

            // statistik untuk card di blade
            'allNews' => $allNews,
            'draftNews' => $draftNews,
            'publishedNews' => $publishedNews,
        ]);
    }

    public function create(): View
    {
        return view('admin.news.create', [
            'title' => 'Admin Desa - Tambah Berita',
            'pageTitle' => 'Tambah Berita',
            'pageDescription' => 'Tambahkan berita baru untuk dipublikasikan.',
            'breadcrumbs' => [
                ['label' => 'Berita Desa', 'url' => route('admin.news.index')],
                ['label' => 'Tambah Berita', 'url' => null],
            ],
        ]);
    }

    public function store(StoreNewsRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $baseSlug = Str::slug($data['title']);
        $slug = $baseSlug;
        $counter = 1;

        while (News::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        $data['slug'] = $slug;

        if (auth()->check()) {
            $data['author_id'] = auth()->id();
        }

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('news', 'public');
            $data['image'] = $path;
        }

        News::create($data);

        return redirect()
            ->route('admin.news.index')
            ->with('success', 'Berita berhasil ditambahkan.');
    }

    public function edit(News $news): View
    {
        return view('admin.news.edit', [
            'title' => 'Admin Desa - Edit Berita',
            'pageTitle' => 'Edit Berita',
            'pageDescription' => 'Perbarui berita yang sudah tersimpan.',
            'breadcrumbs' => [
                ['label' => 'Berita Desa', 'url' => route('admin.news.index')],
                ['label' => 'Edit Berita', 'url' => null],
            ],
            'news' => $news,
        ]);
    }

    public function update(UpdateNewsRequest $request, News $news): RedirectResponse
    {
        $data = $request->validated();

        $baseSlug = Str::slug($data['title']);
        $slug = $baseSlug;
        $counter = 1;

        while (News::where('slug', $slug)->where('id', '!=', $news->id)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        $data['slug'] = $slug;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('news', 'public');
            $data['image'] = $path;
        }

        $news->update($data);

        return redirect()
            ->route('admin.news.index')
            ->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(News $news): RedirectResponse
    {
        $news->delete();

        return redirect()
            ->route('admin.news.index')
            ->with('success', 'Berita berhasil dihapus.');
    }
}