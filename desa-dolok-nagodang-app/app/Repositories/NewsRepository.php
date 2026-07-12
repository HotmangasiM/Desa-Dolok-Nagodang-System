<?php

namespace App\Repositories;

use App\Interfaces\NewsRepositoryInterface;
use App\Models\News;

class NewsRepository implements NewsRepositoryInterface
{
    public function getAll(array $filters = [], int $perPage = 10)
    {
        $query = News::query();

        if(!empty($filters['search'])){
            $search = $filters['search'];

            $query->where(function ($q) use ($search){
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        if(!empty($filters['status'])){
            $query->where('status', $filters['status']);
        }

        return $query->orderByDesc('id')->paginate($perPage);
    }

    public function getById(int $id)
    {
        return News::findOrFail($id);
    }

    public function create(array $data)
    {
        return News::create($data);
    }

    public function update(int $id, array $data)
    {
        $news = News::findOrFail($id);
        $news->update($data);

        return $news->fresh();
    }

    public function delete(int $id)
    {
        $news = News::findOrFail($id);
        $news->delete();

        return true;
    }
}