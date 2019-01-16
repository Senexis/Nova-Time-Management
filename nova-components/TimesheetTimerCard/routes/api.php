<?php

use App\Timesheet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Card API Routes
|--------------------------------------------------------------------------
|
| Here is where you may register API routes for your card. These routes
| are loaded by the ServiceProvider of your card. You're free to add
| as many additional routes to this file as your card may require.
|
*/

Route::get('/latest-timer', function (Request $request) {
    $currentEntry = GetCurrentEntry();

    if ($currentEntry == null) return "{}";

    if ($currentEntry->paused_at == null) {
        $currentEntry->time_worked += Carbon::now()->diffInSeconds($currentEntry->resumed_at ?? $currentEntry->started_at);
    }

    return $currentEntry;
});

Route::get('/latest-timer/pause', function (Request $request) {
    $currentEntry = GetCurrentEntry();

    if ($currentEntry == null) return "{}";

    if ($currentEntry->ended_at == null && $currentEntry->paused_at == null) {
        $currentEntry->paused_at = Carbon::now();
        $currentEntry->save();
    }

    return $currentEntry;
});

Route::get('/latest-timer/resume', function (Request $request) {
    $currentEntry = GetCurrentEntry();

    if ($currentEntry == null) return "{}";

    if ($currentEntry->ended_at == null && $currentEntry->paused_at != null) {
        $currentEntry->resumed_at = Carbon::now();
        $currentEntry->paused_at = null;
        $currentEntry->save();
    }

    return $currentEntry;
});

Route::get('/latest-timer/stop', function (Request $request) {
    $currentEntry = GetCurrentEntry();

    if ($currentEntry == null) return "{}";

    if ($currentEntry->ended_at == null && $currentEntry->paused_at != null) {
        $currentEntry->ended_at = $currentEntry->resumed_at ?? Carbon::now();
        $currentEntry->paused_at = null;
        $currentEntry->save();
    }

    return "{}";
});

function GetCurrentEntry() {
    return Timesheet::where('type', 'tracked')
        ->where('user_id', Auth::id())
        ->whereNull('ended_at')
        ->orderBy('created_at', 'desc')
        ->first();
}