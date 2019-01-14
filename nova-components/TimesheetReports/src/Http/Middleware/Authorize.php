<?php

namespace Senexis\TimesheetReports\Http\Middleware;

use Senexis\TimesheetReports\TimesheetReports;

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
        return resolve(TimesheetReports::class)->authorize($request) ? $next($request) : abort(403);
    }
}
