<?php
namespace TouchYourPass\api;

class ApiError {

    public $error;
    public $error_description;
    public $error_uri;

    function __construct($error, $error_description, $error_uri) {
        $this->error = $error;
        $this->error_description = $error_description;
        $this->error_uri = $error_uri;
    }

}
