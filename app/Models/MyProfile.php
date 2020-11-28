<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class MyProfile extends Model
{
    protected $fillable = [
        'nickname',
        'self_introduction',
    ];


    // ユーザーズテーブルとのリレーション（１対１）
    public function user(): BelongsTo
    {
        return $this->belongsTo('App\Models\User');
    }
}
