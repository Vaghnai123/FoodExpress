<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Models\Setting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;


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
        if (env('APP_ENV') === 'production') {
            URL::forceScheme('https');
        }
        
        Schema::defaultStringLength(191);
        Paginator::useBootstrap();

        try {
            if (Schema::hasTable('settings')) {
                $keys = ['pusher_app_id', 'pusher_cluster', 'pusher_key', 'pusher_secret'];
                $pusherConf = Setting::whereIn('key', $keys)->pluck('value', 'key');

                if(isset($pusherConf['pusher_key'])) {
                    config(['broadcasting.connections.pusher.key' => $pusherConf['pusher_key']]);
                    config(['broadcasting.connections.pusher.secret' => $pusherConf['pusher_secret']]);
                    config(['broadcasting.connections.pusher.app_id' => $pusherConf['pusher_app_id']]);
                    config(['broadcasting.connections.pusher.options.cluster' => $pusherConf['pusher_cluster']]);
                }
            }
        } catch (\Exception $e) {
        }

        Gate::before(function ($user, $ability) {
            return $user->hasRole('Super Admin') ? true : null;
        });
    }
}
