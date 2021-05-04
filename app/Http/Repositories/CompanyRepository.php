<?php

declare(strict_types=1);

namespace App\Http\Repositories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Collection;

class CompanyRepository implements CompanyRepositoryInterface
{
    /**
     * @return Company[]
     */
    public function findAll(): Collection
    {
        return Company::all();
    }

    public function findById(int $id): Company|null
    {
        return Company::find($id);
    }

    public function delete(int $id): void
    {
        Company::where('id', $id)->delete();
    }

    public function updateById(int $id, array $data): Company
    {
        $company = $this->findById($id);
        $company->update($data);
        return $company;
    }

    public function store(array $data): Company
    {
        $company = new Company();
        $company->setRawAttributes($data);
        $company->save();
        return $company;
    }
}
