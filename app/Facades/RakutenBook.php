<?php
namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class RakutenBook extends Facade
{
protected static function getFacadeAccessor()
{
    return 'rakuten-book';
}
}