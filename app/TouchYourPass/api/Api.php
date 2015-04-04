<?php
namespace TouchYourPass\api;

abstract class Api {

    /**
     * Handle POST requests.
     *
     * @return object The object to return as JSON
     */
    abstract function onPost();


    /**
     * Handle GET requests.
     *
     * @return object The object to return as JSON
     */
    abstract function onGet();

    protected function badRequest() {
        http_response_code(400);
        return new ApiError(400, 'Bad Request', null);
    }

    protected function unauthorized() {
        http_response_code(401);
        return new ApiError(401, 'Unauthorized', null);
    }

    protected function forbidden() {
        http_response_code(403);
        return new ApiError(403, 'Forbidden', null);
    }

    protected function notImplemented() {
        http_response_code(501);
        return new ApiError(501, 'Not implemented', null);
    }

}
