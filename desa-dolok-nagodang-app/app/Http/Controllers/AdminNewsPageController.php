<?php

namespace  App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNewsRequest;
use App\Http\Requests\UpdateNewsRequest;
use App\Models\News;
use App\Services\NewsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminNewsPageController extends Controller 
{
    public function __construct(
        protected NewsService $newsService
    ){

    }

    public function index(Request $request): View
    {
        $filters = [
            'search' => $request->query('search'),
            'status' => $request->query('status'),
        ];

        $perPage = (int) $request->query('per_page', 10);

        $news = $this->newsService->getAll($filters, $perPage);

        $allNews = News::query()->count();
        $draftNews = News::query()->where('status', 'draft')->count();
        $publishedNews = News::query()->where('status', 'published')->count();

        return view('admin.news.index', [
            'title' => 'Admin Desa - Berita Desa',
            'pageTitle' => 'Manajemen Berita Desa',
            'pageDescription' => 'Kelola berita dan informasi desa untuk dipublikasikan.',
            'news' => $news,
            'allNews' => $allNews,
            'draftNews' => $draftNews,
            'publishedNews' => $publishedNews,
            'filters' => $filters,
        ]);
    }

    public function create(): View
    {
        return view('admin.news.create', [
            'title' => 'Admin Desa - Tambah Berita',
            'pageTitle' => 'Tambah Berita Desa',
            'pageDescription' => 'Tambahkan berita baru untuk publikasi data.',
        ]);
    }

    public function store(StoreNewsRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['author_id'] = 1;

        $this->newsService->create($data);

        return redirect()
            ->route('admin.news.index')
            ->with('success', 'Berita berhasil ditambahkan');
    }

    public function edit(int $news): View
    {
        $newsData = $this->newsService->getById($news);

        return view('admin.news.edit', [
            'title' => 'Admin Desa - Edit Berita',
            'pageTitle' => 'Edit Berita Desa',
            'pageDescription' => 'Perbaharui konten berita desa',
            'newsItem' => $newsData,
        ]);
    }

    public function update(UpdateNewsRequest $request, int $news): RedirectResponse
    {
        $this->newsService->update($news, $request->validated());

        return redirect()
            ->route('admin.news.index')
            ->with('success', 'Berita berhasil diperbaharui.');
    }

    public function destroy(int $news): RedirectResponse
    {
        $this->newsService->delete($news);

        return redirect()
            ->route('admin.news.index')
            ->with('success', 'Berita berhasil dihapus');
    }
}
