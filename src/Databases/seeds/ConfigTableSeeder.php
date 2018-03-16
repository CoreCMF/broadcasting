<?php
namespace CoreCMF\Broadcasting\Databases\seeds;

use DB;
use Illuminate\Database\Seeder;

class ConfigTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('core_package_configs')->insert([
          'name' => 'Broadcasting',
          'key' => 'Socket.IO',
          'value' => json_encode([
             'status' => false,
             'app_id' => null,
             'app_key' => null,
             'host' => 'localhost',
             'port'  => 6001
          ])
        ]);
    }
}
