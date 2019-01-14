<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class UserLocation extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'notes',
        'address_from',
        'address_to',
        'distance'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
