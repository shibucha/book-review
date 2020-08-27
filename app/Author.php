<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Author extends Model
{   
    
    public function books():HasMany
    {
        return $this->hasMany('App\Book');
    }
}
