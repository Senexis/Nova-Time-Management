<?php

namespace App\Nova\Metrics;

use App\Log;
use Illuminate\Http\Request;
use Laravel\Nova\Metrics\Trend;

class LogsPerDay extends Trend
{
    /**
     * Get the displayble name of the metric.
     *
     * @return string
     */
    public function name()
    {
        return __('nova.metrics.logs_per_day');
    }

    /**
     * Calculate the value of the metric.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function calculate(Request $request)
    {
        return $this->countByDays($request, Log::class);
    }

    /**
     * Get the ranges available for the metric.
     *
     * @return array
     */
    public function ranges()
    {
        return [
            7 => __('nova.metrics.logs_per_day.values.' . 7),
            14 => __('nova.metrics.logs_per_day.values.' . 14),
            30 => __('nova.metrics.logs_per_day.values.' . 30),
        ];
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
        return 'logs-per-day';
    }
}
