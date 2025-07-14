<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;


class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
    //    view::composer('components.sidebar', function($view){
    //     $users = User::where('role','user')->get();
    //     $view->with('users', $users);
    //    });
       
    //    View::composer('components.sidebar', function($view){
    //     $admin = User::where('role','admin')->get();
    //     $view->with('admin', $admin);
    //    });
    // Untuk sidebar
    View::composer('*', function ($view) {
        $admin = User::where('role', 'admin')->first();
        $users = User::where('role', 'user')->get();

        $view->with('admin', $admin);
        $view->with('users', $users);
    });
    }
}