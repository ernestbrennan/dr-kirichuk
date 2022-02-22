<?php

namespace App\Http\Controllers\Doctor\V1;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use Illuminate\Http\Response;
use App\Http\Requests\Doctor\Fcm as R;

class FCMController extends Controller
{
    /**
     * @SWG\Post(
     *   path="/v1/fcm/save-token",
     *   summary="FCM",
     *   tags={"fcm"},
     *   security={
     *      {"doctor_auth": {}}
     *   },
     *   @SWG\Parameter(
     *     required=true,
     *     name="body",
     *     in="body",
     *     required=true,
     *     @SWG\Schema(
     *       required={"token"},
     *       @SWG\Property(
     *         property="token",
     *         description="Fcm token",
     *         type="string",
     *         example="5-35c2957b-8de0-482b-bea9-7c5c2e1dd2f4-1452080064726"
     *       ),
     *     ),
     *   ),
     *   @SWG\Response(response=200, description="successful operation"),
     * )
     */
    public function saveToken(R\SaveTokenRequest $request)
    {
        Doctor::first()->update([
            'fcm_token' => $request->get('token')
        ]);

        return response()->json([
            'status_code' => 200
        ], Response::HTTP_OK);
    }
}
