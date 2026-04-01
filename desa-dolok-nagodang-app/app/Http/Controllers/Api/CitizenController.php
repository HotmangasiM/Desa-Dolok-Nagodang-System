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
            'search' => $request->query('search'),
            'gender' => $request->query('gender'),
            'life_status' => $request->query('life_status'),
        ];

        $perPage = (int) $request->query('per_page', 10);

        $data = $this->citizenService->getAll($filters, $perPage);

        return response()->json([
            'success' => true,
            'message' => 'List data penduduk berhasil diambil',
            'data' => $data,
        ]);
    }

    public function store(StoreCitizenRequest  $request): JsonResponse
    {
        $citizen = $this->citizenService->create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Data penduduk berhasil ditambahkan',
            'data' => $citizen,
        ]);
    }

    public function show(int $id): JsonResponse
    {
        $citizen = $this->citizenService->getById($id);

        return response()->json([
            'success' => true,
            'message' => 'Detail data penduduk berhasil diambil',
            'data' => $citizen,
        ]);
    }

    public function update(UpdateCitizenRequest $request, int $id ): JsonResponse
    {
        $citizen = $this->citizenService->update($id, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Data penduduk berhasil diperbaharui',
            'data' => $citizen,
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->citizenService->delete($id);

        return response()->json([
            'success' => true,
            'message' => 'Detail data penduduk berhasil dihapus',
            'data' => null,
        ]);
    }
}