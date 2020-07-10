<?php


namespace Iyngaran\ApiResponse\Http\Traits;


use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Resources\Json\ResourceCollection;

trait ApiResponse
{
    private $_code_wrong_args = 'WRONG_ARGS';
    private $_code_not_found = 'NOT_FOUND';
    private $_code_internal_error = 'INTERNAL_ERROR';
    private $_code_unauthorized = 'UNAUTHORIZED_ACCESS';
    private $_code_forbidden = 'FORBIDDEN';

    /**
     * Resource was successfully created
     *
     * @param $data
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createdResponse(JsonResource $jsonResource)
    {
        return $this->responseWithItem($jsonResource, Response::HTTP_CREATED);
    }

    protected function updatedResponse(JsonResource $jsonResource)
    {
        return $this->responseWithItem($jsonResource, Response::HTTP_OK);
    }

    protected function deletedResponse()
    {
        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    protected function responseWithItem(JsonResource $jsonResource, $statusCode = Response::HTTP_OK)
    {
        return ($jsonResource)
            ->response()
            ->setStatusCode($statusCode);
    }

    protected function responseWithCollection(ResourceCollection $resourceCollection, $statusCode = Response::HTTP_OK)
    {
        return ($resourceCollection)
            ->response()
            ->setStatusCode($statusCode);
    }

    /**
     * Generates a Response with a 404 HTTP header and a given message.
     *
     * @return Response
     */
    protected function responseResourceNotFound($detail = 'Resource Not Found')
    {
        return $this->error_response('Resource Not Found', $this->_code_not_found, $detail, [], Response::HTTP_NOT_FOUND);
    }

    /**
     * Generates a Response with a 404 HTTP header and a given message.
     *
     * @return Response
     */
    protected function responseWithValidationError($title, $detail, array $errors = [])
    {
        return $this->error_response($title,$this->_code_wrong_args, $detail, $errors, Response::HTTP_NOT_FOUND);
    }

    private function error_response($title, $code, $detail, array $errors = [], $statusCode = Response::HTTP_BAD_REQUEST) {
        return response()->json([
            'errors' => [
                'id' => 'V_' . Carbon::now()->timestamp,
                'title' => $title,
                'code' => $code,
                'detail' => $detail,
                'meta' => $errors
            ]
        ], $statusCode);
    }

    private function validation_error_response($title, $code, $detail, array $invalidParams) {
        return $this->error_response($title, $code, $detail, ['invalid-params' => $invalidParams]);
    }

    protected function unauthorizedResponse(JsonResource $jsonResource)
    {
        return $this->responseWithItem($jsonResource, Response::HTTP_UNAUTHORIZED);
    }
}