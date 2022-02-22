<?php

namespace App\Http\Controllers\Doctor\V1;

use App\Http\Controllers\Controller;
use App\Services\NotificationService;
use Illuminate\Http\Response;
use App\Http\Requests\Doctor\Notification as R;

class NotificationController extends Controller
{
    private $service;

    public function __construct(NotificationService $service)
    {
        $this->service = $service;
    }

    /**
     * @SWG\Get(
     *   path="/v1/notification/list",
     *   summary="Notificaitons",
     *   tags={"notification"},
     *   security={
     *      {"doctor_auth": {}}
     *   },
     *  @SWG\Parameter(
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
     *   path="/v1/notification/read",
     *   summary="Notificaitons",
     *   tags={"notification"},
     *   security={
     *      {"doctor_auth": {}}
     *   },
     *  @SWG\Parameter(
     *     name="id",
     *     in="query",
     *     description="Notification id",
     *     type="integer",
     *     @SWG\Property(property="request", type="json", example=1)
     *   ),
     *   @SWG\Response(response=200, description="successful operation"),
     * )
     */
    public function read(R\ReadRequest $request)
    {
        $this->service->read($request);

        return response()->json([
            'status_code' => 200
        ], Response::HTTP_OK);
    }
}
