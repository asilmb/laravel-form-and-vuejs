<?php

namespace App\Http\Services;

use App\Http\Repositories\CompanyRepositoryInterface;
use App\Http\Repositories\UserRepositoryInterface;
use Illuminate\Contracts\Queue\EntityNotFoundException;
use App\Models\User;

class UserCompanyService implements UserCompanyServiceInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private CompanyRepositoryInterface $companyRepository
    )
    {
    }

    public function appointToCompany(int $userId, int $companyId): User
    {
        $company = $this->companyRepository->findById($companyId);
        if (empty($company) === true) {
            throw new EntityNotFoundException('Company', $companyId);
        }
        return $this->userRepository->updateById($userId, [
            'company_id' => $company->id,
        ]);
    }
}
