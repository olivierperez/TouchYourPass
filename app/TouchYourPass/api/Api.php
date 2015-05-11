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

    /**
     * Handle DELETE requests.
     *
     * @return object The object to return as JSON
     */
    abstract function onDelete();

    protected function badRequest() {
        http_response_code(400);
        return new ApiError('Bad Request', 'Serveur cannot process the request due to a malformed request syntax.', null);
    }

    /**
     * The action requires to be authenticated to be executed.
     *
     * @return ApiError
     */
    protected function unauthorized() {
        http_response_code(401);
        return new ApiError('Unauthorized', 'Authentication is required and has failed or has not yet been provided.', null);
    }

    /**
     * Action is simply forbidden.
     *
     * @return ApiError
     */
    protected function forbidden() {
        http_response_code(403);
        return new ApiError('Forbidden', 'The request was a valid request, but the server is refusing to respond to it.', null);
    }

    /**
     * Action can't be processed in this situation.
     *
     * @param string $msg Message to add to response
     * @return ApiError
     */
    protected function conflict($msg) {
        http_response_code(409);
        return new ApiError('Conflict', $msg, null);
    }

    protected function notImplemented() {
        http_response_code(501);
        return new ApiError('Not implemented', 'Feature is not yet implemented!', null);
    }

}
