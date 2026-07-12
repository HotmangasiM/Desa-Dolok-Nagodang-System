<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCitizenRequest;
use App\Http\Requests\UpdateCitizenRequest;
use App\Services\CitizenService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CitizenController extends Controller {
    protected CitizenService $citizenService;

    public function __construct(CitizenService $citizenService)
    {
        $this->citizenService = $citizenService;
    }

    public function index(Request $request): JsonResponse
    {
        $filters = [
            'search' => trim((string) $request->query('search')),
            'gender' => trim((string) $request->query('gender')),
            'life_status' => trim((string) $request->query('life_status')),
        ];

        $perPage = (int) $request->query('per_page', 10);

        $data = $this->citizenService->getAll($filters, $perPage);

        return response()->json([
            'success' => true,
            'message' => 'Daftar data penduduk berhasil diambil.',
            'data' => $data,
        ]);
    }

    public function store(StoreCitizenRequest  $request): JsonResponse
    {
        $citizen = $this->citizenService->create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Data penduduk berhasil ditambahkan.',
            'data' => $citizen,
        ]);
    }

    public function show(int $id): JsonResponse
    {
        $citizen = $this->citizenService->getById($id);

        return response()->json([
            'success' => true,
            'message' => 'Detail data penduduk berhasil diambil.',
            'data' => $citizen,
        ]);
    }

    public function update(UpdateCitizenRequest $request, int $citizen ): JsonResponse
    {
        $data = $this->citizenService->update($citizen, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Data penduduk berhasil diperbarui.',
            'data' => $data,
        ]);
    }

    public function destroy(int $citizen): JsonResponse
    {
        $this->citizenService->delete($citizen);

        return response()->json([
            'success' => true,
            'message' => 'Data penduduk berhasil dihapus.',
            'data' => null,
        ]);
    }
}
