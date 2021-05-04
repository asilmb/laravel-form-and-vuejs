<?php

namespace Tests\Feature\Http\Controllers\Api\V1;

use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CompanyControllerTest extends TestCase
{
    use DatabaseMigrations;

    private $user    = [
        'email'    => 'user@gmail.com',
        'password' => 'passsssss',
    ];
    private $baseUri = '/api/v1/company';
    private $headers = [
        'Accept'       => 'application/json',
        'Content-Type' => 'application/x-www-form-urlencoded',
    ];

    private function auth()
    {
        $this->runDatabaseMigrations();
        $user = User::factory($this->user)->create();

        $this->actingAs($user, 'api');
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
        $company  = Company::factory()->create();
        $response = $this->delete($this->baseUri."/{$company->id}", $this->headers);
        $response->assertStatus(200);
    }

    public function testGetById()
    {
        $this->auth();
        $company  = Company::factory()->create();
        $response = $this->get($this->baseUri."/{$company->id}", $this->headers);
        $response->assertStatus(200);
    }

    public function testCreate()
    {
        $this->auth();
        $company  = Company::factory()->make();
        $response = $this->post($this->baseUri, $company->toArray(), $this->headers);
        $response->assertStatus(201);
    }

    public function testUpdate()
    {
        $this->auth();
        $company = Company::factory()->create();
        $company->setAttribute('name', 'asdf');
        $response = $this->put($this->baseUri."/{$company->id}", $company->toArray(), $this->headers);
        $response->assertStatus(200);
    }
}
