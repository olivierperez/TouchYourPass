<?php
namespace TouchYourPass\repository;

class EntryRepository extends Repository {

    function __construct($pdo) {
        parent::__construct($pdo);
    }

    public function findAllByUserId($id) {
        $stmt = $this->prepare('SELECT id, content FROM `' . $this->prefix('entry') . '` WHERE user_id = :userId');
        $stmt->execute(array('userId' => $id));
        $entries = $stmt->fetchAll();

        return $entries;
    }

    public function save($userId, $data) {
        $stmt = $this->prepare('INSERT INTO `' . $this->prefix('entry') . '` (user_id, content) VALUES (:userId, :content)');
        $stmt->execute(array('userId' => $userId, 'content' => $data));
        $id = $this->lastInsertId();

        return $id;
    }

    public function findById($id) {
        $stmt = $this->prepare('SELECT user_id FROM `' . $this->prefix('entry') . '` WHERE id = :id');
        $stmt->execute(array('id' => $id));
        $entry = $stmt->fetch();
        $stmt->closeCursor();

        return $entry;
    }

    public function deleteById($id) {
        $stmt = $this->prepare('DELETE FROM `' . $this->prefix('entry') . '` WHERE id = :id');
        return $stmt->execute(array('id' => $id));
    }

}
