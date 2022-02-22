<?php

namespace App\Http\Controllers\Patient\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Patient\Auth as R;
use App\Services\PatientAuthService;
use Illuminate\Http\Response;

class RegistrationController extends Controller
{
    private $auth_service;

    public function __construct(PatientAuthService $auth_service)
    {
        $this->auth_service = $auth_service;
    }

    /**
     * @SWG\Post(
     *   path="/v1/auth/register",
     *   summary="Registration",
     *   tags={"auth"},
     *   security={
     *      {"patient_auth": {}}
     *   },
     *   @SWG\Parameter(
     *     required=true,
     *     name="body",
     *     in="body",
     *     description="Patient first name",
     *     required=true,
     *     @SWG\Schema(
     *       required={"first_name", "last_name", "birthday"},
     *       @SWG\Property(
     *         property="first_name",
     *         description="Patient first name",
     *         type="string",
     *         example="test"
     *       ),
     *       @SWG\Property(
     *         property="last_name",
     *         description="Patient last name",
     *         type="string",
     *         example="test"
     *       ),
     *       @SWG\Property(
     *         property="birthday",
     *         description="Patient birthday",
     *         type="string",
     *         example="2000-02-27 00:00:00"
     *       ),
     *       @SWG\Property(
     *         property="avatar",
     *         description="File",
     *         type="object",
     *         @SWG\Property(property="id", type="integer", example=1),
     *       ),
     *       @SWG\Property(
     *         property="cities",
     *         description="Patient cities",
     *         type="array",
     *         @SWG\Items(
     *            @SWG\Property(property="id", type="integer", example=1),
     *         ),
     *       ),
     *     ),
     *   ),
     * @SWG\Response(response=200, description="successful operation"),
     * )
     */
    public function index(R\RegistrationRequest $request)
    {
        $this->auth_service->register($request);

        return response()->json([
            'message' => trans('auth.on_register_success'),
            'status_code' => 200
        ], Response::HTTP_OK);

    }
}
