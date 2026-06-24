<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOfficialRequest;
use App\Http\Requests\UpdateOfficialRequest;
use App\Services\OfficialService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OfficialController extends Controller
{
    public function __construct(
        protected OfficialService $officialService
    ) {
    }

    public function index(Request $request): JsonResponse
    {
        $filters = [
            'search' => trim((string) $request->query('search')),
            'position' => trim((string) $request->query('position')),
        ];

        $perPage = (int) $request->query('per_page', 10);

        $data = $this->officialService->getAll($filters, $perPage);

        return response()->json([
            'success' => true,
            'message' => 'Daftar data aparat desa berhasil diambil.',
            'data' => $data,
        ]);
    }

    public function store(StoreOfficialRequest $request): JsonResponse
    {
        $official = $this->officialService->create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Data aparat desa berhasil ditambahkan.',
            'data' => $official,
        ], 201);
    }

    public function show(int $official): JsonResponse
    {
        $data = $this->officialService->getById($official);

        return response()->json([
            'success' => true,
            'message' => 'Detail data aparat desa berhasil diambil.',
            'data' => $data,
        ]);
    }

    public function update(UpdateOfficialRequest $request, int $official): JsonResponse
    {
        $updated = $this->officialService->update($official, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Data aparat desa berhasil diperbarui.',
            'data' => $updated,
        ]);
    }

    public function destroy(int $official): JsonResponse
    {
        $this->officialService->delete($official);

        return response()->json([
            'success' => true,
            'message' => 'Data aparat desa berhasil dihapus.',
            'data' => null,
        ]);
    }
}
