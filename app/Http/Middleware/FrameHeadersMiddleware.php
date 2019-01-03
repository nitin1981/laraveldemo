<?php

namespace App\Http\Middleware;

use Closure;

class FrameHeadersMiddleware
{
    public function __construct(){
        
        @selectDatabase();
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
         $response = $next($request);
         $response->headers->set('X-Frame-Options', 'ALLOW-FROM', 'https://payment.gst.gov.in/');
         return $response;
    }
}
