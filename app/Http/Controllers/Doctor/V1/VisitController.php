<?php

namespace App\Http\Controllers\Doctor\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\Visit as R;
use App\Services\DoctorVisitService;

class VisitController extends Controller
{
    private $service;

    public function __construct(DoctorVisitService $service)
    {
        $this->service = $service;
    }

    /**
     * @SWG\Get(
     *   path="/v1/visit/by-id",
     *   summary="Find by id",
     *   tags={"visit"},
     *   security={
     *      {"doctor_auth": {}}
     *   },
     * @SWG\Parameter(
     *     name="id",
     *     in="query",
     *     description="Visit id",
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
     * @SWG\Get(
     *   path="/v1/visit/list",
     *   summary="Get list",
     *   tags={"visit"},
     *   security={
     *     {"doctor_auth": {}}
     *   },
     *   @SWG\Parameter(
     *     name="patient_id",
     *     in="query",
     *     description="Patient id",
     *     required=true,
     *     type="integer",
     *     @SWG\Property(property="request", type="json", example="1")
     *   ),
     *   @SWG\Parameter(
     *     name="page",
     *     in="query",
     *     description="Page",
     *     required=true,
     *     type="integer",
     *     @SWG\Property(property="request", type="json", example="1")
     *   ),
     *   @SWG\Parameter(
     *     name="per_page",
     *     in="query",
     *     description="Per page",
     *     required=true,
     *     type="integer",
     *     @SWG\Property(property="request", type="json", example="15")
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
     * @SWG\Post(
     *   path="/v1/visit/create",
     *   summary="Create",
     *   tags={"visit"},
     *   security={
     *     {"doctor_auth": {}}
     *   },
     *   @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     description="Visit",
     *     required=true,
     *     @SWG\Schema(
     *       required={"patient_id", "date"},
     *       @SWG\Property(
     *         property="patient_id",
     *         description="Patient id",
     *         type="integer",
     *         example=1,
     *       ),
     *       @SWG\Property(
     *         property="date",
     *         description="Visit date",
     *         type="string",
     *         example="2020-08-04 00:00:00"
     *       ),
     *       @SWG\Property(
     *         property="prescription",
     *         description="Visit prescription",
     *         type="string",
     *         example="prescription"
     *       ),
     *       @SWG\Property(
     *         property="recommendation",
     *         description="Visit recommendations",
     *         type="string",
     *         example="recommendation"
     *       ),
     *       @SWG\Property(
     *         property="private_comment",
     *         description="Private Comment",
     *         type="string",
     *         example="Private Comment"
     *       ),
     *       @SWG\Property(
     *         property="doctor_comment",
     *         description="Doctor Comment",
     *         type="object",
     *         @SWG\Property(property="content", type="string", example="content"),
     *         @SWG\Property(
     *           property="files",
     *           description="Doctor comment file",
     *           type="array",
     *           @SWG\Items(
     *             @SWG\Property(property="id", type="integer", example=1),
     *           ),
     *         ),
     *       ),
     *       @SWG\Property(
     *         property="tag_ids",
     *         description="Tag Ids",
     *         type="array",
     *         @SWG\Items(type="integer", example=1),
     *       ),
     *       @SWG\Property(
     *         property="scheduled_message",
     *         description="Scheduled message",
     *         type="object",
     *         @SWG\Property(property="content", type="string", example="content"),
     *         @SWG\Property(property="date", type="string", example="2020-08-04 00:00:00")
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
        ], 200);
    }

    /**
     * @SWG\Patch(
     *   path="/v1/visit/update",
     *   summary="Update",
     *   tags={"visit"},
     *   security={
     *     {"doctor_auth": {}}
     *   },
     *   @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     description="Visit",
     *     required=true,
     *     @SWG\Schema(
     *       required={"id", "date", "doctor_comment"},
     *       @SWG\Property(
     *         property="id",
     *         description="Visit id",
     *         type="integer",
     *         example=1,
     *       ),
     *       @SWG\Property(
     *         property="date",
     *         description="Visit date",
     *         type="string",
     *         example="2020-08-04 00:00:00"
     *       ),
     *       @SWG\Property(
     *         property="prescription",
     *         description="Visit prescription",
     *         type="string",
     *         example="prescription"
     *       ),
     *       @SWG\Property(
     *         property="recommendation",
     *         description="Visit recommendations",
     *         type="string",
     *         example="recommendation"
     *       ),
     *       @SWG\Property(
     *         property="private_comment",
     *         description="Private Comment",
     *         type="string",
     *         example="Private Comment"
     *       ),
     *       @SWG\Property(
     *         property="doctor_comment",
     *         description="Doctor Comment",
     *         type="object",
     *         @SWG\Property(property="content", type="string", example="content"),
     *         @SWG\Property(
     *           property="files",
     *           description="Doctor comment file",
     *           type="array",
     *           @SWG\Items(
     *             @SWG\Property(property="id", type="integer", example=1),
     *           ),
     *         ),
     *       ),
     *       @SWG\Property(
     *         property="tag_ids",
     *         description="Tag Ids",
     *         type="array",
     *         @SWG\Items(type="integer", example=1),
     *       ),
     *       @SWG\Property(
     *         property="scheduled_message",
     *         description="Scheduled message",
     *         type="object",
     *         @SWG\Property(property="content", type="string", example="content"),
     *         @SWG\Property(property="date", type="string", example="2020-08-04 00:00:00"),
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
        ], 200);
    }

    /**
     * @SWG\Post(
     *   path="/v1/visit/private-comment",
     *   summary="Add or update private comment",
     *   tags={"visit"},
     *   security={
     *      {"doctor_auth": {}}
     *   },
     * @SWG\Parameter(
     *     name="id",
     *     in="query",
     *     description="Visit id",
     *     required=true,
     *     type="integer",
     *     @SWG\Property(property="request", type="json", example="1")
     *   ),
     * @SWG\Parameter(
     *     name="comment",
     *     in="query",
     *     description="Comment",
     *     type="string",
     *     @SWG\Property(property="request", type="json", example="Comment")
     *   ),
     *    @SWG\Response(response=200, description="successful operation"),
     * )
     */
    public function privateComment(R\PrivateCommentRequest $request)
    {
        return response()->json([
            'response' => $this->service->privateComment($request),
            'status_code' => 200
        ], 200);
    }

    /**
     * @SWG\Delete(
     *   path="/v1/visit/delete",
     *   summary="Delete",
     *   tags={"visit"},
     *   security={
     *      {"doctor_auth": {}}
     *   },
     *   @SWG\Parameter(
     *     name="id",
     *     in="query",
     *     description="Visit id",
     *     required=true,
     *     type="integer",
     *     @SWG\Property(property="request", type="json", example="1")
     *   ),
     *   @SWG\Response(response=200, description="successful operation"),
     * )
     */
    public function delete(R\DeleteRequest $request)
    {
        $this->service->delete($request);

        return response()->json(['status_code' => 200], 200);
    }
}
