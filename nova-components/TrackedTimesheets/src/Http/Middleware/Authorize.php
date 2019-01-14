<?php

namespace Senexis\TrackedTimesheets\Http\Middleware;

use Senexis\TrackedTimesheets\TrackedTimesheets;

class Authorize
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response
     */
    public function handle($request, $next)
    {
        return resolve(TrackedTimesheets::class)->authorize($request) ? $next($request) : abort(403);
    }
}
