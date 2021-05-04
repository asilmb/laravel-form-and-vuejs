<?php

declare(strict_types=1);

namespace App\Http\DTO\Controller\Request;


final class CreateUserRequest
{
    private string $first_name;
    private string $last_name;
    private string $email = '';
    private string $password;

    public function getFirstName(): string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): CreateUserRequest
    {
        $this->first_name = $first_name;
        return $this;
    }


    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): CreateUserRequest
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): CreateUserRequest
    {
        $this->password = bcrypt($password);
        return $this;
    }

    public function getLastName(): string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): CreateUserRequest
    {
        $this->last_name = $last_name;
        return $this;
    }


}
