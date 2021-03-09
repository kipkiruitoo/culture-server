<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckIfAppTraffic
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
        if ($request->has('token')) {
            $token = $request->token;

            // check if user exists with that token

            $ex = User::whereHas('tokens', function ($query) use (&$token) {
                $query->where('token', $token);
            })->exists();

            // dd($ex);
            if ($ex) {
                $user = User::whereHas('tokens', function ($query) use (&$token) {
                    $query->where('token', $token);
                })->first();

                Auth::login($user);


                return redirect()->route('profile.show');
            } else {
                return $next($request);
            }
        } else {
        }
    }
}
