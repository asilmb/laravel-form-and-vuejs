<?php

declare(strict_types=1);

namespace Tests\Components\Repositories;

use App\Http\Repositories\CompanyRepositoryInterface;
use App\Models\Company;
use Illuminate\Database\Eloquent\Collection;

class CompanyRepository implements CompanyRepositoryInterface
{
    private $collection;

    public function __construct($data)
    {
        $this->collection = new Collection($data);
    }

    /**
     * @return Company[]
     */
    public function findAll(): Collection
    {
        return $this->collection;
    }

    public function findById(int $id): Company|null
    {
        return $this->collection->filter(function ($item) use ($id) {
            return $item->id == $id;
        })->first();
    }

    public function updateById(int $id, array $data): Company
    {
        $this->collection = $this->collection->keyBy('id');
        $this->collection->forget($id);
        $company = new Company();
        $company->setRawAttributes($data);
        $company->id = ($id);
        $this->collection->add($company);
        return $company;
    }

    public function delete(int $id): void
    {
        $this->collection = $this->collection->keyBy('id');
        $this->collection->forget($id);
        $this->collection->sort();
    }

    public function store(array $data): Company
    {
        $company = new Company();
        $company->setRawAttributes($data);
        $company->id = ($this->collection->count() + 1);
        $this->collection->add($company);
        return $company;
    }


}
