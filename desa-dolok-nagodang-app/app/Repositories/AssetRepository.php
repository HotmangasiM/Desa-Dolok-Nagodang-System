<?php

namespace App\Repositories;

use App\Interfaces\AssetRepositoryInterface;
use App\Models\Asset;

class AssetRepository implements AssetRepositoryInterface
{
    public function getAll(array $filters = [], int $perPage = 10)
    {
        $query = Asset::query();

        if (!empty($filters['search'])) {
            $search = $filters['search'];

            $query->where(function ($q) use ($search) {
                $q->where('item_name', 'like', "%{$search}%")
                  ->orWhere('item_code', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        if (!empty($filters['condition'])) {
            $query->where('condition', $filters['condition']);
        }

        if (!empty($filters['category'])) {
            $query->where('category', $filters['category']);
        }

        return $query->orderByDesc('id')->paginate($perPage);
    }

    public function getById(int $id)
    {
        return Asset::findOrFail($id);
    }

    public function create(array $data)
    {
        return Asset::create($data);
    }

    public function update(int $id, array $data)
    {
        $asset = Asset::findOrFail($id);
        $asset->update($data);

        return $asset->fresh();
    }

    public function delete(int $id)
    {
        $asset = Asset::findOrFail($id);
        $asset->delete();

        return true;
    }
}