<?php

namespace App\Http\Controllers\Doctor\V1;

use App\Http\Controllers\Controller;
use App\Services\MailingService;
use Illuminate\Http\Response;
use App\Http\Requests\Doctor\Mailing as R;
use Illuminate\Support\Facades\Log;

class MailingController extends Controller
{
    private $service;

    public function __construct(MailingService $service)
    {
        $this->service = $service;
    }

    /**
     * @SWG\Post(
     *   path="/v1/mailing/mass/create",
     *   summary="Mailing",
     *   tags={"mailing"},
     *   security={
     *      {"doctor_auth": {}}
     *   },
     *   @SWG\Parameter(
     *     required=true,
     *     name="body",
     *     in="body",
     *     description="Create Mass Mailing",
     *     required=true,
     *     @SWG\Schema(
     *       required={"text", "patients"},
     *       @SWG\Property(
     *         property="text",
     *         description="Text",
     *         type="string",
     *         example="test"
     *       ),
     *       @SWG\Property(
     *         property="file",
     *         description="File",
     *         type="object",
     *         @SWG\Property(property="id", type="integer", example=1),
     *       ),
     *       @SWG\Property(
     *           property="patients",
     *           description="Patients",
     *           type="array",
     *           @SWG\Items(
     *             @SWG\Property(property="id", type="integer", example=1),
     *           ),
     *         ),
     *     ),
     *   ),
     *   @SWG\Response(response=200, description="successful operation"),
     * )
     */
    public function massCreate(R\MassCreateRequest $request)
    {
        Log::channel('mailing')->info(
            PHP_EOL . '---------------------' . PHP_EOL .
            "Mailing Created" . PHP_EOL .
            "patients: " . json_encode(collect($request->input('patients'))->pluck('id')) . PHP_EOL .
            "content: {$request->get('text')}" . PHP_EOL .
            '---------------------'
        );

        $this->service->massCreate($request);

        return response()->json([
            'status_code' => 200
        ], Response::HTTP_OK);
    }

    /**
     * @SWG\Get(
     *   path="/v1/mailing/birthday/get",
     *   summary="Mailing",
     *   tags={"mailing"},
     *   security={
     *      {"doctor_auth": {}}
     *   },
     *   @SWG\Response(response=200, description="successful operation"),
     * )
     */
    public function birthdayGet(R\BirthdayGetRequest $request)
    {
        return response()->json([
            'response' => $this->service->birthdayGet(),
            'status_code' => 200
        ], Response::HTTP_OK);
    }

    /**
     * @SWG\Post(
     *   path="/v1/mailing/birthday/create",
     *   summary="Mailing",
     *   tags={"mailing"},
     *   security={
     *      {"doctor_auth": {}}
     *   },
     *   @SWG\Parameter(
     *     required=true,
     *     name="body",
     *     in="body",
     *     description="Create Birthday Mailing",
     *     required=true,
     *     @SWG\Schema(
     *       required={"content"},
     *       @SWG\Property(
     *         property="content",
     *         description="Content",
     *         type="string",
     *         example="test"
     *       ),
     *       @SWG\Property(
     *         property="file",
     *         description="File",
     *         type="object",
     *         @SWG\Property(property="id", type="integer", example=1),
     *       ),
     *     ),
     *   ),
     *   @SWG\Response(response=200, description="successful operation"),
     * )
     */
    public function birthdayCreate(R\BirthdayCreateRequest $request)
    {
        return response()->json([
            'response' => $this->service->birthdayCreate($request),
            'status_code' => 200
        ], Response::HTTP_OK);
    }

    /**
     * @SWG\Delete(
     *   path="/v1/mailing/birthday/delete",
     *   summary="Mailing",
     *   tags={"mailing"},
     *   security={
     *      {"doctor_auth": {}}
     *   },
     *   @SWG\Response(response=200, description="successful operation"),
     * )
     */
    public function birthdayDelete(R\BirthdayDeleteRequest $request)
    {
        $this->service->birthdayDelete();

        return response()->json([
            'status_code' => 200
        ], Response::HTTP_OK);
    }
}
