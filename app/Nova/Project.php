<?php

namespace App\Nova;

use Auth;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Project extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Project';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'name', 'notes',
    ];
    
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
        return __('nova.resources.projects');
    }

    /**
     * Get the displayble singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return __('nova.resources.project');
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
            Text::make(__('nova.fields.name'), 'name')
                ->sortable()
                ->rules('required', 'max:255')
                ->creationRules('unique:projects,name')
                ->updateRules('unique:projects,name,{{resourceId}}'),

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
        return [];
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
        return $query->orderBy('name', 'asc');
    }

    /**
     * Build a "relatable" query for the given resource.
     *
     * This query determines which instances of the model may be attached to other resources.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function relatableQuery(NovaRequest $request, $query)
    {
        return $query->orderBy('name', 'asc');
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
