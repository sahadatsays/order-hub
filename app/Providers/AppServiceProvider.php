<?php

namespace App\Providers;

use App\Models\Notification;
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
        View::composer('components.app.topbar', function ($view) {
            $notifications = collect();
            $unreadCount = 0;

            if (auth()->check() && auth()->user()->tenant_id) {
                $notifications = Notification::where('tenant_id', auth()->user()->tenant_id)
                    ->where('channel', 'database')
                    ->where('recipient_type', 'user')
                    ->where('recipient_id', auth()->id())
                    ->orderByDesc('created_at')
                    ->limit(5)
                    ->get();

                $unreadCount = $notifications->whereNull('read_at')->count();

                // If we have fewer than 5 items and all are read, the real unread count
                // could be 0. But if all 5 are unread, there might be more—do a count query.
                if ($unreadCount >= 5) {
                    $unreadCount = Notification::where('tenant_id', auth()->user()->tenant_id)
                        ->where('channel', 'database')
                        ->where('recipient_type', 'user')
                        ->where('recipient_id', auth()->id())
                        ->whereNull('read_at')
                        ->count();
                }
            }

            $view->with(compact('notifications', 'unreadCount'));
        });
    }
}
