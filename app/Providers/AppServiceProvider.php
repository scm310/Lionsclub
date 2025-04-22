<?php

namespace App\Providers;
   use App\Models\BannerClick;
use Illuminate\Support\Facades\View;
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
    View::composer('layouts.admin', function ($view) {
        $clickCount = BannerClick::sum('click_count');
        $view->with('bannerClickTotal', $clickCount);
    });
}

}
