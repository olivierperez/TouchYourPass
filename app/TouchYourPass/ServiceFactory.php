<?php
namespace TouchYourPass;

use TouchYourPass\repository\EntryRepository;
use TouchYourPass\repository\UserRepository;
use TouchYourPass\service\EntryService;
use TouchYourPass\service\UserService;

class ServiceFactory {

    private static $pdo;

    public static function init(\PDO $pdo) {
        self::$pdo = $pdo;
    }

    public static function userService() {
        return new UserService(new UserRepository(self::$pdo));
    }

    public static function entryService() {
        return new EntryService(new EntryRepository(self::$pdo));
    }

}
