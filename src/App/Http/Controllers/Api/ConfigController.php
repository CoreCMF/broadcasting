<?php

namespace CoreCMF\Broadcasting\App\Http\Controllers\Api;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use CoreCMF\Core\App\Models\PackageConfig;

class ConfigController extends Controller
{
    private $packageConfig;

    public function __construct(PackageConfig $packageConfigPro){
       $this->packageConfig = $packageConfigPro;
    }
    public function index(Request $request)
    {
        $configs = $this->packageConfig->where('name', 'Broadcasting')->where('key', 'Socket.IO')->first();

        $builderForm = resolve('builderForm')
                ->item(['name' => 'id', 'type' => 'hidden'])
                ->item(['name' => 'status',         'type' => 'switch',   'label' => '开关'])
                ->item([
                    'name' => 'app_id',
                    'type' => 'text',
                    'label' => 'AppId',
                    'placeholder' => 'AppId',
                    'loadAttribute'=>['value.app_id']
                 ])
                ->item([
                    'name' => 'app_key',
                    'type' => 'text',
                    'label' => 'AppKey',
                    'placeholder' => 'AppKey',
                    'loadAttribute'=>['value.app_key']
                ])
                ->item([
                    'name' => 'host',
                    'type' => 'text',
                    'label' => '主机地址',
                    'placeholder' => '主机地址:默认localhost',
                    'loadAttribute'=>['value.host']
                ])
                ->item([
                    'name' => 'port',
                    'type' => 'text',
                    'label' => '端口',
                    'placeholder' => '主机端口',
                    'loadAttribute'=>['value.port']
                ])
                ->config('labelWidth','120px')
                ->apiUrl('submit',route('api.admin.broadcasting.config.update'))
                ->itemData($configs);
        return resolve('builderHtml')->title('广播配置')->item($builderForm)->config('layout',['xs' => 24, 'sm' => 20, 'md' => 18, 'lg' => 16])->response();
    }
    /**
     * [update 配置更新]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function update(Request $request)
    {
        if ($this->packageConfig->where('id', '=', $request->id)->update([
            'value' => json_encode([
              'app_id' => $request->app_id,
              'app_key' => $request->app_key,
              'host' => $request->host,
              'port'  => $request->port
            ])
          ])) {
          $message = [
                      'title'     => '保存成功',
                      'message'   => '广播设置保存成功!',
                      'type'      => 'success',
                  ];
        }else{
          $message = [
                      'title'     => '保存失败',
                      'message'   => '广播设置保存失败!',
                      'type'      => 'error',
                  ];
        }
        return resolve('builderHtml')->message($message)->response();
    }
}
