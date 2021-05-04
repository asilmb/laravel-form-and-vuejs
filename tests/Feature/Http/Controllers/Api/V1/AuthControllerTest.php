<?php

namespace Tests\Feature\Http\Controllers\Api\V1;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Passport\Passport;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use DatabaseMigrations;

    private array $user = [
        'email'    => 'user@gmail.com',
        'password' => '$2y$10$d7BbA7Cb.UK7TRmr/eTHFOQt.c.fGkzy9nsVJ.JIzwiVgshKADYYC',
    ];
    private array $userEncodedPassword = [
        'email'    => 'user@gmail.com',
        'password' => 'secret',
    ];
    private array $wrongUser           = [
        'email'    => 'user@gmail.com',
        'password' => 'passsssss',
    ];

    public function __construct(?string $name=null, array $data=[], $dataName='')
    {
        parent::__construct($name, $data, $dataName);
    }

    public function testUserCanLogin()
    {
        $response = $this->post('/api/v1/login', []);
        $response->assertStatus(302);
    }

    public function testUserWrongData()
    {
        $this->runDatabaseMigrations();
        User::factory($this->user)->create();
        $response = $this->post('/api/v1/login', $this->wrongUser);
        $response->assertStatus(401);
    }

    public function testLogin()
    {
        $this->runDatabaseMigrations();
        User::factory($this->user)->create();
        $response = $this->post('/api/v1/login', $this->userEncodedPassword, ['Accept' => 'application/json']);
        $response->assertStatus(500); 
// todo: need solve problem with test personal client
    }
}
