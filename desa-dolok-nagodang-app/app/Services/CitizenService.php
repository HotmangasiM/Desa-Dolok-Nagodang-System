<?php

namespace App\Services;

use App\Interfaces\CitizenRepositoryInterface;

class CitizenService
{
    protected CitizenRepositoryInterface $citizenRepository;

    public function __construct(CitizenRepositoryInterface $citizenRepository)
    {
        $this->citizenRepository = $citizenRepository;
    }

    public function getAll(array $filters = [], int $perPage = 10)
    {
        return $this->citizenRepository->getAll($filters, $perPage);
    }

    public function getById(int $id)
    {
        return $this->citizenRepository->getById($id);
    }

    public function create(array $data)
    {
        return $this->citizenRepository->create($data);
    }

    public function update(int $id, array $data)
    {
        return $this->citizenRepository->update($id, $data);
    }

    public function delete(int $id)
    {
        return $this->citizenRepository->delete($id);
    }
}