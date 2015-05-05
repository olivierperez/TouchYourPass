<?php
namespace TouchYourPass\api;

use TouchYourPass\ServiceFactory;

class UserApi extends Api {

    private $userService;

    function __construct() {
        $this->userService = ServiceFactory::userService();
    }

    /**
     * Add a user.
     *
     * @return object The object to return as JSON
     */
    function onPost() {
        $data = json_decode($_POST['data']);
        $created = $this->userService->create($data->name, $data->passphrase);

        if ($created) {
            return array('msg' => __('Register','RegisterSucceededWaitForAdminValidateYourAccount'));
        } else {
            return $this->forbidden();
        }
    }

    function onGet() {
        return $this->userService->findAll();
    }

    function onDelete() {
        return $this->notImplemented();
    }
}
