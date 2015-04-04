<?php
namespace TouchYourPass\service;

use TouchYourPass\repository\EntryRepository;

class EntryService {

    private $entryRepository;

    function __construct(EntryRepository $entryRepository) {
        $this->entryRepository = $entryRepository;
    }

    public function findAllByUser($user) {
        return $this->entryRepository->findAllByUserId($user->id);
    }

}
