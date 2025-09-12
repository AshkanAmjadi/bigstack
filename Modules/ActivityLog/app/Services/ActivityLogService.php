<?php
namespace Modules\ActivityLog\App\Services;

use App\facade\BaseQuery\BaseQuery;
use App\Services\LoginSecurity\LoginTracker;
use Modules\ActivityLog\App\Models\ActivityLog;
use Illuminate\Support\Str;

class ActivityLogService
{
    protected ?string $logName = null;
    protected ?string $event = null;
    protected mixed $subject = null;
    protected string|null|object $causer = null;
    protected array $properties = [];
    protected ?string $batchId = null;
    protected ?string $level = 'info';

    public function withLevel(string $level): self
    {
        $this->level = $level;
        return $this;
    }

    public function performedOn($subject): self
    {
        $this->subject = $subject;
        return $this;
    }

    public function causedBy($causer): self
    {
        $this->causer = $causer;
        return $this;
    }

    public function withEvent(string $event): self
    {
        $this->event = $event;
        return $this;
    }

    public function withLogName(string $name = null): self
    {
        $this->logName = $name;
        return $this;
    }

    public function withProperties(array $props): self
    {
        $this->properties = $props;
        return $this;
    }

    public function withBatchId(?string $batchId = null): self
    {

        $this->batchId = app()->bound('activitylog.batch_id')
            ? app('activitylog.batch_id')
            : ($batchId ?? Str::uuid()->toString());

        app()->instance('activitylog.batch_id', $this->batchId);

        return $this;

    }

    public function record(string $description = null): ActivityLog
    {

        $log = ActivityLog::query()->create([
            'log_name' => $this->logName ?? '',
            'event' => $this->event ?? '',
            'level' => $this->level,
            'subject_type' => BaseQuery::morphAlias($this->subject),
            'subject_id' => $this->subject->getKey() ?? 0,
            'causer_type' => is_object($this->causer) ? BaseQuery::morphAlias($this->causer) :( is_string($this->causer) ? $this->causer : null),
            'causer_id' => is_object($this->causer) ? $this->causer->getKey() : null,
            'properties' => array_merge($this->properties,
                [
                    'description' => $description,
                    'protocol' => request()->getScheme(),

                ]
            ),
            'batch_id' => $this->batchId,
            'login_tracking_id' => app(LoginTracker::class)?->loadCurrentLogin()?->id ?? null,
        ]);

        $this->resetState();
        return $log;
    }

    protected function resetState(): void
    {
        $this->logName = null;
        $this->event = null;
        $this->subject = null;
        $this->causer = null;
        $this->properties = [];
        $this->batchId = null;
    }
}
