<?php
namespace TouchYourPass\api;

use TouchYourPass\ServiceFactory;

class GroupApi extends Api {

    private $groupService;
    private $userService;

    function __construct() {
        $this->groupService = ServiceFactory::groupService();
        $this->userService = ServiceFactory::userService();
    }

    function onPost() {
        if (empty($_SESSION['user'])) {
            return $this->unauthorized();
        }

        $data = $_POST['data'];
        $entry = $this->groupService->save($data);

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

        $entries = $this->groupService->findByConnectedUser();

        if ($entries !== false) {
            return $entries;
        } else {
            return $this->forbidden();
        }
    }

    function onDelete() {
        $id = $_GET['id'];
        $deleted = $this->groupService->deleteById($id);

        if ($deleted) {
            return array('deleted' => $id);
        } else {
            return $this->forbidden();
        }
    }
}
