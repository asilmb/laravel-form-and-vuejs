<?php

declare(strict_types=1);

namespace App\Http\Services;

use App\Adapter\CompanyAdapter;
use App\Http\DTO\Controller\Request\CreateCompanyRequest;
use App\Http\DTO\Controller\Response\CompanyResponse;
use App\Http\Repositories\CompanyRepositoryInterface;
use App\Models\Company;
use DateTimeImmutable;
use Illuminate\Contracts\Queue\EntityNotFoundException;

class CompanyService implements CompanyServiceInterface
{

    public function __construct(
        private CompanyRepositoryInterface $companyRepository
    )
    {
    }

    public function getById(int $id): Company
    {
        $company = $this->companyRepository->findById($id);

        if ($company === null) {
            throw new EntityNotFoundException('Company', $id);
        }

        return $company;
    }

    /**
     * @inheritDoc
     */
    public function getAll(): array
    {
        $companies = $this->companyRepository->findAll();
        $result    = [];
        foreach ($companies as $item) {
            $response = new CompanyAdapter($item);
            $result[] = $response->createResponse();
        }

        return $result;
    }

    public function getResponseById(int $id): CompanyResponse
    {
        $company  = $this->getById($id);
        $response = new CompanyAdapter($company);
        return $response->createResponse();
    }

    public function create(CreateCompanyRequest $createCompanyRequest): CompanyResponse
    {
        $data     = [
            'name'       => $createCompanyRequest->getName(),
            'email'      => $createCompanyRequest->getEmail(),
            'website'    => $createCompanyRequest->getWebsite(),
            'created_at' => new DateTimeImmutable(),
            'updated_at' => new DateTimeImmutable(),
        ];
        $company  = $this->companyRepository->store( $this->addLogo($createCompanyRequest, $data));
        $response = new CompanyAdapter($company);
        return $response->createResponse();
    }

    public function update(int $id, CreateCompanyRequest $updateCompanyRequest): CompanyResponse
    {
        $data     = [
            'name'       => $updateCompanyRequest->getName(),
            'email'      => $updateCompanyRequest->getEmail(),
            'website'    => $updateCompanyRequest->getWebsite(),
            'updated_at' => new DateTimeImmutable(),
        ];
        $company  = $this->companyRepository->updateById($id, $this->addLogo($updateCompanyRequest, $data));
        $response = new CompanyAdapter($company);
        return $response->createResponse();
    }

    /**
     * @param int $id
     * @throws \Exception
     */
    public function deleteById(int $id): void
    {
        $this->companyRepository->delete($id);
    }

    private function addLogo(CreateCompanyRequest $companyRequest, $data)
    {
        if ($companyRequest->logoIsExist()) {
            $fileName = $companyRequest->getLogo()->hashName();
            $companyRequest->getLogo()->storePublicly(    'public/images', []); 
// todo: strange behaivior
            $data['logo_url'] = $fileName;
        }
        return $data;
    }

}
