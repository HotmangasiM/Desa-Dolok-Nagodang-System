<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLetterRequest;
use App\Http\Requests\UpdateLetterRequest;
use App\Services\LetterService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LetterController extends Controller
{
    public function __construct(
        protected LetterService $letterService
    ) {
    }

    public function index(Request $request): JsonResponse
    {
        $filters = [
            'search' => trim((string) $request->query('search')),
            'status' => trim((string) $request->query('status')),
            'letter_type_id' => trim((string) $request->query('letter_type_id')),
        ];

        $perPage = (int) $request->query('per_page', 10);

        $data = $this->letterService->getAll($filters, $perPage);

        return response()->json([
            'success' => true,
            'message' => 'Daftar surat berhasil diambil.',
            'data' => $data,
        ]);
    }

    public function store(StoreLetterRequest $request): JsonResponse
    {
        $letter = $this->letterService->create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Surat berhasil ditambahkan.',
            'data' => $letter,
        ], 201);
    }

    public function show(int $letter): JsonResponse
    {
        $data = $this->letterService->getById($letter);

        return response()->json([
            'success' => true,
            'message' => 'Detail surat berhasil diambil.',
            'data' => $data,
        ]);
    }

    public function update(UpdateLetterRequest $request, int $letter): JsonResponse
    {
        $updated = $this->letterService->update($letter, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Surat berhasil diperbarui.',
            'data' => $updated,
        ]);
    }

    public function destroy(int $letter): JsonResponse
    {
        $this->letterService->delete($letter);

        return response()->json([
            'success' => true,
            'message' => 'Surat berhasil dihapus.',
            'data' => null,
        ]);
    }
}
