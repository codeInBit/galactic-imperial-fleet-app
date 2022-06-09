<?php

namespace App\Traits;

use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Helpers\DatatableForResource;
use Illuminate\Http\JsonResponse;
use Exception;
use Throwable;

trait ApiJsonResponse
{
    /**
     * @param mixed $data
     * @param mixed $message
     * @param int $statusCode
     * @return JsonResponse
     */
    public function successResponse($data = null, $message = "Successful", $statusCode = Response::HTTP_OK): JsonResponse
    {
        $response = null;
        if ($data) {
            $response["data"] = $data;
        }
        return response()->json($response, $statusCode);
    }

    public function searchableResponse($query, string $resources, array $config = [])
    {
        $data = DatatableForResource::make($query, $resources, $config);

        if ($data instanceof BinaryFileResponse) {
            return $data;
        }

        $response = null;
        if ($data) {
            $response["data"] = $data['data']['data'];
            $response["metadata"] = $data['metadata'];
        }
        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * @param string $data
     * @param mixed $message
     * @param int $statusCode
     * @return JsonResponse
     */
    public function errorResponse($data = null, $message = null, $statusCode = Response::HTTP_BAD_REQUEST): JsonResponse
    {
        $response = [
            "success" => false,
            "message" => $message,
        ];

        if ($data) {
            $response["data"] = $data;
        }
        return response()->json($response, $statusCode);
    }

    /**
     * @param Exception $e
     * @param int $statusCode
     * @return JsonResponse
     */
    public function fatalErrorResponse(Exception $e, $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR): JsonResponse
    {
        $line = $e->getTrace();

        $error = [
            "message" => $e->getMessage(),
            "trace" => $line[0],
            "mini_trace" => $line[1]
        ];

        if (config("app.debug") == false) {
            $error = null;
        }

        $response = [
            "success" => false,
            "message" => "Oops! Something went wrong on the server",
            "error" => $error
        ];
        return response()->json($response, $statusCode);
    }

    /**
     * @param Throwable $e
     * @param int $statusCode
     * @return JsonResponse
     */
    public function throwableFatalErrorResponse(Throwable $e, $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR): JsonResponse
    {
        $line = $e->getTrace();

        $error = [
            "message" => $e->getMessage(),
            "trace" => $line[0],
            "mini_trace" => $line[1]
        ];

        if (config("app.debug") == false) {
            $error = null;
        }

        $response = [
            "success" => false,
            "message" => "Oops! Something went wrong on the server",
            "error" => $error
        ];
        return response()->json($response, $statusCode);
    }
}
