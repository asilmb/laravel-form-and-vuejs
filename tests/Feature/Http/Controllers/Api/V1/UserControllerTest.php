<?php

namespace Tests\Feature\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\UserController;
use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class UserControllerTest extends TestCase
{

    use DatabaseMigrations;
    use WithoutMiddleware;

    private $user         = [
        'email'    => 'user@gmail.com',
        'password' => 'passsssss',
    ];
    private $userPassword = ['password' => 'passsssss'];
    private $baseUri      = '/api/v1/user';
    private $headers      = [
        'Accept'       => 'application/json',
        'Content-Type' => 'application/x-www-form-urlencoded',
    ];

    private function auth()
    {
        $this->runDatabaseMigrations();
        $user = User::factory($this->user)->create();
        $this->actingAs($user, 'api');
        return $user;
    }

    public function testIndex()
    {
        $this->auth();
        $response = $this->get($this->baseUri, $this->headers);
        $response->assertStatus(200);

    }

    public function testDelete()
    {
        $this->auth();
        $user     = User::factory()->create();
        $response = $this->delete($this->baseUri."/{$user->id}", $this->headers);
        $response->assertStatus(200);
    }

    public function testGetById()
    {
        $this->auth();
        $user     = User::factory()->create();
        $response = $this->get($this->baseUri."/{$user->id}", $this->headers);
        $response->assertStatus(200);
    }

    public function testCreate()
    {
        $this->auth();
        $user = User::factory()->make($this->userPassword);

        $response = $this->post($this->baseUri, array_merge($user->toArray(), $this->userPassword), $this->headers);
        $response->assertStatus(201);
    }

    public function testUpdate()
    {
        $this->auth();
        $user     = User::factory()->create();
        $newUser  = User::factory()->make();
        $response = $this->put(
            $this->baseUri."/{$user->id}",
            array_merge($newUser->toArray(), $this->userPassword),
            $this->headers);
        $response->assertStatus(200);
    }

    public function testAppointCompanyById()
    {
        $this->withoutMiddleware();
        $this->auth();
        $appointmentCompany = Company::factory()->create();
        $response           = $this->put(
            $this->baseUri."/company/{$appointmentCompany->id}",
            $this->headers);
        $response->assertStatus(200);
    }

}
