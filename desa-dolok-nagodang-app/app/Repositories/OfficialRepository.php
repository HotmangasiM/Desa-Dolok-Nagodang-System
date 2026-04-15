<?php

namespace App\Repositories;

use App\Interfaces\OfficialRepositoryInterface;
use App\Models\Official;

class OfficialRepository implements OfficialRepositoryInterface
{
    public function getAll(array $filters = [], int $perPage = 10)
    {
        $query = Official::query();

        if (!empty($filters['search'])) {
            $search = $filters['search'];

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('position', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if (!empty($filters['position'])) {
            $query->where('position', 'like', "%{$filters['position']}%");
        }

        return $query->orderByDesc('id')->paginate($perPage);
    }

    public function getById(int $id)
    {
        return Official::findOrFail($id);
    }

    public function create(array $data)
    {
        return Official::create($data);
    }

    public function update(int $id, array $data)
    {
        $official = Official::findOrFail($id);
        $official->update($data);

        return $official->fresh();
    }

    public function delete(int $id)
    {
        $official = Official::findOrFail($id);
        $official->delete();

        return true;
    }
}