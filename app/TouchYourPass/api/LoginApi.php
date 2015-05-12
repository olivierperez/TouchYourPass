<?php
namespace TouchYourPass\api;

use TouchYourPass\ServiceFactory;

class LoginApi extends Api {

    private $userService;

    function __construct() {
        $this->userService = ServiceFactory::userService();
    }

    /**
     * Connect the user.
     *
     * @return object The object to return as JSON
     */
    function onPost() {
        $data = json_decode($_POST['data']);
        $authenticated = $this->userService->authenticate($data->name, $data->passphrase);

        if ($authenticated) {
            return array('name' => $authenticated->name);
        } else {
            return $this->forbidden();
        }
    }

    function onGet() {
        return $this->badRequest();
    }

    function onDelete() {
        return $this->badRequest();
    }
}
