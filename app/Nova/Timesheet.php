<?php

namespace App\Nova;

use Auth;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;

class Timesheet extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Timesheet';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [];

    /**
     * Indicates if the resource should be globally searchable.
     *
     * @var bool
     */
    public static $globallySearchable = false;
    
    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static function group()
    {
        return __('nova.groups.other');
    }
    
    /**
     * Get the displayble label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return __('nova.resources.timesheets');
    }

    /**
     * Get the displayble singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return __('nova.resources.timesheet');
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            BelongsTo::make(__('nova.fields.user'), 'user', 'App\\Nova\\User')
                ->exceptOnForms()
                ->canSee(function () {
                    if (Auth::check()) {
                        // TODO: Implement a role check.
                        return false;
                    }
                }),

            BelongsTo::make(__('nova.fields.location'), 'location', 'App\\Nova\\Location')
                ->searchable(),

            BelongsTo::make(__('nova.fields.task'), 'task', 'App\\Nova\\Task')
                ->searchable(),

            BelongsTo::make(__('nova.fields.project'), 'project', 'App\\Nova\\Project')
                ->searchable(),

            Text::make(__('nova.fields.time_worked'), 'time_worked', function () { return $this->getTimeWorkedText(); })
                ->sortable()
                ->exceptOnForms(),

            DateTime::make(__('nova.fields.started_at'), 'started_at')
                ->rules('before:ended_at')
                ->sortable(),

            DateTime::make(__('nova.fields.ended_at'), 'ended_at')
                ->rules('after:started_at')
                ->sortable(),

            Markdown::make(__('nova.fields.notes'), 'notes')
                ->alwaysShow(),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [
            new Filters\TimesheetDateFromFilter,
            new Filters\TimesheetDateToFilter,
        ];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }

    /**
     * Build an "index" query for the given resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->where('user_id', $request->user()->id)->orderBy('started_at', 'desc');
    }

    /**
     * Determine if this resource uses soft deletes.
     *
     * @return bool
     */
    public static function softDeletes()
    {
        if (Auth::check()) {
            // TODO: Implement a role check.
            return false;
        }

        return static::$softDeletes;
    }

    /**
     * Apply any applicable orderings to the query.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  array  $orderings
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected static function applyOrderings($query, array $orderings)
    {
        foreach ($orderings as $column => $direction) {
            $query->orderBy($column, $direction);
        }

        return $query;
    }

    /**
     * Get the value that should be displayed to represent the time worked attribute.
     *
     * @return string
     */
    function getTimeWorkedText() {
        $value = $this->time_worked;

        if ($value != null) {
            if (Auth::user()->option_decimal_time) {
                return __('nova.fields.time_worked.values.decimal', [
                    'time' => round($value / 3600, 2)
                ]);
            } else {
                return gmdate(
                    __('nova.fields.time_worked.values.gmdate'),
                    $value
                );
            }
        }

        return null;
    }
}
