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
            $search = $filters['search'];

            $query->where(function ($q) use ($search) {
                $q->where('letter_number', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhereHas('citizen', function ($citizenQuery) use ($search) {
                      $citizenQuery->where('full_name', 'like', "%{$search}%")
                                   ->orWhere('nik', 'like', "%{$search}%");
                  });
            });
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['letter_type_id'])) {
            $query->where('letter_type_id', $filters['letter_type_id']);
        }

        return $query->orderByDesc('id')->paginate($perPage);
    }

    public function getById(int $id)
    {
        return Letter::with(['letterType', 'citizen'])->findOrFail($id);
    }

    public function create(array $data)
    {
        return Letter::create($data);
    }

    public function update(int $id, array $data)
    {
        $letter = Letter::findOrFail($id);
        $letter->update($data);

        return $letter->fresh(['letterType', 'citizen']);
    }

    public function delete(int $id)
    {
        $letter = Letter::findOrFail($id);
        $letter->delete();

        return true;
    }
}