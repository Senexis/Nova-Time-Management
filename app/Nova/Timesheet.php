<?php

namespace App\Nova;

use Auth;
use Epartment\NovaDependencyContainer\HasDependencies;
use Epartment\NovaDependencyContainer\NovaDependencyContainer;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;

class Timesheet extends Resource
{
    use HasDependencies;

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

            BelongsTo::make(__('nova.fields.location'), 'location', 'App\\Nova\\Location'),

            BelongsTo::make(__('nova.fields.task'), 'task', 'App\\Nova\\Task'),

            BelongsTo::make(__('nova.fields.project'), 'project', 'App\\Nova\\Project')
                ->searchable(),

            Text::make(__('nova.fields.time_worked'), 'time_worked')
                ->sortable()
                ->displayUsing(function ($value) {
                    if ($value != null) {
                        if (Auth::user()->option_decimal_time) {
                            return round(($value / 60) / 60, 2) . 'h';
                        } else {
                            return gmdate('G\h i\m', $value);
                        }
                    }
    
                    return null;
                })
                ->exceptOnForms(),

            DateTime::make(__('nova.fields.started_at'), 'started_at')
                ->sortable()
                ->exceptOnForms(),
                
            DateTime::make(__('nova.fields.ended_at'), 'ended_at')
                ->sortable()
                ->exceptOnForms(),

            // When the type is null, display this checkbox to either hide or show the conditional end date.
            Boolean::make(__('nova.fields.automatic_tracking'), 'type')
                ->trueValue('tracked')
                ->falseValue('manual')
                ->onlyOnForms()
                ->canSee(function () {
                    return $this->type == null;
                }),

            // When the type is null or manual, but not tracked, allow editing the start date.
            DateTime::make(__('nova.fields.started_at'), 'started_at')
                ->rules('required')
                ->onlyOnForms()
                ->canSee(function () {
                    return $this->type == null || $this->type == 'manual';
                }),

            // When the type is null, display a logically hidden or displayed Vue-component containing the end date.
            NovaDependencyContainer::make([
                DateTime::make(__('nova.fields.ended_at'), 'ended_at')
                    ->rules('after:started_at')
                    ->onlyOnForms()
                    ->canSee(function () {
                        return $this->type == null;
                    }),
            ])->dependsOn('type', false),

            // When the type is manual, but not null or tracked, display a static end date field.
            DateTime::make(__('nova.fields.ended_at'), 'ended_at')
                ->rules('after:started_at')
                ->onlyOnForms()
                ->canSee(function () {
                    return $this->type == 'manual';
                }),

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
}
