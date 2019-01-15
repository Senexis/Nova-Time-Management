<?php

use App\Timesheet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Tool API Routes
|--------------------------------------------------------------------------
|
| Here is where you may register API routes for your tool. These routes
| are loaded by the ServiceProvider of your tool. They are protected
| by your tool's "Authorize" middleware by default. Now, go build!
|
*/

Route::get('/latest-timer', function (Request $request) {
    $currentEntry = GetCurrentEntry();

    return $currentEntry ?? "{}";
});

Route::get('/latest-timer/pause', function (Request $request) {
    $currentEntry = GetCurrentEntry();

    if ($currentEntry->ended_at == null && $currentEntry->paused_at == null) {
        $currentEntry->paused_at = Carbon::now();
        $currentEntry->save();
    }

    return $currentEntry ?? "{}";
});

Route::get('/latest-timer/resume', function (Request $request) {
    $currentEntry = GetCurrentEntry();

    if ($currentEntry->ended_at == null && $currentEntry->paused_at != null) {
        $currentEntry->resumed_at = Carbon::now();
        $currentEntry->paused_at = null;
        $currentEntry->save();
    }

    return $currentEntry ?? "{}";
});

Route::get('/latest-timer/stop', function (Request $request) {
    $currentEntry = GetCurrentEntry();

    if ($currentEntry->ended_at == null && $currentEntry->paused_at != null) {
        $currentEntry->ended_at = $currentEntry->resumed_at ?? Carbon::now();
        $currentEntry->paused_at = null;
        $currentEntry->save();
    }

    return $currentEntry ?? "{}";
});

function GetCurrentEntry() {
    return Timesheet::where('type', 'tracked')
        ->where('user_id', Auth::id())
        ->whereNull('ended_at')
        ->orderBy('created_at', 'desc')
        ->first();
}