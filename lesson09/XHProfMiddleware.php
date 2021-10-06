<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class XHProfMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        xhprof_enable(XHPROF_FLAGS_MEMORY);
        return $next($request);
    }

    public function terminate($request, $response)
    {
        $xhprofData = xhprof_disable();

        include_once '/var/www/xhprof/xhprof_lib/utils/xhprof_lib.php';
        include_once '/var/www/xhprof/xhprof_lib/utils/xhprof_runs.php';

        $run_id = (new \XHProfRuns_Default())->save_run($xhprofData, str_replace(['/', '.'], '_', $request->path()));
    }
}
