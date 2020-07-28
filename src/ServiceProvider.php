<?php
namespace Zijinghua\Zwechat;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                realpath(__DIR__.'/../publishable/config/wechat.php') => config_path('wechat.php')
            ], 'config');
        }
    }
}