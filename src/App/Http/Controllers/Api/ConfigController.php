<?php

namespace CoreCMF\Broadcasting\App\Http\Controllers\Api;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use CoreCMF\Broadcasting\App\Models\Config;

class ConfigController extends Controller
{
    private $configModel;

    public function __construct(Config $configPro){
       $this->configModel = $configPro;
    }
    public function index(Request $request)
    {
        $configs = $this->configModel->first();
        $builderForm = resolve('builderForm')
                ->item(['name' => 'id', 'type' => 'hidden'])
                ->item(['name' => 'status',         'type' => 'switch',   'label' => '开关'])
                ->item(['name' => 'app_id',  'type' => 'text',    'label' => 'AppId',       'placeholder' => 'AppId'])
                ->item(['name' => 'app_key', 'type' => 'text',     'label' => 'AppKey',     'placeholder' => 'AppKey'])
                ->item(['name' => 'host',    'type' => 'text',     'label' => '主机地址',    'placeholder' => '主机地址:默认localhost'])
                ->item(['name' => 'port',    'type' => 'text',     'label' => '端口',        'placeholder' => '主机端口'])
                ->item(['name' => 'app_url', 'type' => 'text',     'label' => '前端访问地址',  'placeholder' => '前端访问地址、不要加http类前缀'])
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
        if ($this->configModel->where('id', '=', $request->id)->update($request->all())) {
          $message = [
                      'title'     => '保存成功',
                      'message'   => '广播设置保存成功!',
                      'type'      => 'success',
                  ];
        }
        return resolve('builderHtml')->message($message)->response();
    }
}
