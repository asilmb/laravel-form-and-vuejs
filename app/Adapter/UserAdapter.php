<?php

declare(strict_types=1);

namespace App\Adapter;

use App\Http\DTO\Controller\Response\UserResponse;
use App\Models\User;

class UserAdapter
{
    public function __construct(
        private User $user
    )
    {
    }

    public function createResponse(): UserResponse
    {
        $result = new UserResponse();
        $result
            ->setId($this->user->id)
            ->setFirstName($this->user->first_name)
            ->setLastName($this->user->last_name)
            ->setEmail($this->user->email);
        $this->createCompanyResponse($result);
        return $result;
    }

    private function createCompanyResponse(UserResponse $result)
    {
        if ($this->user->company) {
            $companyAdapter = new CompanyAdapter($this->user->company);
            $result->setCompany($companyAdapter->createResponse());
        }
    }
}
