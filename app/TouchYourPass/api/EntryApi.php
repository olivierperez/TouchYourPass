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
        if (empty($_SESSION['user'])) {
            return $this->unauthorized();
        }

        $entries = $this->entryService->findByConnectedUser();

        if ($entries !== false) {
            return $entries;
        } else {
            return $this->forbidden();
        }
    }

    function onDelete() {
        $id = $_GET['id'];
        $deleted = $this->entryService->deleteById($id);

        if ($deleted) {
            return array('deleted' => $id);
        } else {
            return $this->forbidden();
        }
    }
}
