<?php

namespace App\Providers;

use App\Repositories\Contracts\ProfileRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\ProfileRepository;
use App\Repositories\UserRepository;
use App\Services\Contracts\ProfileServiceInterface;
use App\Services\Contracts\UserServiceInterface;
use App\Services\ProfileService;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public array $bindings = [
        UserRepositoryInterface::class => UserRepository::class,
        UserServiceInterface::class => UserService::class,
        ProfileRepositoryInterface::class => ProfileRepository::class,
        ProfileServiceInterface::class => ProfileService::class,
    ];

    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        //
    }
}
