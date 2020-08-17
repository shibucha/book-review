<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    public function readingRecord():HasMany
    {
        return $this->hasMany('App\ReadingRecord');
    }
    public function author():BelongsTo
    {
        return $this->belongsTo('App\Author');
    }
}
