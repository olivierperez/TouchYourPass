<?php
namespace TouchYourPass\service;

use TouchYourPass\repository\EntryRepository;

class EntryService {

    private $entryRepository;

    function __construct(EntryRepository $entryRepository) {
        $this->entryRepository = $entryRepository;
    }

    public function findByConnectedUser() {
        return $this->entryRepository->findAllByUserId($_SESSION['user']->id);
    }

    public function save($data) {
        $id = $this->entryRepository->save($_SESSION['user']->id, $data);

        if ($id) {
            $entry = new \stdClass();
            $entry->id = $id;
            $entry->content = $data;
            return $entry;
        } else {
            return false;
        }
    }

}
