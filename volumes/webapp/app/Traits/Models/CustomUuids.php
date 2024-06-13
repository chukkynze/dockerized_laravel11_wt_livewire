<?php

namespace App\Traits\Models;

use Illuminate\Support\Str;

trait CustomUuids
{
    protected static function boot(): void
    {
        parent::boot();
        static::creating(function ($model) {
            $model->uuid = (string) Str::uuid();
        });
    }
}
