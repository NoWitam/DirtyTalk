<?php

namespace App\Helpers;
use App\Models\Bot;
use App\Models\Message;
use App\Models\Pair;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class AiHelper {
    public static function callInBackground(string $pairUuid): void
    {
        shell_exec(sprintf('%s > /dev/null 2>&1 &', "php artisan app:message-response " . $pairUuid));
    }

    public static function getMessagesHistory(Pair $pair): array
    {
        return Cache::rememberForever('message-hisotry.' . $pair->id, function () use ($pair) {

            $messages = $pair->messages()->orderBy('created_at', 'asc')->get();

            $history = [];
    
            foreach($messages as $message)
            {
                $history[] = [
                    'role' => $message->isBot ? 'assistant' : 'user',
                    'message' => $message->text
                ];
            }
            return $history;
        });
    }

    public static function updateMesageHistory(Message $message, Pair $pair)
    {
        if(Cache::has('message-hisotry.' . $pair->id)) {
            $history = static::getMessagesHistory($pair);
        } else {
            $history = [];
        }

        $history[] = [
            'role' => $message->isBot ? 'assistant' : 'user',
            'message' => $message->text
        ];

        Cache::forever('message-hisotry.' . $pair->id, $history);
    }

    public static function createCallBody(Pair $match)
    {
        $history = AiHelper::getMessagesHistory($match);

        $lastElement = array_pop($history);
        while($lastElement['role'] != 'user') {
            $lastElement = array_pop($history); 
        }
       
        return json_encode([
            'response_as_dict' => true,
            'attributes_as_list' => false,
            'show_original_response' => false,
            'settings' => [
                'openai' => 'gpt-4'
            ],
            'previous_history' => $history,
            'temperature' => 0.2,
            'max_tokens' => 250,
            'providers' => 'openai',
            'text' => $lastElement['message'],
            'chatbot_global_action' => static::createContext($match->bot),           
        ], JSON_UNESCAPED_UNICODE);
    }

    public static function createContext(Bot $bot): string
    {
        return 'Masz na imię ' . $bot->name . '.' .
                'Masz ' . $bot->birthday->age . ' lat.' .
                'Jesteś użytkowniczką portalu randkowego, na którym twój opis to: "' .
                $bot->description . '". Twoim zadaniem jest poderwać twojego rozmówce.';
    }
}