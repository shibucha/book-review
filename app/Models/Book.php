<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    public function readingRecords():HasMany
    {
        return $this->hasMany('App\Models\ReadingRecord');
    }
    public function author():BelongsTo
    {
        return $this->belongsTo('App\Models\Author');
    }
}
