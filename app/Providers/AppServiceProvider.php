<?php

namespace App\Providers;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
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
        Schema::defaultStringLength(191);

        View::composer('layouts.app_header', function ($view) {
            if (Auth::check()) {
                $notifications = Notification::query()
                    ->where('user_id', Auth::id())
                    ->latest()
                    ->take(5)
                    ->get();

                $unreadCount = Notification::query()
                    ->where('user_id', Auth::id())
                    ->where('is_read', false)
                    ->count();

                $view->with('notifications', $notifications)
                    ->with('unreadNotificationsCount', $unreadCount);

                return;
            }

            $view->with('notifications', collect())
                ->with('unreadNotificationsCount', 0);
        });
    }
}
