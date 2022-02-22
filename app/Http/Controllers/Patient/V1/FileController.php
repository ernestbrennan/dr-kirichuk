<?php

namespace App\Http\Controllers\Patient\V1;

use App\Http\Controllers\Controller;
use App\Services\FileService;
use Illuminate\Http\Response;
use App\Http\Requests\Patient\File as R;

class FileController extends Controller
{
    private $service;

    public function __construct(FileService $service)
    {
        $this->service = $service;
    }

    /**
     * @SWG\Post(
     *   path="/v1/file/upload",
     *   summary="File",
     *   tags={"file"},
     *   security={
     *      {"patient_auth": {}}
     *   },
     *   @SWG\Parameter(
     *     name="file",
     *     in="formData",
     *     description="File",
     *     type="file",
     *   ),
     *   @SWG\Response(response=200, description="successful operation"),
     * )
     */
    public function upload(R\UploadRequest $request)
    {
        return response()->json([
            'response' => $this->service->upload($request),
            'status_code' => 200
        ], Response::HTTP_OK);
    }

    /**
     * @SWG\Delete(
     *   path="/v1/file/delete",
     *   summary="File",
     *   tags={"file"},
     *   security={
     *      {"patient_auth": {}}
     *   },
     *   @SWG\Parameter(
     *     name="id",
     *     in="formData",
     *     description="File id",
     *     type="integer",
     *     @SWG\Property(property="request", type="json", example="1")
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
