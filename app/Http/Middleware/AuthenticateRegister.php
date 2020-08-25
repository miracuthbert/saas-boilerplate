<?php

namespace SAASBoilerplate\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthenticateRegister
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!auth()->check()) {
            session()->put('url.intended', $request->url());

            return redirect()->route('register');
        }

        return $next($request);
    }
}
