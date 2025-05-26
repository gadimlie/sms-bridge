<?php

namespace Gadimlie\SmsBridge\Providers;

use Gadimlie\SmsBridge\SmsBridgeManager;
use Illuminate\Support\ServiceProvider;

class SmsBridgeServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../../config/sms-bridge.php', 'sms-bridge');

        $this->app->singleton(SmsBridgeManager::class, function () {
            return new SmsBridgeManager();
        });
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../../config/sms-bridge.php' => config_path('sms-bridge.php'),
        ], 'config');
    }
}
