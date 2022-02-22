<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class PatientAuthenticate extends Middleware
{
    protected function authenticate($request, array $guards)
    {
        if ($this->auth->guard('patient')->check()) {
            return $this->auth->shouldUse('patient');
        }

        throw new UnauthorizedHttpException('jwt-auth', '', null, 401);
    }
}
