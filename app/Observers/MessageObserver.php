<?php

namespace App\Observers;

use App\Events\BotReplyReceived;
use App\Helpers\AiHelper;
use App\Helpers\JobHelper;
use App\Jobs\AiGenerateMessage;
use App\Models\Message;
use Illuminate\Support\Facades\Cache;

class MessageObserver
{
    /**
     * Handle the Message "created" event.
     */
    public function created(Message $message): void
    {
        // debounce wysłania zapytania do api edanai
        $pair = $message->pair;

        AiHelper::updateMesageHistory($message, $pair);

        if($message->isBot) {
            BotReplyReceived::dispatch($message);
        } else {
            Cache::forget('ai-response-tries.' . $pair->id);

            $dispatchTime = now()->addSeconds(config('services.edenai.debounce'));

            $job = JobHelper::getByPair($pair);
            
            if($job) {
                $job->update([
                    'available_at' => $dispatchTime->timestamp
                ]);
            } else {
                AiGenerateMessage::dispatch($pair)
                        ->onQueue("ai-message")
                        ->delay($dispatchTime);
            }
        }
    }

    /**
     * Handle the Message "updated" event.
     */
    public function updated(Message $message): void
    {
        //
    }

    /**
     * Handle the Message "deleted" event.
     */
    public function deleted(Message $message): void
    {
        //
    }

    /**
     * Handle the Message "restored" event.
     */
    public function restored(Message $message): void
    {
        //
    }

    /**
     * Handle the Message "force deleted" event.
     */
    public function forceDeleted(Message $message): void
    {
        //
    }
}
