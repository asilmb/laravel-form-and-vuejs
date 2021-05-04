<?php

declare(strict_types=1);

namespace App\Providers;

use App\Http\Repositories\CompanyRepository;
use App\Http\Repositories\UserRepository;
use App\Http\Services\CompanyService;
use App\Http\Services\CompanyServiceInterface;
use App\Http\Services\MessagingService;
use App\Http\Services\MessagingServiceInterface;
use App\Http\Services\UserCompanyService;
use App\Http\Services\UserCompanyServiceInterface;
use App\Http\Services\UserService;
use App\Http\Services\UserServiceInterface;
use Illuminate\Support\ServiceProvider;
use L5Swagger\L5SwaggerServiceProvider;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(L5SwaggerServiceProvider::class);

        $this->app->bind(CompanyServiceInterface::class, function () {
            return new CompanyService(
                $this->app->get(CompanyRepository::class)
            );
        });
        $this->app->bind(UserServiceInterface::class, function () {
            return new UserService(
                $this->app->get(UserRepository::class)
            );
        });

        $this->app->bind(UserCompanyServiceInterface::class, function () {
            return new UserCompanyService(
                $this->app->get(UserRepository::class),
                $this->app->get(CompanyRepository::class)
            );
        });
        $this->app->bind(SerializerInterface::class, function () {
            return new Serializer([new ObjectNormalizer()], [$this->app->get(JsonEncoder::class)]);
        });

        $this->app->bind(MessagingServiceInterface::class, function () {
            return new MessagingService();
        });
    }
}
