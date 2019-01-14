<?php

namespace App\Providers;

use App\Observers\ModelActivityObserver;
use App\Observers\SetUserIdFieldOnCreate;
use App\Observers\TimesheetModelObserver;
use App\Observers\UserRateSettingObserver;
use App\Project;
use App\Task;
use App\Timesheet;
use App\User;
use App\UserLocation;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Fix the default string length error.
        Schema::defaultStringLength(191);

        // Fill the author field on model create.
        Timesheet::observe(SetUserIdFieldOnCreate::class);
        UserLocation::observe(SetUserIdFieldOnCreate::class);
        
        // Other observers.
        User::observe(UserRateSettingObserver::class);
        Timesheet::observe(TimesheetModelObserver::class);

        // Log user activity for these models.
        Project::observe(ModelActivityObserver::class);
        Task::observe(ModelActivityObserver::class);
        Timesheet::observe(ModelActivityObserver::class);
        User::observe(ModelActivityObserver::class);
        UserLocation::observe(ModelActivityObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
