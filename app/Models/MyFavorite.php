<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class MyFavorite extends Model
{

    protected $fillable = [
        'my_favorite_01',
        'my_favorite_02',
        'my_favorite_03',
        'my_favorite_reason_01',
        'my_favorite_reason_02',
        'my_favorite_reason_03',
        'my_favorite_isbn_01',
        'my_favorite_isbn_02',
        'my_favorite_isbn_03',
    ];

    // ユーザーズテーブルとのリレーション（１対１）
    public function user(): BelongsTo
    {
        return $this->belongsTo('App\Models\User');
    }
}
