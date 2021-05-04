<?php

namespace App\Http\Services;

use App\Adapter\UserAdapter;
use App\Http\DTO\Controller\Request\CreateUserRequest;
use App\Http\DTO\Controller\Response\UserResponse;
use App\Http\Repositories\UserRepositoryInterface;
use App\Models\User;
use DateTimeImmutable;
use Illuminate\Contracts\Queue\EntityNotFoundException;

class UserService implements UserServiceInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    )
    {
    }

    public function getById(int $id): User
    {
        $user = $this->userRepository->findById($id);

        if ($user === null) {
            throw new EntityNotFoundException('User', $id);
        }

        return $user;
    }

    /**
     * @inheritDoc
     */
    public function getAll(): array
    {
        $companies = $this->userRepository->findAll();
        $result    = [];
        foreach ($companies as $item) {
            $response = new UserAdapter($item);
            $result[] = $response->createResponse();
        }

        return $result;
    }

    public function getResponseById(int $id): UserResponse
    {
        $user     = $this->getById($id);
        $response = new UserAdapter($user);
        return $response->createResponse();
    }

    public function create(CreateUserRequest $createUserRequest): UserResponse
    {
        $user = $this->userRepository->store([
            'first_name' => $createUserRequest->getFirstName(),
            'last_name'  => $createUserRequest->getLastName(),
            'email'      => $createUserRequest->getEmail(),
            'password'   => $createUserRequest->getPassword(),
        ]);

        $response = new UserAdapter($user);
        return $response->createResponse();
    }

    public function update(int $id, CreateUserRequest $createUserRequest): UserResponse
    {
        $user = $this->userRepository->updateById($id, [
            'first_name' => $createUserRequest->getFirstName(),
            'last_name'  => $createUserRequest->getLastName(),
            'email'      => $createUserRequest->getEmail(),
            'password'   => $createUserRequest->getPassword(),
        ]);

        $response = new UserAdapter($user);
        return $response->createResponse();
    }

    /**
     * @param int $id
     * @throws \Exception
     */
    public function deleteById(int $id): void
    {
        $this->userRepository->updateById($id, [
            'deleted_at' => new DateTimeImmutable(),
        ]);
    }
}
