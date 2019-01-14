<?php

namespace App\Nova\Filters;

use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class LogType extends Filter
{
    /**
     * Get the displayble name of the filter.
     *
     * @return string
     */
    public function name()
    {
        return __('nova.filters.log_type');
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
        return $query->where('action', $value);
    }

    /**
     * Get the filter's available options.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function options(Request $request)
    {
        return [
            __('nova.filters.log_type.values.created') => 'created',
            __('nova.filters.log_type.values.updated') => 'updated',
            __('nova.filters.log_type.values.deleted') => 'deleted'
        ];
    }
}
