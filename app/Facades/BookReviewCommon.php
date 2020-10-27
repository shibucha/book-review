<?php
namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class BookReviewCommon extends Facade
{
protected static function getFacadeAccessor()
{
    return 'common';
}
}