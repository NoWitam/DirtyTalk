<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
class Pair extends Pivot
{
    use HasFactory, HasUuids;

    protected $table = 'pairs';

    protected $fillable = [
        'user_id',
        'bot_id',
        'accept',
    ];

    public function bot(): BelongsTo 
    {
        return $this->belongsTo(Bot::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'pair_id');
    }

    public function lastMessage(): HasOne
    {
        return $this->hasOne(Message::class, 'pair_id')->latestOfMany();
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->id = Str::uuid()->toString();
            Cache::forget('showed_match.' . Auth::id());
        });
    }
}
