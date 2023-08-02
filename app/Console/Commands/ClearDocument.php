<?php

namespace App\Console\Commands;

use App\Models\Document;
use Illuminate\Console\Command;

class ClearDocument extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'document:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear Documents Maid';

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
        Document::truncate();
    }
}
