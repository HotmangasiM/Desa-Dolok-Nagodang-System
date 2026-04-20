<?php

namespace App\Repositories;

use App\Interfaces\LetterRepositoryInterface;
use App\Models\Letter;

class LetterRepository implements LetterRepositoryInterface
{
    public function getAll(array $filters = [], int $perPage = 10)
    {
        $query = Letter::with(['letterType', 'citizen']);

        if (!empty($filters['search'])) {
            $search = trim($filters['search']);

            $query->where(function ($q) use ($search) {
                $q->where('letter_number', 'like', "%{$search}%")
                    ->orWhere('subject', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhereHas('citizen', function ($citizenQuery) use ($search) {
                        $citizenQuery->where('full_name', 'like', "%{$search}%")
                            ->orWhere('nik', 'like', "%{$search}%");
                    });
            });
        }

        if (!empty($filters['status'])) {
            $statusMap = [
                'submitted' => 'SUBMITTED',
                'processed' => 'PROCESSING',
                'completed' => 'COMPLETED',
            ];

            $status = $statusMap[$filters['status']] ?? $filters['status'];
            $query->where('status', $status);
        }

        if (!empty($filters['letter_type_id'])) {
            $query->where('letter_type_id', $filters['letter_type_id']);
        }

        if (!empty($filters['submission_date_from'])) {
            $query->whereDate('submission_date', '>=', $filters['submission_date_from']);
        }

        if (!empty($filters['submission_date_to'])) {
            $query->whereDate('submission_date', '<=', $filters['submission_date_to']);
        }

        return $query->orderByDesc('submission_date')
            ->orderByDesc('id')
            ->paginate($perPage);
    }

    public function getById(int $id)
    {
        return Letter::with(['letterType', 'citizen', 'creator', 'approver'])->findOrFail($id);
    }

    public function create(array $data)
    {
        return Letter::create($data);
    }

    public function update(int $id, array $data)
    {
        $letter = Letter::findOrFail($id);
        $letter->update($data);

        return $letter->fresh(['letterType', 'citizen', 'creator', 'approver']);
    }

    public function delete(int $id)
    {
        $letter = Letter::findOrFail($id);
        return $letter->delete();
    }
}