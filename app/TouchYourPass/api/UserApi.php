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
        if (empty($data->name) || empty($data->passphrase) || $data->passphrase == 'd96b7e56fa181a09ef450fbe5db9ef957a93ee7380df25fed8670e97ce6ce632f5da8c567fb59f8afd13e50492626270498bd593cf1f52d63b40744cdb11e58f') {
            return $this->badRequest();
        }
        $created = $this->userService->create($data->name, $data->passphrase);

        if ($created) {
            return array('msg' => __('Register','RegisterSucceededWaitForAdminValidateYourAccount'));
        } else {
            return $this->conflict(__('Register','TheAccountAlreadyExists'));
        }
    }

    function onGet() {
        return $this->userService->findAll();
    }

    function onDelete() {
        return $this->notImplemented();
    }
}
