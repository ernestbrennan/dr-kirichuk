<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class DoctorAuthenticate extends Middleware
{
    protected function authenticate($request, array $guards)
    {
        if ($this->auth->guard('doctor')->check()) {
            return $this->auth->shouldUse('doctor');
        }

        throw new UnauthorizedHttpException('jwt-auth', '', null, 401);
    }
}
