<?php

namespace App\Providers;

use App\Models\facility_request;
use App\Policies\FacilityRequestPolicy;
use Illuminate\Auth\Access\Gate;
use Illuminate\Support\Facades\Gate as FacadesGate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        FacadesGate::policy(facility_request::class, FacilityRequestPolicy::class);
    }
}
