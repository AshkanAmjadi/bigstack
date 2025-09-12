<?php


namespace App\facade\BaseRequest;


use Illuminate\Support\Facades\Facade;


/**
 * Class BaseMethod
 * @method static array mergePrToEnRequest($request,array $data)
 * @method static array replaceToSpace($request,array $data,$replacement = '')
 * @method static array getRememberTokenInfo()
 * @method static array getSessionDataById(string $sessionId)
 * @method static null|string getAndForgetRememberToken()
 *
 *
 * @see \App\facade\BaseRequest\BaseRequest
 */
class BaseRequest extends Facade
{


    protected static function getFacadeAccessor()
    {
        return 'BaseRequestService';

    }

}
