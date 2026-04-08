<?php

namespace App\Services;

use App\Interfaces\AssetRepositoryInterface;

class AssetService
{
    public function __construct(
        protected AssetRepositoryInterface $assetRepository
    ) {
    }

    public function getAll(array $filters = [], int $perPage = 10)
    {
        return $this->assetRepository->getAll($filters, $perPage);
    }

    public function getById(int $id)
    {
        return $this->assetRepository->getById($id);
    }

    public function create(array $data)
    {
        return $this->assetRepository->create($data);
    }

    public function update(int $id, array $data)
    {
        return $this->assetRepository->update($id, $data);
    }

    public function delete(int $id)
    {
        return $this->assetRepository->delete($id);
    }
}