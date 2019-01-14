<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserHistoryItem extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'hourly_rate', 'travel_rate'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
