<?php

namespace Tests\Unit;

use App\Http\DTO\Controller\Request\CreateCompanyRequest;
use App\Http\DTO\Controller\Response\CompanyResponse;
use App\Http\Services\CompanyService;
use App\Http\Services\CompanyServiceInterface;
use App\Models\Company;
use Tests\Components\Repositories\CompanyRepository;
use Tests\TestCase;

class CompanyServiceTest extends TestCase
{

    private CompanyServiceInterface $companyService;
    private $srcData;
    private $firstCompany = [
        'id'       => 1,
        'name'     => 'company1',
        'email'    => 'company1@company1.com',
        'logo_url' => 'company1-logo',
        'website'  => 'company1-website',
    ];

    private $secondCompany = [
        'id'       => 2,
        'name'     => 'company2',
        'email'    => 'company2@company2.com',
        'logo_url' => 'company2-logo',
        'website'  => 'company2-website',
    ];
    private $newCompany    = [
        'id'       => 3,
        'name'     => 'company3',
        'email'    => 'company3@company2.com',
        'logo_url' => 'company3-logo',
        'website'  => 'company3-website',
    ];

    private function getService(): CompanyServiceInterface
    {
        $this->srcData = [
            Company::factory()->make($this->firstCompany),
            Company::factory()->make($this->secondCompany),
        ];
        $repository    = new CompanyRepository($this->srcData);
        return new CompanyService($repository);
    }

    public function testGetAll()
    {
        $companies = $this->getService()->getAll();
        $this->assertIsArray($companies);
        $this->assertInstanceOf(CompanyResponse::class, $companies[0]);
        $this->assertCount(2, $companies);
    }

    public function testGetById()
    {
        $company = $this->getService()->getById(2);
        $this->assertInstanceOf(Company::class, $company);
        $this->assertEquals($company, Company::factory()->make($this->secondCompany));
    }

    public function testDeleteById()
    {
        $service   = $this->getService();
        $companies = $service->getAll();
        $this->assertCount(2, $companies);
        $service->deleteById(2);
        $newCompanies = $service->getAll();
        $this->assertCount(1, $newCompanies);
    }

    public function testUpdateById()
    {
        $service        = $this->getService();
        $createExpected = $this->getCreateExpected($this->newCompany);
        $service->update(2, $createExpected);
        $newCompanies = $service->getAll();
        $this->assertCount(2, $newCompanies);
        $newCompany = $service->getById(2);
        $this->assertEquals($newCompany->name, $createExpected->getName());

    }

    public function testCreate()
    {
        $service        = $this->getService();
        $createExpected = $this->getCreateExpected($this->newCompany);

        $companies = $service->getAll();
        $this->assertCount(2, $companies);
        $company = $service->create($createExpected);
        $this->assertInstanceOf(CompanyResponse::class, $company);

        $updatedCompanies = $service->getAll();
        $this->assertCount(3, $updatedCompanies);
        $newCompany = $service->getById(3);
        $this->assertEquals($newCompany->name, $createExpected->getName());
    }

    private function getCreateExpected($data): CreateCompanyRequest
    {
        $request = new CreateCompanyRequest();
        $request->setName($data['name']);
        $request->setWebsite($data['website']);
        $request->setEmail($data['email']);
        return $request;
    }
}
