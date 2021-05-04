<?php

namespace Tests\Unit;

use App\Http\DTO\Controller\Request\CreateCompanyRequest;
use App\Http\DTO\Controller\Request\CreateUserRequest;
use App\Http\DTO\Controller\Response\CompanyResponse;
use App\Http\DTO\Controller\Response\UserResponse;
use App\Http\Services\UserService;
use App\Http\Services\UserServiceInterface;
use App\Models\Company;
use App\Models\User;
use Tests\Components\Repositories\UserRepository;
use Tests\TestCase;

class UserServiceTest extends TestCase
{

    private $srcData;

    private $firstUser = [
        'id'             => 1,
        'first_name'     => 'asd1111',
        'last_name'      => 'asd111',
        'email'          => 'user111@asdfs.com',
        'password'       => 'user111',
        'remember_token' => 'FbWCBw0UQ7',

    ];

    private $secondUser = [
        'id'             => 2,
        'first_name'     => 'asd222',
        'last_name'      => 'asd222',
        'email'          => 'user22@asdfs.com',
        'password'       => 'user2222',
        'remember_token' => 'FbWCBw0UQ7',

    ];
    private $newUser = [
        'id'             => 3,
        'first_name'     => 'as3333',
        'last_name'      => 'asd3333',
        'email'          => 'user333@asdfs.com',
        'password'       => 'user333',
        'remember_token' => 'FbWCBw0UQ7',

    ];

    private function getService(): UserServiceInterface
    {
        $this->srcData = [
            User::factory()->make($this->firstUser),
            User::factory()->make($this->secondUser),
        ];
        $repository    = new UserRepository($this->srcData);
        return new UserService($repository);
    }

    public function testGetAll()
    {
        $users = $this->getService()->getAll();
        $this->assertIsArray($users);
        $this->assertInstanceOf(UserResponse::class, $users[0]);
        $this->assertCount(2, $users);
    }

    public function testGetById()
    {
        $user = $this->getService()->getById(2);
        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($user, User::factory()->make($this->secondUser));
    }

    public function testDeleteById()
    {
        $service = $this->getService();
        $service->deleteById(2);
        $deletedUser = $service->getById(2);
        $this->assertTrue(!empty($deletedUser->deleted_at));
    }

    public function testUpdateById()
    {
        $service        = $this->getService();
        $createExpected = $this->getCreateExpected($this->newUser);
        $service->update(2, $createExpected);
        $newUsers = $service->getAll();
        $this->assertCount(2, $newUsers);
        $newUser = $service->getById(2);
        $this->assertEquals($createExpected->getLastName(), $newUser->last_name);
    }

    public function testCreate()
    {
        $service        = $this->getService();
        $createExpected = $this->getCreateExpected($this->newUser);

        $users = $service->getAll();
        $this->assertCount(2, $users);
        $user = $service->create($createExpected);
        $this->assertInstanceOf(UserResponse::class, $user);

        $updatedUsers = $service->getAll();
        $this->assertCount(3, $updatedUsers);
        $newUser = $service->getById(3);
        $this->assertEquals($createExpected->getLastName(), $newUser->last_name);
    }

    private function getCreateExpected($data): CreateUserRequest
    {
        $request = new CreateUserRequest();
        $request->setFirstName($data['first_name']);
        $request->setLastName($data['last_name']);
        $request->setEmail($data['email']);
        $request->setPassword($data['password']);
        return $request;
    }
}
