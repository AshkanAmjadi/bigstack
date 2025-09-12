<?php
namespace Modules\ActivityLog\App\Facades;

use Illuminate\Support\Facades\Facade;


/**
 * @method static self performedOn(object $subject)
 * @method static self causedBy(object $causer)
 * @method static self withEvent(string $event)
 * @method static self withLogName(string $name)
 * @method static self withProperties(array $props)
 * @method static self withBatchId(string|null $batchId = null)
 * @method static self withLevel(string $level = 'info')
 * @method static \Modules\ActivityLog\App\Models\ActivityLog record(string|null $description = null)
 */
class ActivityLogger extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'activitylog';
    }
}
