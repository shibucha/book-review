<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReadingRecord extends Model
{       
    public function user() : BelongsTo
    {
        return $this->belongsTo('App\User');
    }
    public function book():BelongsTo
    {
        return $this->belongsTo('App\Book');
    }
}
