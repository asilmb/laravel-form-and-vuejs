<?php


namespace App\Http\Repositories;


use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    /**
     * @return User[]
     */
    public function findAll(): Collection;

    public function findById(int $id): User|null;

    public function updateById(int $id, array $data): User;

    public function delete(int $id): void;

    public function store(array $data): User;
}
