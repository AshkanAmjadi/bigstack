<?php


namespace App\facade\Module;


use Illuminate\Support\Facades\Facade;

/**
 * Class BaseMethod
 * @method static available($name)
 * @method static void logIfAvailable(object $subject,string $event, string|null $description,array $properties,object|null $causer,string $logName,string|null $batchId,string $level = 'info',bool $adminAsUser = false,)
 *
 * @see \App\facade\Module\ModuleService
 */
class ModuleFacade extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'ModuleService';
    }

}
