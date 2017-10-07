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
        $this->builderForm = resolve('builderForm')->item(['name' => 'status',         'type' => 'switch',   'label' => '开关']);
        $this->builderForm->item(['name' => 'gateway', 'type' => 'hidden']);
        $this->publicGatewayForm($gateway,$configs);//根据不同网关添加不同 form item
        $this->publicForm();//添加公共form item
        $this->builderForm->apiUrl('submit',route('api.admin.Broadcasting.config.update'))->itemData($configs);
        return resolve('builderHtml')->title('支付配置')->item($this->builderForm)->config('layout',['xs' => 24, 'sm' => 20, 'md' => 18, 'lg' => 16])->response();
    }
    /**
     * [update 配置更新]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function update(Request $request)
    {
        if ($this->configModel->where('gateway', '=', $request->gateway)->update($request->all())) {
          $message = [
                      'title'     => '保存成功',
                      'message'   => '系统设置保存成功!',
                      'type'      => 'success',
                  ];
        }
        return resolve('builderHtml')->message($message)->response();
    }
}
