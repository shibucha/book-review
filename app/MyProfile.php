<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class MyProfile extends Model
{
    protected $fillable =[
        'my-favorite1',
        'my-favorite2',
        'my-favorite3',
        'my-favorite-reason1',
        'my-favorite-reason2',
        'my-favorite-reason3',
        'my-favorite-isbn1',
        'my-favorite-isbn2',
        'my-favorite-isbn3',
    ];


    // ユーザーズテーブルとのリレーション（１対１）
    public function user() : BelongsTo
    {
        return $this->belongsTo('App\User');
    }
}
