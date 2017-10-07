<?php

namespace CoreCMF\Broadcasting\App\Listeners;

/**
 * [BroadcastingEventSubscriber 支付扩展包订阅器]
 */
class BroadcastingEventSubscriber
{

    /**
     * [onBuilderTablePackage 后台模型table渲染处理]
     * @param  [type] $event [description]
     * @return [type]        [description]
     */
    public function onBuilderTablePackage($event)
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
            'CoreCMF\Broadcasting\App\Listeners\BroadcastingEventSubscriber@onBuilderTablePackage'
        );
    }

}
