<?php


namespace App\Http\Services;


use App\Http\DTO\Controller\Request\CreateUserRequest;
use App\Http\DTO\Controller\Response\UserResponse;
use App\Models\User;

interface UserServiceInterface
{
    public function getById(int $id): User;

    public function getAll(): array;

    public function getResponseById(int $id): UserResponse;

    public function create(CreateUserRequest $createUserRequest): UserResponse;

    public function update(int $id, CreateUserRequest $createUserRequest): UserResponse;

    public function deleteById(int $id): void;

}
