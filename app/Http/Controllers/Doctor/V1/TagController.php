<?php

namespace App\Http\Controllers\Doctor\V1;

use App\Http\Controllers\Controller;
use App\Services\TagService;
use Illuminate\Http\Response;
use App\Http\Requests\Doctor\City as R;

class TagController extends Controller
{
    private $service;

    public function __construct(TagService $service)
    {
        $this->service = $service;
    }

    /**
     * @SWG\Get(
     *   path="/v1/tag/list",
     *   summary="Tags",
     *   tags={"tag"},
     *   security={
     *      {"doctor_auth": {}}
     *   },
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
