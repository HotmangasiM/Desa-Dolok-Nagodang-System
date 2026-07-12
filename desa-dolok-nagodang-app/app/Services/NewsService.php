<?php

namespace App\Services;

use App\Interfaces\NewsRepositoryInterface;
use Illuminate\Support\Str;

class NewsService
{
    public function __construct(
        protected NewsRepositoryInterface $newsRepository
    ) {

    }

    public function getAll(array $filters = [], int $perPage = 10)
    {
        return $this->newsRepository->getAll($filters, $perPage);
    }

    public function getById(int $id)
    {
        return $this->newsRepository->getById($id);
    }

    public function create(array $data)
    {
        $data['slug'] = Str::slug($data['title']);

        if (($data['status'] ?? 'draft') === 'published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        return $this->newsRepository->create($data);
    }

    public function update(int $id, array $data)
    {
        $data['slug'] = Str::slug($data['title']);

        if(($data['status'] ?? 'draft') === 'published' && empty($data['published_at'])){
            $data['published_at)'] = now();
        }

        return $this->newsRepository->update($id, $data);
    }

    public function delete(int $id)
    {
        return $this->newsRepository->delete($id);
    }
}