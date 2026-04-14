<?php

namespace App\Services;

use App\Interfaces\LetterRepositoryInterface;

class LetterService
{
    public function __construct(
        protected LetterRepositoryInterface $letterRepository
    ) {
    }

    public function getAll(array $filters = [], int $perPage = 10)
    {
        return $this->letterRepository->getAll($filters, $perPage);
    }

    public function getById(int $id)
    {
        return $this->letterRepository->getById($id);
    }

    public function create(array $data)
    {
        if (empty($data['submission_date'])) {
            $data['submission_date'] = now()->toDateString();
        }

        if (empty($data['status'])) {
            $data['status'] = 'submitted';
        }

        return $this->letterRepository->create($data);
    }

    public function update(int $id, array $data)
    {
        if (($data['status'] ?? null) === 'approved' && empty($data['approved_date'])) {
            $data['approved_date'] = now()->toDateString();
        }

        return $this->letterRepository->update($id, $data);
    }

    public function delete(int $id)
    {
        return $this->letterRepository->delete($id);
    }
}