<?php

declare(strict_types=1);

namespace App\Http\DTO\Controller\Response;

final class CompanyResponse
{
    private int $id;
    private string $name;
    private string $email;
    private string $logo_url = '';
    private string $website;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): CompanyResponse
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): CompanyResponse
    {
        $this->name = $name;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): CompanyResponse
    {
        $this->email = $email;
        return $this;
    }

    public function getLogoUrl(): string
    {
        return $this->logo_url;
    }

    public function setLogoUrl(string $logo_url): CompanyResponse
    {
        $this->logo_url = $logo_url;
        return $this;
    }

    public function getWebsite(): string
    {
        return $this->website;
    }

    public function setWebsite(string $website): CompanyResponse
    {
        $this->website = $website;
        return $this;
    }
}
