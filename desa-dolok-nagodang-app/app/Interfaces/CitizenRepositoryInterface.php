<?php

namespace App\Interfaces;

interface CitizenRepositoryInterface
{
    public function getAll(array $filters = [], int $perPage = 10);
    public function getById(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
}