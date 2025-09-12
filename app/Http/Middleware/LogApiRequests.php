<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogApiRequests
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
        $startTime = microtime(true);
        
        $response = $next($request);
        
        $endTime = microtime(true);
        $duration = round(($endTime - $startTime) * 1000, 2); // in milliseconds
        
        $logData = [
            'method' => $request->method(),
            'uri' => $request->path(),
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'user_id' => $request->user() ? $request->user()->id : null,
            'status_code' => $response->status(),
            'duration_ms' => $duration,
            'request_headers' => $request->headers->all(),
            'request_params' => $request->all(),
        ];
        
        // Log the request details
        Log::channel('api')->info('API Request', $logData);
        
        return $response;
    }
}
