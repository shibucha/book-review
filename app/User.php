<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'icon',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    // ********************リレーション**********************//

    // User1 : ReadingRecord多
    public function readingRecord(): HasMany
    {
        return $this->hasMany('App\ReadingRecord');
    }

    // 中間テーブル"likesテーブル"へのリレーション
    public function likes(): BelongsToMany
    {
        return $this->belongsToMany('App\ReadingRecord', 'likes')->withTimestamps();
    }

    // User1 : MyFavorite1
    public function myFavorite(): HasOne
    {
        return $this->hasOne('App\MyFavorite');
    }
    // User1 : MyProfile1
    public function myProfile(): HasOne
    {
        return $this->hasOne('App\MyProfile');
    }
}
