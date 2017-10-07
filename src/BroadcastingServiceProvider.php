<?php

namespace CoreCMF\Broadcasting;

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
        //迁移文件配置
        $this->loadMigrationsFrom(__DIR__.'/Databases/migrations');
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
          $this->initService();
    }
    /**
     * 初始化服务
     */
     public function initService()
     {
         //配置路由
         $this->loadRoutesFrom(__DIR__.'/Routes/web.php');
         $this->loadRoutesFrom(__DIR__.'/Routes/api.php');
         // 加载配置
         $this->mergeConfigFrom(__DIR__.'/Config/config.php', 'broadcasting');//组件配置信息

         //注册providers服务
         $this->registerProviders();
     }
     /**
      * 注册引用服务
      */
     public function registerProviders()
     {
         $providers = config('broadcasting.providers');
         foreach ($providers as $provider) {
             $this->app->register($provider);
         }
     }
}
