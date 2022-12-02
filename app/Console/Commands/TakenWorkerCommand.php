<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TakenWorkerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'worker:taken';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Insert To Table taken';

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
        return 0;
    }
}
