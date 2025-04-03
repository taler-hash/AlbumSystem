<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CorsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
       /* @var $response Response */
       $response = $next($request);
       if (!$request->isMethod('OPTIONS')) {
           return $response;
       }
       $allow = $response->headers->get('Allow'); // true list of allowed methods
       if (!$allow) {
           return $response;
       }
       $headers = [
           'Access-Control-Allow-Methods' => $allow,
           'Access-Control-Max-Age' => 3600,
           'Access-Control-Allow-Headers' => 'X-Requested-With, Origin, X-Csrftoken, Content-Type, Accept',
           'Access-Control-Allow-Origin' => 'http://localhost:5173'
       ];
       return $response->withHeaders($headers);
        return $response;    
    }
}
