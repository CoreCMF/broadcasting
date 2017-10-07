<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BroadcastingConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('broadcasting_configs', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('app_id',60)          ->comment('AppId')->nullable();
            $table->string('app_key',60)         ->comment('AppKey')->nullable();
            $table->string('host',80)            ->comment('主机地址')->nullable();
            $table->string('port',160)           ->comment('端口')->nullable();
            $table->string('app_url',160)        ->comment('前端主机访问地址')->nullable();
            $table->boolean('status')            ->comment('开关状态')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('broadcasting_configs');
    }
}
