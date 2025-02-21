<?php

namespace App\Listeners\Core;

use Illuminate\Events\Dispatcher;
use Spatie\Activitylog\ActivityLogger;

/**
 * Class BaseSubscriber
 *
 * @package App\Listeners\Core
 */
abstract class BaseSubscriber
{
    /**
     * Event name (using with activity log).
     *
     * @var string
     */
    protected string $eventName;

    /**
     * BaseSubscriber Constructor
     */
    public function __construct()
    {
        $this->eventName = config('activitylog.default_log_name') ?? 'default';
    }

    /**
     * Set Event name.
     *
     * @param string $name <p>Event name (using with activity log).</p>
     * @return void
     */
    public function setEventName(string $name): void
    {
        $this->eventName = $name;
    }

    /**
     * Get ActivityLogger Instance.
     *
     * @param string|null $logName <p>Log Activity name.</p>
     * @return ActivityLogger The ActivityLogger Instance.
     */
    public function activity(string $logName = null): ActivityLogger
    {
        return activity($logName ?? $this->eventName);
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param Dispatcher $events
     */
    public abstract function subscribe(Dispatcher $events): array;
}
