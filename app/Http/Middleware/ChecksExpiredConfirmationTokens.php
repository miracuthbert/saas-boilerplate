<?php

namespace SAASBoilerplate\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ChecksExpiredConfirmationTokens
{
    /**
     * Handle an incoming request.
     *
     * @param  Request $request
     * @param  Closure  $next
     * @param $redirect
     * @return mixed
     */
    public function handle($request, Closure $next, $redirect)
    {
        //check if token has expired and rdirect to passed url
        if ($request->confirmation_token->hasExpired()) {
            return redirect($redirect)
                ->withErrors(['Token expired.']);
        }

        return $next($request);
    }
}
