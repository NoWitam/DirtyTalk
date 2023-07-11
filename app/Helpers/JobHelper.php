<?php

namespace App\Helpers;

use App\Models\Pair;
use App\Models\Job;

class JobHelper {
    public static function getByPair(Pair $pair, string $queue = 'ai-message') : ?Job
    {
        return Job::where('queue', $queue)
                    ->where('payload', 'LIKE', '%\"pairUuid\\\\\";s:36:\\\\\"' . $pair->id . '\\\\\"%')
                    ->where('available_at', '>', now()->timestamp)
                    ->first();
    }
}