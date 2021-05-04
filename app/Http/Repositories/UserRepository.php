<?php


namespace App\Http\Repositories;


use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserRepository implements UserRepositoryInterface
{
    /**
     * @param int $id
     * @return User
     */
    public function findById(int $id): User
    {
        return User::with('company')->find($id);
    }


    public function findAll(): Collection
    {
        return User::with('company')->get();
    }

    public function updateById(int $id, array $data): User
    {
        $user = $this->findById($id);
        $user->update($data);
        return $user;
    }

    public function delete(int $id): void
    {
        $user = $this->findById($id);
        $user->delete();
    }

    public function store(array $data): User
    {
        $user = new User();
        $user->setRawAttributes($data);
        $user->save();
        return $user;
    }
}
