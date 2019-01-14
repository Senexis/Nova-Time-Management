<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Log extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Log';

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
        return __('nova.groups.admin');
    }

    /**
     * Get the displayble label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return __('nova.resources.logs');
    }

    /**
     * Get the displayble singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return __('nova.resources.log');
    }

    /**
     * Get the value that should be displayed to represent the resource.
     *
     * @return string
     */
    public function title()
    {
        return $this->getActionText();
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
            BelongsTo::make(__('nova.fields.user'), 'user', 'App\\Nova\\User'),

            Text::make(__('nova.fields.action'), 'action', function () { return $this->getActionText(); }),
            
            DateTime::make(__('nova.fields.created_at'), 'created_at'),
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
        return [
            new Metrics\LogsPerDay,
            new Metrics\LogsPerType,
            new Metrics\LogsPerModel,
        ];
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
            new Filters\LogType,
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
     * Get the value that should be displayed to represent the log action attribute.
     *
     * @return string
     */
    function getActionText() {
        if ($this->action_updates) {
            return __('nova.fields.action.values.updates', [
                'action' => $this->action,
                'action_model' => ucwords(str_replace('_', ' ', $this->action_model)),
                'action_id' => $this->action_id,
                'action_updates' => implode(', ', str_replace('_', ' ', json_decode($this->action_updates))),
            ]);
        } else {
            return __('nova.fields.action.values.other', [
                'action' => $this->action,
                'action_model' => ucwords(str_replace('_', ' ', $this->action_model)),
                'action_id' => $this->action_id,
            ]);
        }
    }
}
