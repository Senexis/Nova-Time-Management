<?php

namespace App\Observers;

use Carbon\Carbon;

class TimesheetModelObserver
{
    /**
     * Handle the model "creating" event.
     * 
     * Automatically populates the time_worked field when creating a manual model. If the 
     * current model is not a manual model (doesn't have an end time), sets it to tracked.
     *
     * @param  $model
     * @return void
     */
    public function creating($model)
    {
        if ($model->ended_at == null) {
            $model->type = 'tracked';
        } else {
            $model->type = 'manual';
            $model->time_worked = $model->ended_at->diffInSeconds($model->started_at);
        }
    }

    /**
     * Handle the model "updating" event.
     * 
     * Automatically updates the time_worked field when creating a manual model.
     *
     * @param  $model
     * @return void
     */
    public function updating($model)
    {
        if ($model->type == 'manual') {
            $model->time_worked = $model->ended_at->diffInSeconds($model->started_at);
        } else {
            // Case 'tracked' is not handled here.
        }
    }
}
