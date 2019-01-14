<?php

namespace App\Observers;

use App\User;
use App\UserHistoryItem;
use Auth;

class UserRateSettingObserver
{
    /**
     * Handle the model "creating" event.
     * 
     * Create a new UserHistoryItem entry based on the dirty custom fields, then removes the dirty fields.
     *
     * @param  $model
     * @return void
     */
    public function creating($model)
    {
        $this->createRateHistory($model->id, $model->getDirty());
        unset($model->hourly_rate, $model->travel_rate);
    }

    /**
     * Handle the model "updating" event.
     * 
     * Create a new UserHistoryItem entry based on the dirty custom fields, then removes the dirty fields.
     * Checks is the latest item has the same values as the to-be-created item would have.
     *
     * @param  $model
     * @return void
     */
    public function updating($model)
    {
        $dirtyProps = $model->getDirty();
        if (!isset($dirtyProps['hourly_rate']) || !isset($dirtyProps['travel_rate'])) return;

        $uhi = UserHistoryItem::where('user_id', $model->id)->orderBy('created_at', 'desc')->first();
        
        if ($uhi == null || ($dirtyProps['hourly_rate'] != $uhi->hourly_rate || $dirtyProps['travel_rate'] != $uhi->travel_rate)) {
            $this->createRateHistory($model->id, $dirtyProps);
        }

        unset($model->hourly_rate, $model->travel_rate);
    }

    /**
     * Create a new UserHistoryItem based on information passed from the above events.
     *
     * @param  $id, $dirtyProps
     * @return void
     */
    protected function createRateHistory($id, $dirtyProps)
    {
        $issetHr = isset($dirtyProps['hourly_rate']);
        $issetTr = isset($dirtyProps['travel_rate']);

        if (!$issetHr && !$issetTr) return;

        $updateArray = [];

        if ($issetHr) {
            $updateArray['hourly_rate'] = $dirtyProps['hourly_rate'];
        }

        if ($issetTr) {
            $updateArray['travel_rate'] = $dirtyProps['travel_rate'];
        }

        $updateArray['user_id'] = $id;

        UserHistoryItem::create($updateArray);
    }
}
