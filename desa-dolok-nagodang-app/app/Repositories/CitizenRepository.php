<?php

namespace App\Repositories;
use App\Interfaces\CitizenRepositoryInterface;
use App\Models\Citizen; 

class CitizenRepository implements CitizenRepositoryInterface
{
    public function getAll(array $filters = [], int $perPage = 10)
    {
        $query = Citizen::query();

        // Apply filters if provided
        if(!empty($filters['search'])) {
            $seacrh = $filters['search'];

            $query->where(function($q) use ($seacrh) {
                $q->where('full_name', 'like', "%{$seacrh}%")
                  ->orWhere('nik', 'like', "%{$seacrh}%");
            });
        }

        if(!empty($filters['gender'])){
            $query->where('gender', $filters['gender']);
        }

        if(!empty($filters['life_status'])){
            $query->where('life_status', $filters['life_status']);
        }

        return $query->orderBy('id', 'desc')->paginate($perPage);
    }

    public function getById(int $id)
    {
        return Citizen::findOrFail($id);
    }

    public function create(array $data)
    {
        return Citizen::create($data);
    }

    public function update(int $id, array $data)
    {
        $citizen = Citizen::findOrFail($id);
        $citizen->update($data);

        return $citizen->fresh();
    }

    public function delete(int $id)
    {
        $citizen = Citizen::findOrFail($id);
        $citizen->delete();
        return true;
    }
}