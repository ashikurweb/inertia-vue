<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DelayResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  int|null  $seconds
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $seconds = null)
    {
        // Get delay from query parameter or use the provided default
        $delay = $request->query('delay', $seconds);
        
        // Convert to integer and ensure it's not negative
        $delay = max(0, (int) $delay);
        
        if ($delay > 0) {
            sleep($delay);
        }
        
        return $next($request);
    }
}
