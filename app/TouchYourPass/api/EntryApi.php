<?php
namespace TouchYourPass\api;

use TouchYourPass\ServiceFactory;

class EntryApi extends Api {

    private $entryService;
    private $userService;

    function __construct() {
        $this->entryService = ServiceFactory::entryService();
        $this->userService = ServiceFactory::userService();
    }

    function onPost() {
        // TODO: Implement onPost() method.
        return $this->notImplemented();
    }

    function onGet() {
        $userId = $_GET['user'];
        if (!$this->userService->authorizedToSeeUser($userId)) {
            return $this->forbidden();
        }

        $user = $this->userService->findById($userId);
        $entries = $this->entryService->findAllByUser($user);

        return $entries;
    }
}
