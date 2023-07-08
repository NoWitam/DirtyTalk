<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Storage;

class Bot extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'birthday',
    ];

    protected $casts = [
        'birthday' => 'date',
    ];

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($model) {
            foreach($model->images as $image)
            {
                $image->delete();
            }
        });
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'pairs');
    } 

    public function images(): MorphMany
    {
        return $this->morphMany(File::class, 'owner');
    }
}
