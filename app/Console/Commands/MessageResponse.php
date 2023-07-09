<?php

namespace App\Console\Commands;

use App\Models\Pair;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
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
           // $proc = new Process(['php artisan app:message-response 5']);
           // $proc->run();
           shell_exec(sprintf('%s > /dev/null 2>&1 &', "php artisan app:message-response 2137"));
           shell_exec(sprintf('%s > /dev/null 2>&1 &', "php artisan app:message-response 2138"));
           //exec('php artisan app:message-response 6');
            //Process::run('php artisan app:message-response 5');
           // $proc1->start();
           // Process::run('php artisan app:message-response 6');
           // $proc2->start();
           
        } else {
            for($i=0; $i<20; $i++)
            {
                Log::info("Task " . $number . " call " . $i);
                sleep(1);
            }
        }
    }
}
