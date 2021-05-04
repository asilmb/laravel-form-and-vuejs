<?php

declare(strict_types=1);

namespace App\Http\Services;

use App\Http\DTO\Controller\Request\CreateCompanyRequest;
use App\Http\DTO\Controller\Response\CompanyResponse;
use App\Models\Company;

interface CompanyServiceInterface
{
    /**
     * @return CompanyResponse[]
     */
    public function getAll(): array;

    public function getById(int $id): Company;

    public function getResponseById(int $id): CompanyResponse;

    public function create(CreateCompanyRequest $createCompanyRequest): CompanyResponse;

    public function update(int $id, CreateCompanyRequest $updateCompanyRequest): CompanyResponse;

    public function deleteById(int $id): void;
}
