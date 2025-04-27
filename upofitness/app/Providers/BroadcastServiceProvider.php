<?php

namespace App\Providers;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Broadcast::routes();

        /*
         * Register the callbacks for the authentication of users
         * for private and presence broadcast channels.
         */
        require base_path('routes/channels.php');
    }
}