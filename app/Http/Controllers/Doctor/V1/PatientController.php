<?php

namespace App\Http\Controllers\Doctor\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\Patient as R;
use App\Services\PatientDoctorService;

class PatientController extends Controller
{
    private $service;

    public function __construct(PatientDoctorService $service)
    {
        $this->service = $service;
    }

    /**
     * @SWG\Post(
     *   path="/v1/patient/list",
     *   summary="Get list",
     *   tags={"patient"},
     *   security={
     *     {"doctor_auth": {}}
     *   },
     *   @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     description="Patient list filters",
     *     required=true,
     *     @SWG\Schema(ref="#/definitions/PatientListFilters"),
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
        ], 200);
    }

    /**
     * @SWG\Get(
     *   path="/v1/patient/by-id",
     *   summary="Find by id",
     *   tags={"patient"},
     *   security={
     *      {"doctor_auth": {}}
     *   },
     *   @SWG\Parameter(
     *     name="id",
     *     in="query",
     *     description="Patient id",
     *     required=true,
     *     type="integer",
     *     @SWG\Property(property="request", type="json", example="1")
     *   ),
     *    @SWG\Response(response=200, description="successful operation"),
     * )
     */
    public function getById(R\ByIdRequest $request)
    {
        return response()->json([
            'response' => $this->service->getById($request),
            'status_code' => 200
        ], 200);
    }

    /**
     * @SWG\Post(
     *   path="/v1/patient/add-comment",
     *   summary="Add comment",
     *   tags={"patient"},
     *   security={
     *      {"doctor_auth": {}}
     *   },
     *   @SWG\Parameter(
     *     name="id",
     *     in="query",
     *     description="Patient id",
     *     required=true,
     *     type="integer",
     *     @SWG\Property(property="request", type="json", example="1")
     *   ),
     *   @SWG\Parameter(
     *     name="comment",
     *     in="query",
     *     description="Comment",
     *     type="string",
     *     @SWG\Property(property="request", type="json", example="comment")
     *   ),
     *    @SWG\Response(response=200, description="successful operation"),
     * )
     */
    public function addComment(R\AddCommentRequest $request)
    {
        $this->service->addComment($request);

        return response()->json(['status_code' => 200], 200);
    }
}
