<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;

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
        // Define gates for role-based access
        Gate::define('admin', function ($user) {
            return $user->isAdmin();
        });
        
        // Share cart count with navbar component
        View::composer('components.navbar', function ($view) {
            $cartCount = 0;
            
            if (Auth::check()) {
                // Get the authenticated user's cart count
                $cartCount = Cart::where('user_id', Auth::id())->sum('quantity');
            }
            
            $view->with('cartCount', $cartCount);
        });
    }
}
