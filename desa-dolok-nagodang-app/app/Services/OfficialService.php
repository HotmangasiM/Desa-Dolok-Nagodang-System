<?php

namespace App\Services;

use App\Interfaces\OfficialRepositoryInterface;

class OfficialService
{
    public function __construct(
        protected OfficialRepositoryInterface $officialRepository
    ) {
    }

    public function getAll(array $filters = [], int $perPage = 10)
    {
        return $this->officialRepository->getAll($filters, $perPage);
    }

    public function getById(int $id)
    {
        return $this->officialRepository->getById($id);
    }

    public function create(array $data)
    {
        return $this->officialRepository->create($data);
    }

    public function update(int $id, array $data)
    {
        return $this->officialRepository->update($id, $data);
    }

    public function delete(int $id)
    {
        return $this->officialRepository->delete($id);
    }
}