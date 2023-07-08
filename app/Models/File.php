<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'path',
    ];

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($model) {
            Storage::disk('public')->delete($model->path);
        });
    }

    public function owner(): MorphTo
    {
        return $this->morphTo();
    }
}
