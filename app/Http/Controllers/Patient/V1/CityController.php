<?php

namespace App\Http\Controllers\Patient\V1;

use App\Http\Controllers\Controller;
use App\Services\CityService;
use Illuminate\Http\Response;
use App\Http\Requests\Patient\City as R;

class CityController extends Controller
{
    private $service;

    public function __construct(CityService $service)
    {
        $this->service = $service;
    }

    /**
     * @SWG\Get(
     *   path="/v1/city/list",
     *   summary="Cities",
     *   tags={"city"},
     *   security={
     *      {"patient_auth": {}}
     *   },
     *   @SWG\Parameter(
     *     name="search",
     *     in="query",
     *     description="Search by name",
     *     type="string",
     *     @SWG\Property(property="request", type="json")
     *   ),
     *   @SWG\Response(response=200, description="successful operation"),
     * )
     */
    public function getList(R\GetArchiveListRequest $request)
    {
        return response()->json([
            'response' => $this->service->getList($request),
            'status_code' => 200
        ], Response::HTTP_OK);
    }
    /**
     * @SWG\Post(
     *   path="/v1/city/create",
     *   summary="Cities",
     *   tags={"city"},
     *   security={
     *      {"patient_auth": {}}
     *   },
     *   @SWG\Parameter(
     *     name="city_archive_id",
     *     in="query",
     *     description="City archive id",
     *     required=true,
     *     type="string",
     *     @SWG\Property(property="request", type="json", example="123")
     *   ),
     *
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
     * @SWG\Get(
     *   path="/v1/city/archive/list",
     *   summary="Cities",
     *   tags={"city"},
     *   security={
     *      {"patient_auth": {}}
     *   },
     *   @SWG\Parameter(
     *     name="search",
     *     in="query",
     *     description="Search by name",
     *     type="string",
     *     @SWG\Property(property="request", type="json")
     *   ),
     *   @SWG\Response(response=200, description="successful operation"),
     * )
     */
    public function getArchiveList(R\GetArchiveListRequest $request)
    {
        return response()->json([
            'response' => $this->service->getArhiveList($request),
            'status_code' => 200
        ], Response::HTTP_OK);
    }

}
