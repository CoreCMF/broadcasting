<?php

namespace CoreCMF\Broadcasting;

use Illuminate\Support\ServiceProvider;
use CoreCMF\Core\App\Models\Package;
use CoreCMF\Core\App\Models\PackageConfig;

class BroadcastingServiceProvider extends ServiceProvider
{
    protected $commands = [
        \CoreCMF\Broadcasting\App\Console\InstallCommand::class,
        \CoreCMF\Broadcasting\App\Console\UninstallCommand::class,
    ];
    protected $packageName = 'Broadcasting';
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
        $this->initService();
    }
    /**
     * 初始化服务
     */
    public function initService()
    {
        //配置路由
        $this->loadRoutesFrom(__DIR__.'/Routes/api.php');
        if ($this->isInstall()) {
            $this->configRegister(new PackageConfig);//注册配置信息
        }
        //视图共享数据
        $this->viewShare();
    }
    /**
     * 检测安装情况
     */
    public function isInstall(){
        $package = new Package();
        return $package->isInstall($this->packageName);
    }
    /**
     * [configRegister 注册配置]
     * @return   [type]         [description]
     * @Author   bigrocs
     * @QQ       532388887
     * @Email    bigrocs@qq.com
     * @DateTime 2018-03-16
     */
    public function configRegister($packageConfig)
    {
        $config = $packageConfig->where('name', 'Broadcasting')->where('key', 'Socket.IO')->first();
        if ($config) {
          if ($config->value['status']) {
              $laravelEchoServer = [
                  'driver' => 'pusher',
                  'key' => $config->value['app_key'],
                  'secret' => null,
                  'app_id' => $config->value['app_id'],
                  'options' => [
                      'host' => $config->value['host'],
                      'port' => $config->value['port'],
                  ]
              ];
              config(['broadcasting.default' => 'laravel-echo-server']);
              config(['broadcasting.connections.laravel-echo-server' => $laravelEchoServer]);
          }
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
        $appUrl = config('broadcasting.connections.laravel-echo-server.options.app_url');
        $builderAsset = resolve('builderAsset')->config('broadcast', [
             'broadcaster' => 'socket.io',
             'host' => env('APP_URL').':'.$port
         ])->js(env('APP_URL').':'.$port.'/socket.io/socket.io.js');
        view()->share('resources', $builderAsset->response());//视图共享数据
    }
}
