<?php

namespace App\Console\Commands;

use App\Helpers\AiHelper;
use App\Jobs\AiGenerateMessage;
use App\Models\Pair;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
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

    private $tries = 3;

    private $triesAfter = 30;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $time = [];
        $match = Pair::find($this->argument('match'));

        $time['start'] = microtime(true);
    
        $body = AiHelper::createCallBody($match);

        $time['cacheGet'] = microtime(true);

        $client = new Client();
        $response = $client->request('POST', config('services.edenai.endpoint'), [
            'body' => $body,
            'headers' => [
                'accept' => 'application/json',
                'authorization' => 'Bearer ' . config('services.edenai.key'),
                'content-type' => 'application/json',
            ],
        ]);


        $output = json_decode($response->getBody());

        if($output->openai->status == "success") {

            $botMessage = $output->openai->generated_text;

            $time['aiResponseGet'] = microtime(true);
    
            $match->messages()->create([
                'isBot' => true,
                'text' => $botMessage
            ]);
    
            $time['end'] = microtime(true);
    
            Log::info("
                AI Response | 
                Pair uuid - " . $match->id . "|
                Cache get time - " . ($time['cacheGet'] - $time['start']) * 1000 . "|
                Response get time - " . ($time['aiResponseGet'] - $time['cacheGet']) * 1000 . "|
                Response save time - " . ($time['end'] - $time['aiResponseGet']) * 1000 
            );

        } else {

            $try = Cache::get('ai-response-tries.' . $this->argument('match'), 0);

            if($try < $this->tries) {

                Cache::forever('ai-response-tries.' . $this->argument('match'), ++$try);

                AiGenerateMessage::dispatch($match)
                    ->onQueue("ai-message")
                    ->delay(now()->addSeconds($this->triesAfter * $try * ($try+1)/2));
            }

            Cache::put('ai-response-fail.' . $this->argument('match'), [
                'time' => now(),
                'match' => $match,
                'requestBody' => json_decode($body),
                'response' => $output
            ]);
            Log::warning($output->openai->error->message);
        }
    }
}
