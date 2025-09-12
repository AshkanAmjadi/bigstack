<?php

namespace App\Traits;
use App\facade\BaseQuery\BaseQuery;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait HasMorphAlias
{
// متد bootHasMorphAlias بدون تغییر باقی می‌ماند
    public static function bootHasMorphAlias(): void
    {

        static::$morphClass = BaseQuery::morphAlias(static::class);

    }

    /**
     * یک accessor برای دسترسی به morph alias به صورت یک خصوصیت مجازی ایجاد می‌کند.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function morphClass(): Attribute
    {
        return Attribute::make(
            get: fn () => static::$morphClass,
        );
    }
}
