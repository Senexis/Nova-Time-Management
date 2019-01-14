<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Timesheet extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'task_id', 'project_id', 'location_id', 'notes' ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
        'paused_at' => 'datetime',
        'resumed_at' => 'datetime',
        'locked_at' => 'datetime',
    ];

    public function getIsLockedAttribute()
    {
        return $this->locked_at == null;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function location()
    {
        return $this->belongsTo(UserLocation::class, 'location_id');
    }
}
