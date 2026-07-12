<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNewsRequest;
use App\Http\Requests\UpdateNewsRequest;
use App\Services\NewsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NewsController extends Controller 
{
    public function __construct(
        protected NewsService $newsService
    ){

    }

    public function index(Request $request): JsonResponse
    {
        $filters = [
            'search' => trim((string) $request->query('search')),
            'status' => trim((string) $request->query('status')),
        ];

        $perPage = (int) $request->query('per_page', 10);

        $data = $this->newsService->getAll($filters, $perPage);

        return response()->json([
            'success' => true,
            'message' => 'Daftar berita berhasil diambil.',
            'data' => $data,
        ]);
    }

    public function store(StoreNewsRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['author_id'] = 1;

        $news = $this->newsService->create($data);

        return response()->json([
            'success' => true,
            'message' => 'Berita berhasil ditambahkan.',
            'data' => $news,
        ], 201);
    }

    public function show(int $news): JsonResponse
    {
        $data = $this->newsService->getById($news);

        return response()->json([
            'success' => true,
            'message' => 'Detail berita berhasil diambil.',
            'data' => $data,
        ]);
    }

    public function update(UpdateNewsRequest $request, int $news): JsonResponse
    {
        $data = $request->validated();
        $updated = $this->newsService->update($news, $data);

        return response()->json([
            'success' => true,
            'message' => 'Berita berhasil diperbarui.',
            'data' => $updated,
        ]);
    }
    
    public function destroy(int $news): JsonResponse 
    {
        $this->newsService->delete($news);

        return response()->json([
            'success' => true,
            'message' => 'Berita berhasil dihapus.',
            'data' => null,
        ]);
    }
}
