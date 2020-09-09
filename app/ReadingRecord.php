<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ReadingRecord extends Model
{      
    protected $fillable =[
        'reading_date',
        'body',
        'public_private',
    ];
    // protected $dates = [
    //     'reading_date',
    // ];
    
    public function user() : BelongsTo
    {
        return $this->belongsTo('App\User');
    }
    public function book():BelongsTo
    {
        return $this->belongsTo('App\Book');
    }

    // 中間テーブル"likesテーブル"へのリレーション
    public function likes() : BelongsToMany
    {
        return $this->belongsToMany('App\User', 'likes')->withTimestamps();
    }

    // ユーザーが既にいいねしているかどうかの確認処理(true,falseで返す)
    public function isLiked($user_id): bool
    {
        return $this->likes->where('id', $user_id)->count();
    }

    public function getCountLikesAttribute():int
    {
        return $this->likes->count();
    }
}
