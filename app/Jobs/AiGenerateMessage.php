<?php

namespace App\Jobs;

use App\Helpers\AiHelper;
use App\Models\Pair;
use DateTime;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class AiGenerateMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    public $pairUuid;

    /**
     * Create a new job instance.
     */
    public function __construct(Pair $pair)
    {
        $this->pairUuid = $pair->id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Cache::put('xd', 'xd');
        Log::info("Handle Job");
        AiHelper::callInBackground($this->pairUuid);
    }

    public function retryUntil(): DateTime
    {
        return now()->addMinutes(2);
    }
}
