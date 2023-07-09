<?php

namespace App\Console\Commands;

use App\Models\Pair;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;

class MessageResponse extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:message-response {match}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate AI Response to user message';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //$match = Pair::find($this->argument('match'));
        $number = $this->argument('match');
        if($number == 'start') {
            $proc1 = new Process(['php artisan app:message-response 1']);
            $proc1->start();
            $proc2 = new Process(['php artisan app:message-response 2']);
            $proc2->start();
        } else {
            for($i=0; $i<20; $i++)
            {
                Log::info("Task " . $number . " call " . $i);
            }
        }
    }
}
