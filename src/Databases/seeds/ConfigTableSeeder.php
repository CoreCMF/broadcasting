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
        DB::table('broadcasting_configs')->insert([
          'host' => 'localhost',
          'port'  => 6001
        ]);
    }
}
