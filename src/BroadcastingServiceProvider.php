<?php

namespace CoreCMF\Broadcasting;

use Redis;
use Route;
use Illuminate\Support\ServiceProvider;
use CoreCMF\Broadcasting\App\Models\Config;

class BroadcastingServiceProvider extends ServiceProvider
{
    protected $commands = [
        \CoreCMF\Broadcasting\App\Console\InstallCommand::class,
        \CoreCMF\Broadcasting\App\Console\UninstallCommand::class,
    ];
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        //加载artisan commands
        $this->commands($this->commands);
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
    }
    /**
     * 初始化服务
     */
    public function initService()
    {
        //注册providers服务
        $this->registerProviders();
    }
    /**
     * 注册引用服务
     */
    public function registerProviders()
    {
    }
}
