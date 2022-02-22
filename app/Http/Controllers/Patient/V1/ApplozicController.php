<?php

namespace App\Http\Controllers\Patient\V1;

use App\Applozic\Facades\Applozic;
use App\Http\Controllers\Controller;
use App\Services\CityService;
use Illuminate\Http\Response;
use App\Http\Requests\Patient\Applozic as R;

class ApplozicController extends Controller
{
    private $service;

    public function __construct(CityService $service)
    {
        $this->service = $service;
    }

    /**
     * @SWG\Delete(
     *   path="/v1/applozic/message/delete",
     *   summary="Cities",
     *   tags={"applozic"},
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
     *       required={"key"},
     *       @SWG\Property(
     *         property="doctor_key",
     *         description="Message key",
     *         type="string",
     *         example="5-35c2957b-8de0-482b-bea9-7c5c2e1dd2f4-1452080064726"
     *       ),
     *       @SWG\Property(
     *         property="patient_key",
     *         description="Message key",
     *         type="string",
     *         example="5-35c2957b-8de0-482b-bea9-7c5c2e1dd2f4-1452080064726"
     *       ),
     *     ),
     *   ),
     *   @SWG\Response(response=200, description="successful operation"),
     * )
     */
    public function deleteMessage(R\DeleteMessageRequest $request)
    {
        Applozic::via('patient')->deleteMessage($request->input('patient_key'));
        Applozic::via('doctor')->deleteMessage($request->input('doctor_key'));

        return response()->json([
            'status_code' => 200
        ], Response::HTTP_OK);
    }
}
