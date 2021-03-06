<?php
namespace TouchYourPass\api;

use TouchYourPass\ServiceFactory;

class EntryApi extends Api {

    private $entryService;
    private $groupService;
    private $userService;

    function __construct() {
        $this->entryService = ServiceFactory::entryService();
        $this->groupService = ServiceFactory::groupService();
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
        $groups = $this->groupService->findByConnectedUser();

        if ($entries !== false) {
            return ['entries' => $entries, 'groups' => $groups];
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
