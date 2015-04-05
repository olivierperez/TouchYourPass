<?php
namespace TouchYourPass\repository;

abstract class Repository {

    private $pdo;

    function __construct(\PDO $pdo) {
        $this->pdo = $pdo;
    }

    protected function prepare($sql) {
        return $this->pdo->prepare($sql);
    }

    protected function lastInsertId() {
        return $this->pdo->lastInsertId();
    }

    protected function prefix($table) {
        return DB_TABLE_PREFIX . $table;
    }

}
