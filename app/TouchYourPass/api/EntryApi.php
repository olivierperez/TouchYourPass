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
        if (empty($_SESSION['user'])) {
            return $this->unauthorized();
        }

        $data = $_POST['data'];
        $entry = $this->entryService->save($data);

        if ($entry !== false) {
            return $entry;
        } else {
            return $this->forbidden();
        }
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
