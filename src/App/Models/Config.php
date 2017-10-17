<?php

namespace CoreCMF\Broadcasting\App\Models;

use Schema;
use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    public $table = 'broadcasting_configs';

    protected $fillable = [];

    public function getStatusAttribute($value)
    {
        return (boolean)$value;
    }
    /**
     * [configRegister 注册配置信息]
     * @return [type] [description]
     */
    public function configRegister()
    {
        if (Schema::hasTable('broadcasting_configs')) {
            $config = $this->where('status', true)->first();
            if ($config) {
                $laravelEchoServer = [
                    'driver' => 'pusher',
                    'key' => $config->app_key,
                    'secret' => null,
                    'app_id' => $config->app_id,
                    'options' => [
                        'host' => $config->host,
                        'port' => $config->port,
                        'app_url' => $config->app_url
                    ]
                ];
                config(['broadcasting.default' => 'laravel-echo-server']);
                config(['broadcasting.connections.laravel-echo-server' => $laravelEchoServer]);
            }
        }
    }
}
