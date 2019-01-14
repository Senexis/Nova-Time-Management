<?php

namespace App\Observers;

use Auth;

class SetUserIdFieldOnCreate
{
    /**
     * Handle the model "creating" event.
     * Automatically populates the user_id field when creating a model.
     *
     * @param  $model
     * @return void
     */
    public function creating($model)
    {
        if (Auth::check()) {
            $model->user_id = Auth::id();
        }
    }
}
