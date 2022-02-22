<?php

namespace App\Http\Controllers\Patient\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Patient\Profile as R;
use App\Services\PatientService;
use Illuminate\Http\Response;

class ProfileController extends Controller
{
    private $service;

    public function __construct(PatientService $service)
    {
        $this->service = $service;
    }

    /**
     * @SWG\Get(
     *   path="/v1/profile/show",
     *   summary="Show profile",
     *   tags={"profile"},
     *   security={
     *      {"patient_auth": {}}
     *   },
     *   @SWG\Response(response=200, description="successful operation"),
     * )
     */
    public function show()
    {
        return response()->json([
            'response' => $this->service->profile(),
            'status_code' => 200
        ], Response::HTTP_OK);
    }

    /**
     * @SWG\Patch(
     *   path="/v1/profile/update",
     *   summary="Update profile",
     *   tags={"profile"},
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
     *         property="phone",
     *         description="Patient phone",
     *         type="string",
     *         example="380999999999"
     *       ),
     *        @SWG\Property(
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
     *   @SWG\Response(response=200, description="successful operation"),
     * )
     */
    public function update(R\UpdateRequest $request)
    {
        return response()->json([
            'response' => $this->service->update($request),
            'status_code' => 200
        ], Response::HTTP_OK);
    }


    /**
     * @SWG\Post(
     *   path="/v1/profile/remove-avatar",
     *   summary="Remove avatar",
     *   tags={"profile"},
     *   security={
     *      {"patient_auth": {}}
     *   },
     *   @SWG\Response(response=200, description="successful operation"),
     * )
     */
    public function removeAvatar()
    {
        $this->service->removeAvatar();

        return response()->json([
            'status_code' => 200
        ], Response::HTTP_OK);
    }


}
