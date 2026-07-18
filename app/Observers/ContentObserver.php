<?php

declare(strict_types=1);

namespace App\Observers;

use App\Services\SiteContent;
use Illuminate\Database\Eloquent\Model;

/**
 * Flushes the site cache whenever editable content changes.
 *
 * Registered against every content model and against Setting, so an edit made
 * in /admin is reflected on the public site immediately rather than whenever
 * the cache happens to expire.
 */
final readonly class ContentObserver
{
    public function __construct(private SiteContent $site) {}

    public function saved(Model $model): void
    {
        $this->site->flush();
    }

    public function deleted(Model $model): void
    {
        $this->site->flush();
    }

    public function restored(Model $model): void
    {
        $this->site->flush();
    }
}
