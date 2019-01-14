<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'user_id', 'action', 'action_model', 'action_id', 'action_updates' ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
