<?php

namespace CoreCMF\Broadcasting\App\Listeners;

/**
 * [BroadcastingEventSubscriber 支付扩展包订阅器]
 */
class BroadcastingEventSubscriber
{

    /**
     * [onAdminMain 后台前端路由注册 侧栏菜单注册]
     * @param  [type] $event [description]
     * @return [type]        [description]
     */
    public function onConfig($event)
    {
      $table = $event->table;
      if ($table->event == 'adminPackage') {
          $table->data->transform(function ($item, $key) {
              if ($item->name == 'Broadcasting') {
                  $item->rightButton = [
                      ['title'=>'广播配置','apiUrl'=> route('api.admin.broadcasting.config'),'type'=>'info', 'icon'=>'fa fa-edit']
                  ];
              }
              return $item;
          });
      }
    }
    /**
     * 为订阅者注册监听器.
     *
     * @param  Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'CoreCMF\Core\Support\Events\BuilderTable',
            'CoreCMF\Broadcasting\App\Listeners\BroadcastingEventSubscriber@onConfig'
        );
    }

}
