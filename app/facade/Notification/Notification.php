<?php


namespace App\facade\Notification;


use Illuminate\Support\Facades\Facade;

/**
 *
 * Class BaseMethod
 * @method static user($user_id,$type,$text,$data = [])
 * @method static admin($type,$text,$data = [])
 *
 * @see \App\facade\Description\Notification
 */
class Notification extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'NotificationService';
    }

}
