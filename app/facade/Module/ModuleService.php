<?php


namespace App\facade\Module;



use Modules\ActivityLog\App\Facades\ActivityLogger;
use Nwidart\Modules\Facades\Module;

class ModuleService
{

    public function available($name): bool
    {


        return Module::has($name) && Module::find($name)->isEnabled();

    }

    /**
     * Register activity log if ActivityLog module is available.
     *
     * @param object $subject     The model or entity the event is happening to (e.g., Post, User, Comment).
     * @param string $event       Event type (e.g., 'created', 'updated', 'deleted', 'login', ...).
     * @param string|null $description Optional human-readable description. If null, auto-generated from event and model.
     * @param array $properties   Additional data to be stored with the log (e.g., ['ip' => '...']).
     * @param object|null $causer Who caused the action (defaults to auth()->user() if null).
     * @param string $logName     Logical grouping name for the log (e.g., 'admin', 'auth').
     * @param string|null $batchId Optional batch ID for grouping multiple logs together.
     * @param string $level level of error
     * @param string $adminAsUser where we want know admin as user doing smthing or as admin
     *
     * @return void
     */
    //                | سطح       | توضیح                                                |
//| --------- | ---------------------------------------------------- |
//| `report`   | خبر از طرف کاربر             |
//| `good`   | خبر خوب             |
//| `debug`   | صرفاً اطلاعات فنی (مثل IP, browser)                  |
//| `info`    | عملیات موفق کاربر عادی (ویرایش، ورود)                |
//| `notice`  | اتفاق مهم اما خطرناک نیست (درخواست رمز، ورود میهمان) |
//| `warning` | چیزی غیرعادی (login fail, data anomaly)              |
//| `error`   | خطای واقعی یا تخلف (حذف محتوا، بلاک، تداخل)          |

    public function logIfAvailable(
        object $subject,
        string $event,
        ?string $description = null,
        array $properties = [],
        string|object $causer = null,
        string $logName = null,
        ?string $batchId = null,
        ?string $level = 'info',
        bool $adminAsUser = false,
    ): void {
        if (!$this->available('ActivityLog')) {
            return;
        }

        if ($adminAsUser) {
            $adminAsUser = (request()->is('admin/*') && auth()->user()?->superuser
                ? 'admin'
                : 'user');
        }else{
            $adminAsUser = super() ? 'admin' : 'user';
        }

        ActivityLogger::performedOn($subject)
            ->causedBy($causer ?? auth()->user())
            ->withEvent($event)
            ->withLogName($logName ?? $adminAsUser)
            ->withProperties(array_merge($properties, [
                'ip' => request()->ip(),
                'browser' => request()->userAgent(),
                'url' => request()->fullUrl(),
                'method' => request()->method(),
                'locale' => app()->getLocale(),
            ]))
            ->withBatchId($batchId)
            ->withLevel($level)
            ->record($description ?? "{$event} action on " . class_basename($subject));
    }


}
