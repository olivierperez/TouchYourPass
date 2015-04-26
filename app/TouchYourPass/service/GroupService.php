<?php
namespace TouchYourPass\service;

use TouchYourPass\repository\GroupRepository;

class GroupService {

    private $groupRepository;

    function __construct(GroupRepository $groupRepository) {
        $this->groupRepository = $groupRepository;
    }

    public function findByConnectedUser() {
        return $this->groupRepository->findAllByUserId($_SESSION['user']->id);
    }

    public function save($data) {
        $id = $this->groupRepository->save($_SESSION['user']->id, $data);

        if ($id) {
            $entry = new \stdClass();
            $entry->id = $id;
            $entry->content = $data;
            return $entry;
        } else {
            return false;
        }
    }

    public function deleteById($id) {
        $entry = $this->groupRepository->findById($id);

        if ($entry && $entry->user_id === $_SESSION['user']->id) {
            return $this->groupRepository->deleteById($id);
        } else {
            return false;
        }
    }

}
