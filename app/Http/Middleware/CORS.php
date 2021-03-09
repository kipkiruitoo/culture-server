<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode as Middleware;
use Closure;
use Illuminate\Support\Facades\Response;

class CORS extends Middleware
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $origin = $request->header('origin');
        $origin = $origin ?? '*';

        // ALLOW OPTIONS METHOD
        $headers = [
            'Access-Control-Allow-Origin' => $origin,
            'Access-Control-Allow-Methods' => 'GET, POST, DELETE, PUT, OPTIONS, HEAD, PATCH',
            'Access-Control-Allow-Headers' => 'Authorization,DNT,X-CustomHeader,Keep-Alive,User-Agent,X-Requested-With,If-Modified-Since,Cache-Control,Content-Type,Set-Cookie',
            'Access-Control-Allow-Credentials' => 'true',
            'Cache-Control' => 'nocache, no-store, max-age=0, must-revalidate',
            'Pragma', 'no-cache',
            'Expires', 'Fri, 01 Jan 1990 00:00:00 GMT',
        ];

        if ($request->getMethod() == "OPTIONS") {
            // The client-side application can set only headers allowed in Access-Control-Allow-Headers
            return Response::make('OK', 200, $headers);
        }

        $response = $next($request);

        // foreach ($headers as $key => $value) {
        //     $response->header($key, $value);
        // }
        return $response;
    }
}
