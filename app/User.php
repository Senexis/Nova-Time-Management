<?php

namespace App;

use App\UserHistoryItem;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Silvanite\Brandenburg\Traits\HasRoles;

class User extends Authenticatable
{
    use SoftDeletes, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'name', 'notes', 'timezone', 'language', 'option_decimal_time', 'email', 'password' ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [ 'password', 'remember_token' ];

    /**
     * Get the user's hourly rate attribute.
     *
     * @return float
     */
    public function getHourlyRateAttribute()
    {
        $uhi = UserHistoryItem::where('user_id', $this->id)->orderBy('created_at', 'desc')->first();
        if (isset($uhi->hourly_rate)) return $uhi->hourly_rate;
    }

    /**
     * Set the user's hourly rate attribute.
     *
     * @param  string  $value
     * @return void
     */
    public function setHourlyRateAttribute($value)
    {
        $this->attributes['hourly_rate'] = $value;
    }

    /**
     * Get the user's travel rate attribute.
     *
     * @return float
     */
    public function getTravelRateAttribute()
    {
        $uhi = UserHistoryItem::where('user_id', $this->id)->orderBy('created_at', 'desc')->first();
        if (isset($uhi->travel_rate)) return $uhi->travel_rate;
    }

    /**
     * Set the user's travel rate attribute.
     *
     * @param  string  $value
     * @return void
     */
    public function setTravelRateAttribute($value)
    {
        $this->attributes['travel_rate'] = $value;
    }
}
