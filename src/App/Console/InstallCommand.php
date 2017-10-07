<?php

namespace CoreCMF\Broadcasting\App\Console;

use Illuminate\Console\Command;

use CoreCMF\Core\Support\Commands\Install;

class InstallCommand extends Command
{
    /**
     *  install class.
     * @var object
     */
    protected $install;
    /**
     * The name and signature of the console command.
     *
     * @var string
     * @translator laravelacademy.org
     */
    protected $signature = 'corecmf:broadcasting:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Broadcasting packages install';

    public function __construct(Install $install)
    {
        parent::__construct();
        $this->install = $install;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info($this->install->migrate());
        $this->info($this->install->seed(\CoreCMF\Broadcasting\Databases\seeds\ConfigTableSeeder::class));
    }
}
