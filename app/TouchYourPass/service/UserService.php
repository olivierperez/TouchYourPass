<?php
namespace TouchYourPass\service;

use TouchYourPass\repository\UserRepository;

class UserService {

    private $userRepository;

    function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function authenticate($name, $passphrase) {
        $user = $this->userRepository->findByName($name);

        if ($user !== false && $this->hash($passphrase) == $user->passphrase) {
            $_SESSION['user'] = $user;
            return $user;
        }
        $_SESSION['user'] = null;

        return false;
    }

    private function hash($passphrase) {// TODO replace with bcrypt ?
        return hash('sha512', $passphrase . PASSPHRASE_SALT);
    }

    public function authorizedToSeeUser($userId) {
        if (!empty($_SESSION['user'])) {
            return $userId === $_SESSION['user']->id;
        }

        return false;
    }

    public function findById($userId) {
        return $this->userRepository->findById($userId);
    }

}