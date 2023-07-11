<?php

namespace App\Jobs;

use App\Helpers\AiHelper;
use App\Models\Pair;
use DateTime;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

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
        AiHelper::callInBackground($this->pairUuid);
    }

    public function retryUntil(): DateTime
    {
        return now()->addMinutes(2);
    }
}
