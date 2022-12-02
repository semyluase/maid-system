<?php

namespace App\Console\Commands;

use App\Models\Master\Maid\Maid;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class CommandResetBookmark extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookmark:reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset Worker which bookmark time is up';

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
        $dataMaid = Maid::where('is_active', true)
            ->where('is_bookmark', true)
            ->where('bookmark_max_at', '<', Carbon::now('Asia/Jakarta')->isoFormat('YYYY-MM-DD HH:mm:ss'))
            ->get();

        if ($dataMaid) {
            foreach ($dataMaid as $key => $value) {
                if (Maid::find($value->id)->update([
                    'is_bookmark'   =>  false,
                    'user_bookmark' =>  null,
                    'bookmark_max_at'   =>  null
                ])) {
                    $this->info("Success for worker $value->code_maid");
                }

                $this->info("Fail for worker $value->code_maid");
            }
        }

        $this->info("No Data Worker");
    }
}
