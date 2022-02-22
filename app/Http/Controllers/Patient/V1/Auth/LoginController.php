<?php

namespace App\Http\Controllers\Patient\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Patient\Auth as R;
use App\Services\PatientAuthService;
use Illuminate\Http\Response;

class LoginController extends Controller
{
    private $auth_service;

    public function __construct(PatientAuthService $auth_service)
    {
        $this->auth_service = $auth_service;
    }

    /**
     * @SWG\Post(
     *   path="/v1/auth/login",
     *   summary="Login",
     *   tags={"auth"},
     * @SWG\Parameter(
     *     name="phone",
     *     in="query",
     *     description="User phone",
     *     required=true,
     *     type="string",
     *     @SWG\Property(property="request", type="json", example="380999999999")
     *   ),
     * @SWG\Response(response=200, description="successful operation"),
     * )
     */
    public function login(R\LoginRequest $request)
    {
        $patient = $this->auth_service->login($request);

        return response()->json([
            'message' => trans('auth.on_login_success'),
            'response' => $patient->verify_code,
            'status_code' => 200
        ], Response::HTTP_OK);
    }

    /**
     * @SWG\Post(
     *   path="/v1/auth/verify",
     *   summary="Registration",
     *   tags={"auth"},
     * @SWG\Parameter(
     *     name="code",
     *     in="query",
     *     description="Patient verification code",
     *     required=true,
     *     type="string",
     *     @SWG\Property(property="request", type="json", example="1234")
     *   ),
     * @SWG\Response(response=200, description="successful operation"),
     * )
     */
    public function verify(R\VerifyRequest $request)
    {
        $token = $this->auth_service->verify($request);
        $patient = $this->auth_service->getUser();

        return response()->json([
            'message' => trans('auth.on_verify_success'),
            'response' => [
                'token' => $token,
                'registered' => !is_null($patient->registered_at)
            ],
            'status_code' => 200
        ], Response::HTTP_OK)->header('Authorization', $token);
    }

    /**
     * @SWG\Post(
     *   path="/v1/auth/logout",
     *   summary="Logout",
     *   tags={"auth"},
     *   security={
     *    {"patient_auth": {}}
     *   },
     *  @SWG\Response(response=200, description="successful operation"),
     * )
     */
    public function logout()
    {
        $this->auth_service->logout();

        return response()->json([
            'message' => trans('auth.on_logout_success'),
            'status_code' => 200
        ], Response::HTTP_OK);
    }
}
