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
         $this->loadRoutesFrom(__DIR__.'/Routes/api.php');
         // 加载配置
         $this->mergeConfigFrom(__DIR__.'/Config/config.php', 'broadcast');//组件配置信息
         $config = new Config();
         $config->configRegister();//注册配置信息
         //注册providers服务
         $this->registerProviders();
         //视图共享数据
         $this->viewShare();
     }
     /**
      * 注册引用服务
      */
     public function registerProviders()
     {
         $providers = config('broadcast.providers');
         foreach ($providers as $provider) {
             $this->app->register($provider);
         }
     }
     /**
      * [viewShare 视图共享数据]
      * @return [type] [description]
      */
     public function viewShare()
     {
         $appUrl = config('broadcasting.connections.laravel-echo-server.options.app_url');
         $port = config('broadcasting.connections.laravel-echo-server.options.port');
         $builderAsset = resolve('builderAsset');
         $builderAsset->js('//'.$appUrl.':'.$port.'/socket.io/socket.io.js');
         view()->share('resources', $builderAsset->response());//视图共享数据
     }
}
