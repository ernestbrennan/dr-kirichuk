<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class PatientRegistered
{
    public function handle($request, Closure $next)
    {
        if (! $request->user() || !$request->user()->registered_at) {
            return abort(403, 'Patient not registered.');
        }

        return $next($request);
    }
}
