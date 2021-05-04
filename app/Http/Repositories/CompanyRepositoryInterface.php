<?php


namespace App\Http\Repositories;


use App\Models\Company;
use Illuminate\Database\Eloquent\Collection;

interface CompanyRepositoryInterface
{
    /**
     * @return Company[]
     */
    public function findAll(): Collection;

    public function findById(int $id): Company|null;

    public function updateById(int $id, array $data): Company;

    public function delete(int $id): void;

    public function store(array $data): Company;
}
