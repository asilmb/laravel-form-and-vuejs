<?php

declare(strict_types=1);

namespace App\Http\DTO\Controller\Response;

final class UserResponse
{
    private int $id;
    private string $first_name;
    private string $last_name;
    private string $email;
    private ?CompanyResponse $company = null;

    public function getFirstName(): string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): UserResponse
    {
        $this->first_name = $first_name;
        return $this;
    }


    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): UserResponse
    {
        $this->email = $email;
        return $this;
    }

    public function getLastName(): string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): UserResponse
    {
        $this->last_name = $last_name;
        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): UserResponse
    {
        $this->id = $id;
        return $this;
    }

    public function getCompany(): ?CompanyResponse
    {
        return $this->company;
    }

    public function setCompany(CompanyResponse $company): UserResponse
    {
        $this->company = $company;
        return $this;
    }

}
