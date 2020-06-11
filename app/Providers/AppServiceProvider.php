<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use App\Helpers\Helper;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        View::composer('*',function($view){
            View::share('view',str_replace('.','-',$view -> getName()));
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(){
        
    }
}
