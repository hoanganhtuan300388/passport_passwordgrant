<?php

namespace App\Traits;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Prettus\Validator\Exceptions\ValidatorException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;

/**
 * https://laracasts.com/discuss/channels/code-review/best-way-to-handle-rest-api-errors-throwed-from-controller-or-exception
 * Trait ApiHandlerTrait
 * @package App\Traits
 */
trait ApiHandlerTrait
{

    /**
     * Determines if request is an api call.
     *
     * If the request URI contains '/api/'.
     *
     * @param Request $request
     * @return bool
     */
    protected function isApiCall(Request $request)
    {
        return strpos($request->getUri(), '/api/') !== false;
    }


    /**
     * Creates a new JSON response based on exception type.
     *
     * @param Request $request
     * @param Exception $exception
     * @return \Illuminate\Http\JsonResponse
     */
    protected function getJsonResponseForException(Request $request, Exception $exception)
    {
        if ($exception instanceof ModelNotFoundException) {
            $response = $this->jsonResponse(STATUS_NOT_FOUND, __('Model not found.'));
        } else if ($exception instanceof NotFoundHttpException) {
            $response = $this->jsonResponse(STATUS_NOT_FOUND, __('Http not found.'));
        } else if ($exception instanceof ValidatorException) {
            $response = $this->jsonResponse(STATUS_BAD_REQUEST, __('Bad request.'), [], $exception->getMessageBag());
        } else if ($exception instanceof UnauthorizedHttpException) {
            $response = $this->jsonResponse(STATUS_UNAUTHORIZED, __('Invalid credentials.'));
        } else if ($exception instanceof AuthenticationException) {
            $response = $this->jsonResponse(STATUS_INVALID_TOKEN, __('Token is Invalid.'));
        } else if ($exception instanceof MethodNotAllowedHttpException) {
            $response = $this->jsonResponse(STATUS_METHOD_ALLOWED, __('Method is not supported for this route.'));
        } else if ($exception instanceof MethodNotAllowedException) {
            $response = $this->jsonResponse(STATUS_METHOD_ALLOWED, __('Method is not supported for this route.'));
        } else {
            $response = $this->jsonResponse(STATUS_BAD_REQUEST, $exception->getMessage());
        }

        return $response;
    }


    /**
     * Returns json response.
     *
     * @param int $status
     * @param string $message
     * @param array $output
     * @param array $errors
     * @return \Illuminate\Http\JsonResponse
     */
    protected function jsonResponse($status = 404, $message = '', $output = [], $errors = [])
    {
        $payload = [
            'status'    => $status,
            'message'   => $message,
            'output'    => !empty($output) ? $output : null,
            'errors'    => !empty($errors) ? $errors : null,
            'time'      => date('Y-m-d H:i:s')
        ];

        return response()->json($payload, $status);
    }

}