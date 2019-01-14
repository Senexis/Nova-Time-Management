<?php

namespace App\Nova\Filters;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Laravel\Nova\Filters\DateFilter;

class TimesheetDateFromFilter extends DateFilter
{
    /**
     * Get the displayble name of the filter.
     *
     * @return string
     */
    public function name()
    {
        return __('nova.filters.timesheet_date_from');
    }

    /**
     * Apply the filter to the given query.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Request $request, $query, $value)
    {
        return $query->where('started_at', '>=', Carbon::parse($value)->startOfDay());
    }
}
