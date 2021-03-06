<?php

namespace App\Providers;

use App\View\Components\ProjectTable;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use NascentAfrica\Jetstrap\JetstrapFacade;

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
        JetstrapFacade::useAdminLte3();

        Paginator::useBootstrap();
        Schema::defaultStringLength(125);

        Blade::component('livewire.project-table', ProjectTable::class);

        date_default_timezone_set('Asia/Singapore');
    }
}
