<?php

namespace App\Nova\Metrics;

use App\Log;
use Illuminate\Http\Request;
use Laravel\Nova\Metrics\Partition;

class LogsPerType extends Partition
{
    /**
     * Get the displayble name of the metric.
     *
     * @return string
     */
    public function name()
    {
        return __('nova.metrics.logs_per_type');
    }

    /**
     * Calculate the value of the metric.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function calculate(Request $request)
    {
        return $this->count($request, Log::class, 'action')
            ->label(function ($value) {
                return __('nova.metrics.logs_per_type.values.' . $value);
            });
    }

    /**
     * Determine for how many minutes the metric should be cached.
     *
     * @return  \DateTimeInterface|\DateInterval|float|int
     */
    public function cacheFor()
    {
        return now()->addHours(1);
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'logs-per-type';
    }
}
