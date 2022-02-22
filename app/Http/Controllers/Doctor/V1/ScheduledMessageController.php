<?php

namespace App\Http\Controllers\Doctor\V1;

use App\Http\Controllers\Controller;
use App\Services\ScheduledMessageService;
use Illuminate\Http\Response;
use App\Http\Requests\Doctor\ScheduledMessage as R;

class ScheduledMessageController extends Controller
{
    private $service;

    public function __construct(ScheduledMessageService $service)
    {
        $this->service = $service;
    }

    /**
     * @SWG\Get(
     *   path="/v1/scheduled-message/list",
     *   summary="ScheduledMessage",
     *   tags={"scheduled_message"},
     *   security={
     *      {"doctor_auth": {}}
     *   },
     *   @SWG\Parameter(
     *     name="patient_id",
     *     in="query",
     *     description="Patient id",
     *     type="integer",
     *     @SWG\Property(property="request", type="json", example=1)
     *   ),
     *   @SWG\Parameter(
     *     name="page",
     *     in="query",
     *     description="Page",
     *     type="integer",
     *     @SWG\Property(property="request", type="json", example=1)
     *   ),
     *   @SWG\Parameter(
     *     name="per_page",
     *     in="query",
     *     description="Per page",
     *     type="integer",
     *     @SWG\Property(property="request", type="json", example=15)
     *   ),
     *   @SWG\Response(response=200, description="successful operation"),
     * )
     */
    public function getList(R\GetListRequest $request)
    {
        return response()->json([
            'response' => $this->service->getList($request),
            'status_code' => 200
        ], Response::HTTP_OK);
    }

    /**
     * @SWG\Post(
     *   path="/v1/scheduled-message/create",
     *   summary="ScheduledMessage",
     *   tags={"scheduled_message"},
     *   security={
     *      {"doctor_auth": {}}
     *   },
     *   @SWG\Parameter(
     *     required=true,
     *     name="body",
     *     in="body",
     *     description="Create Scheduled Message",
     *     required=true,
     *     @SWG\Schema(
     *       required={"patient_id", "content", "date"},
     *       @SWG\Property(
     *         property="patient_id",
     *         description="Patient Id",
     *         type="string",
     *         example=1
     *       ),
     *       @SWG\Property(
     *         property="content",
     *         description="Content",
     *         type="string",
     *         example="test"
     *       ),
     *       @SWG\Property(
     *         property="date",
     *         description="date",
     *         type="string",
     *         example="2020-08-04 00:00:00",
     *       ),
     *     ),
     *   ),
     *   @SWG\Response(response=200, description="successful operation"),
     * )
     */
    public function create(R\CreateRequest $request)
    {
        return response()->json([
            'response' => $this->service->create($request),
            'status_code' => 200
        ], Response::HTTP_OK);
    }

    /**
     * @SWG\Patch(
     *   path="/v1/scheduled-message/update",
     *   summary="ScheduledMessage",
     *   tags={"scheduled_message"},
     *   security={
     *      {"doctor_auth": {}}
     *   },
     *   @SWG\Parameter(
     *     required=true,
     *     name="body",
     *     in="body",
     *     description="Update Scheduled Message",
     *     required=true,
     *     @SWG\Schema(
     *       required={"id", "content", "date"},
     *       @SWG\Property(
     *         property="id",
     *         description="Id",
     *         type="integer",
     *         example=1
     *       ),
     *       @SWG\Property(
     *         property="content",
     *         description="Content",
     *         type="string",
     *         example="test"
     *       ),
     *       @SWG\Property(
     *         property="date",
     *         description="date",
     *         type="string",
     *         example="2020-08-04 00:00:00",
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
     * @SWG\Delete(
     *   path="/v1/scheduled-message/delete",
     *   summary="ScheduledMessage",
     *   tags={"scheduled_message"},
     *   security={
     *      {"doctor_auth": {}}
     *   },
     *   @SWG\Parameter(
     *     name="id",
     *     in="query",
     *     description="Id",
     *     type="integer",
     *     @SWG\Property(property="request", type="json", example=1)
     *   ),
     *   @SWG\Response(response=200, description="successful operation"),
     * )
     */
    public function delete(R\DeleteRequest $request)
    {
        $this->service->delete($request);

        return response()->json([
            'status_code' => 200
        ], Response::HTTP_OK);
    }

}
