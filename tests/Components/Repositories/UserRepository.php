<?php

declare(strict_types=1);

namespace Tests\Components\Repositories;

use App\Http\Collections\UserCollection;
use App\Http\Repositories\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserRepository implements UserRepositoryInterface
{
    private $collection;

    public function __construct($data)
    {
        $this->collection = new Collection($data);
    }

    /**
     * @return User[]
     */
    public function findAll(): Collection
    {
        return $this->collection;
    }

    public function findById(int $id): User|null
    {
        return $this->collection->filter(function ($item) use ($id) {
            return $item->id == $id;
        })->first();
    }

    public function updateById(int $id, array $data): User
    {
        $this->collection = $this->collection->keyBy('id');
        $this->collection->forget($id);
        $user = new User();
        $user->setRawAttributes($data);
        $user->id = ($id);
        $this->collection->add($user);
        return $user;
    }

    public function delete(int $id): void
    {
        $this->collection = $this->collection->keyBy('id');
        $this->collection->forget($id);
        $this->collection->sort();
    }

    public function store(array $data): User
    {
        $user = new User();
        $user->setRawAttributes($data);
        $user->id = ($this->collection->count() + 1);
        $this->collection->add($user);
        return $user;
    }


}
