<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CuriousBook extends Model
{
    // リレーション
    public function user(): BelongsTo{
        return $this->belongsTo('App\Models\User');
    }

    public function book():BelongsTo{
        return $this->belongsTo('App\Models\Book');
    }
}
