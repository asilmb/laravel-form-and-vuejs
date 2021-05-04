<?php


namespace App\Http\Services;


use App\Models\User;

interface UserCompanyServiceInterface
{
    public function appointToCompany(int $userId, int $companyId): User;
}
