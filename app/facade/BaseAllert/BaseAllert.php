<?php


namespace App\facade\BaseAllert;


use Illuminate\Support\Facades\Facade;
/**
 * Class BaseMethod
 * @method static array adminAllert($content,$type)
 * @method static array userAllert($user,$content,$type)
 *
 * @see \App\facade\BaseAllert\BaseAllert
 */
class BaseAllert extends Facade
{


    protected static function getFacadeAccessor()
    {
        return 'BaseAllertService';

    }

}
