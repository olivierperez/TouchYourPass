<?php
namespace TouchYourPass\repository;

class UserRepository extends Repository {

    function __construct($pdo) {
        parent::__construct($pdo);
    }

    public function findByName($name) {
        $stmt = $this->prepare('SELECT * FROM `' . $this->prefix('user') . '` WHERE name = :name');
        $stmt->execute(array('name' => $name));
        $user = $stmt->fetchObject();
        $stmt->closeCursor();

        return $user;
    }

    public function findById($userId) {
        $stmt = $this->prepare('SELECT * FROM `' . $this->prefix('user') . '` WHERE id = :id');
        $stmt->execute(array('id' => $userId));
        $user = $stmt->fetchObject();
        $stmt->closeCursor();

        return $user;
    }

    public function save($name, $hash) {
        $stmt = $this->prepare('INSERT INTO `' . $this->prefix('user') . '` (name, passphrase) VALUES (:name, :hash)');
        $stmt->execute(array('name' => $name, 'hash' => $hash));
        $id = $this->lastInsertId();

        return $id;
    }

}
