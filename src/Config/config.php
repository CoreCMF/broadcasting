<?php

return [
    'name' => 'Broadcasting',
    'title' => '广播插件',
    'description' => '广播插件',
    'author' => 'BigRocs',
    'version' => 'v1.3.1',
    'serviceProvider' => CoreCMF\Broadcasting\BroadcastingServiceProvider::class,
    'install' => 'corecmf:broadcasting:install',//安装artisan命令
    'uninstall' => 'corecmf:broadcasting:uninstall',//卸载artisan命令
    'providers' => [
      App\Providers\BroadcastServiceProvider::class,//广播认证服务
      CoreCMF\Broadcasting\Providers\EventServiceProvider::class,//事件服务
    ],
];
