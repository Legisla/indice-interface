<?php

namespace App\Providers;

use App\Models\State;
use App\Models\Party;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Helpers\Format;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::share('states', State::all());
        View::share('parties', Party::all());
        View::share('partiesNotEmpty', Party::getActiveParties());
        View::share('statsLinks', Format::getStatsLinks());
    }
}