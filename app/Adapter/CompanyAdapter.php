<?php

declare(strict_types=1);

namespace App\Adapter;

use App\Http\DTO\Controller\Response\CompanyResponse;
use App\Models\Company;

class CompanyAdapter
{
    public function __construct(
        private Company $company
    )
    {
    }

    public function createResponse(): CompanyResponse
    {
        $result = new CompanyResponse();
        $result
            ->setId($this->company->id)
            ->setName($this->company->name)
            ->setEmail($this->company->email)
            ->setWebsite($this->company->website);
        if ($this->company->logo_url) {
            $result->setLogoUrl($this->company->logo_url);
        }
        return $result;
    }
}
