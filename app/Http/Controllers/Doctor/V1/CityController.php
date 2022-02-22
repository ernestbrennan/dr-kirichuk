<?php

namespace App\Http\Controllers\Doctor\V1;

use App\Http\Controllers\Controller;
use App\Services\CityService;
use Illuminate\Http\Response;
use App\Http\Requests\Doctor\City as R;

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
     *      {"doctor_auth": {}}
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
    public function getList(R\GetListRequest $request)
    {
        return response()->json([
            'response' => $this->service->getList($request),
            'status_code' => 200
        ], Response::HTTP_OK);
    }
}
