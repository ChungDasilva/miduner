<?php

namespace App\Providers;

use App\Models\UserProfile;
use App\Repositories\User\UserInterface;
use App\Repositories\User\UserRepository;
use App\Repositories\UserProfile\UserProfileInterface;
use App\Repositories\UserProfile\UserProfileRepository;
use Main\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function boot()
    {

    }

    public function register()
    {
        $this->app->bind(UserInterface::class, UserRepository::class);
        $this->app->bind(UserProfileInterface::class, UserProfileRepository::class);
    }
}