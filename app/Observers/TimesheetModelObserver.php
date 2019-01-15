<?php

namespace App\Observers;

use Carbon\Carbon;

class TimesheetModelObserver
{
    /**
     * Handle the model "creating" event.
     * 
     * Automatically populates the time_worked field when creating a manual timesheet.
     *
     * @param  $model
     * @return void
     */
    public function creating($model)
    {
        if ($model->ended_at != null) {
            $model->time_worked = $model->ended_at->diffInSeconds($model->started_at);
        }
    }

    /**
     * Handle the model "updating" event.
     * 
     * Automatically updates the time_worked field when creating a manual timesheet.
     *
     * @param  $model
     * @return void
     */
    public function updating($model)
    {
        if ($model->type == 'manual' && $model->ended_at != null) {
            $model->time_worked = $model->ended_at->diffInSeconds($model->started_at);
        }

        if ($model->type == 'tracked') {
            if ($model->ended_at == null && $model->paused_at != null) {
                // Paused without prior resuming.
                $model->time_worked += $model->paused_at->diffInSeconds($model->resumed_at ?? $model->started_at);
            } else if ($model->ended_at != null && $model->paused_at == null) {
                // Ended without prior pausing.
                $model->time_worked += $model->ended_at->diffInSeconds($model->resumed_at ?? $model->started_at);
                $model->resumed_at = null;
            }
        }
    }
}
