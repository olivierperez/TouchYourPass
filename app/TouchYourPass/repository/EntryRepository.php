<?php
namespace TouchYourPass\repository;

class EntryRepository extends Repository {

    function __construct($pdo) {
        parent::__construct($pdo);
    }

    public function findAllByUserId($id) {
        $stmt = $this->prepare('SELECT * FROM `entry` WHERE user_id = :userId');
        $stmt->execute(array('userId' => $id));
        $entries = $stmt->fetchAll();

        return $entries;
    }

    public function save($userId, $data) {
        $stmt = $this->prepare('INSERT INTO `entry` (user_id, content) VALUES (:userId, :content)');
        $stmt->execute(array('userId' => $userId, 'content' => $data));
        $id = $this->lastInsertId();

        return $id;
    }

}
