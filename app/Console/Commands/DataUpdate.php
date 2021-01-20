<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\UpdateDataService;

class DataUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:dataUpdate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates mySQL database from json file on gitHub';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $service = (new UpdateDataService)->updateTables();
    }
}
