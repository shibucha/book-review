<?php
namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class EnvironmentalConfirmation extends Facade
{
protected static function getFacadeAccessor()
{
    return 'env-conf';
}
}