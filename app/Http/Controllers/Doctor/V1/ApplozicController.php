<?php

namespace App\Http\Controllers\Doctor\V1;

use App\Applozic\Facades\Applozic;
use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Services\CityService;
use Illuminate\Http\Response;
use App\Http\Requests\Doctor\Applozic as R;

class ApplozicController extends Controller
{
    /**
     * @SWG\Delete(
     *   path="/v1/applozic/message/delete",
     *   summary="Cities",
     *   tags={"applozic"},
     *   security={
     *      {"doctor_auth": {}}
     *   },
     *   @SWG\Parameter(
     *     required=true,
     *     name="body",
     *     in="body",
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
     *       @SWG\Property(
     *         property="patient_id",
     *         description="Patient id",
     *         type="integer",
     *         example=1
     *       ),
     *     ),
     *   ),
     *   @SWG\Response(response=200, description="successful operation"),
     * )
     */
    public function deleteMessage(R\DeleteMessageRequest $request)
    {
        Applozic::via('doctor')->deleteMessage($request->get('doctor_key'));
        Applozic::via('patient', Patient::find($request->get('patient_id')))->deleteMessage($request->get('patient_key'));

        return response()->json([
            'status_code' => 200
        ], Response::HTTP_OK);
    }
}
