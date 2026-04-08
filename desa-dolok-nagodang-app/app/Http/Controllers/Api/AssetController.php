<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAssetRequest;
use App\Http\Requests\UpdateAssetRequest;
use App\Services\AssetService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    public function __construct(
        protected AssetService $assetService
    ) {
    }

    public function index(Request $request): JsonResponse
    {
        $filters = [
            'search' => $request->query('search'),
            'condition' => $request->query('condition'),
            'category' => $request->query('category'),
        ];

        $perPage = (int) $request->query('per_page', 10);

        $data = $this->assetService->getAll($filters, $perPage);

        return response()->json([
            'success' => true,
            'message' => 'List inventaris berhasil diambil',
            'data' => $data,
        ]);
    }

    public function store(StoreAssetRequest $request): JsonResponse
    {
        $asset = $this->assetService->create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Data inventaris berhasil ditambahkan',
            'data' => $asset,
        ], 201);
    }

    public function show(int $asset): JsonResponse
    {
        $data = $this->assetService->getById($asset);

        return response()->json([
            'success' => true,
            'message' => 'Detail inventaris berhasil diambil',
            'data' => $data,
        ]);
    }

    public function update(UpdateAssetRequest $request, int $asset): JsonResponse
    {
        $updated = $this->assetService->update($asset, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Data inventaris berhasil diperbarui',
            'data' => $updated,
        ]);
    }

    public function destroy(int $asset): JsonResponse
    {
        $this->assetService->delete($asset);

        return response()->json([
            'success' => true,
            'message' => 'Data inventaris berhasil dihapus',
            'data' => null,
        ]);
    }
}