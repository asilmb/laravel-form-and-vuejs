<?php

declare(strict_types=1);

namespace App\Http\DTO\Controller\Request;

use Illuminate\Http\UploadedFile;

final class CreateCompanyRequest
{
    private string $name;
    private string $email = '';
    private UploadedFile $logo;
    private string $logo_url = '';
    private string $website  = '';

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): CreateCompanyRequest
    {
        $this->name = $name;
        return $this;
    }


    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): CreateCompanyRequest
    {
        $this->email = $email;
        return $this;
    }

    public function getLogoUrl(): string
    {
        return $this->logo_url;
    }

    public function setLogo(UploadedFile $logo): CreateCompanyRequest
    {
        $this->logo = $logo;
        return $this;
    }

    public function getWebsite(): string
    {
        return $this->website;
    }

    public function setWebsite(string $website): CreateCompanyRequest
    {
        $this->website = $website;
        return $this;
    }

    public function logoIsExist(): bool
    {
        return !empty($this->logo);
    }

    public function getLogo(): UploadedFile
    {
        return $this->logo;
    }


}
