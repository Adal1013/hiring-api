<?php

namespace App\Providers;

use App\Http\Repositories\Auth\AuthRepository;
use App\Http\Repositories\Auth\AuthRepositoryImpl;
use App\Http\Repositories\Candidates\CandidateRepository;
use App\Http\Repositories\Candidates\CandidateRepositoryImpl;
use App\Http\Services\Auth\AuthService;
use App\Http\Services\Auth\AuthServiceImpl;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Repositories
        $this->app->bind(AuthRepository::class, AuthRepositoryImpl::class);
        $this->app->bind(CandidateRepository::class, CandidateRepositoryImpl::class);

        // Services
        $this->app->bind(AuthService::class, AuthServiceImpl::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
