<?php

namespace App\Observers;

use App\Log;
use Auth;

class ModelActivityObserver
{
    /**
     * Handle the model "created" event.
     *
     * @param  $model
     * @return void
     */
    public function created($model)
    {
        if (Auth::check()) {
            Log::create([
                'user_id'      => Auth::id(),
                'action'       => 'created',
                'action_model' => $model->getTable(),
                'action_id'    => $model->id
            ]);
        }
    }

    /**
     * Handle the model "updated" event.
     *
     * @param  $model
     * @return void
     */
    public function updating($model)
    {
        $actionUpdates = $model->getDirty();
        unset($actionUpdates['last_online_at']);
        if (empty($actionUpdates)) return;

        if (Auth::check()) {
            Log::create([
                'user_id'        => Auth::id(),
                'action'         => 'updated',
                'action_model'   => $model->getTable(),
                'action_id'      => $model->id,
                'action_updates' => json_encode(array_keys($actionUpdates))
            ]);
        }
    }

    /**
     * Handle the model "deleted" event.
     *
     * @param  $model
     * @return void
     */
    public function deleted($model)
    {
        if (Auth::check()) {
            Log::create([
                'user_id'      => Auth::id(),
                'action'       => 'deleted',
                'action_model' => $model->getTable(),
                'action_id'    => $model->id
            ]);
        }
    }
}
