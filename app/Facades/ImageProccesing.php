<?php
namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class ImageProccesing extends Facade
{
protected static function getFacadeAccessor()
{
    return 'image-process';
}
}