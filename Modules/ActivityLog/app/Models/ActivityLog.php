<?php

namespace Modules\ActivityLog\App\Models;

use App\Models\LoginTracking;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// use Modules\ActivityLog\Database\Factories\ActivityLogFactory;

class ActivityLog extends Model
{
    use HasFactory;

    protected $table = 'activity_logs';

    protected $fillable = [
        'log_name',
        'subject_type',
        'subject_id',
        'causer_type',
        'causer_id',
        'login_tracking_id', // اضافه شد
        'event',
        'level',
        'properties',
        'batch_id',
    ];

    const UPDATED_AT = null;

    /**
     * تعریف رابطه معکوس با نشست.
     * هر لاگ فعالیت متعلق به یک نشست است.
     */
    public function loginTracking(): BelongsTo
    {
        return $this->belongsTo(LoginTracking::class);
    }

    protected $casts = [
        'properties' => 'array',
    ];

    public function subject()
    {
        return $this->morphTo();
    }

    public function causer()
    {
        return $this->morphTo();
    }


    // protected static function newFactory(): ActivityLogFactory
    // {
    //     // return ActivityLogFactory::new();
    // }
}
