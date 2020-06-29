<?php

namespace App\Providers;

// use Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

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
        //
        Blade::if('role', function ($roles) {
            $user = auth()->user();
            if($user){
                return $user->hasAnyRole($roles);
            } 
            return false;
        });
    }
}
