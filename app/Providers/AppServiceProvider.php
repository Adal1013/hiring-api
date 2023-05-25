<?php

namespace App\Providers;

use App\Http\Repositories\Auth\AuthRepository;
use App\Http\Repositories\Auth\AuthRepositoryImpl;
use App\Http\Repositories\Candidates\CandidateRepository;
use App\Http\Repositories\Candidates\CandidateRepositoryDecorator;
use App\Http\Repositories\Candidates\CandidateRepositoryImpl;
use App\Http\Services\Auth\AuthService;
use App\Http\Services\Auth\AuthServiceImpl;
use App\Http\Services\Candidates\CandidateService;
use App\Http\Services\Candidates\CandidateServiceImpl;
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
        $this->app->bind(CandidateRepository::class, function () {
            return new CandidateRepositoryDecorator(new CandidateRepositoryImpl());
        });

        // Services
        $this->app->bind(AuthService::class, AuthServiceImpl::class);
        $this->app->bind(CandidateService::class, CandidateServiceImpl::class);
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
