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

        if ($user !== false && $user->active == 1 && $this->verifyPassphrase($passphrase, $user->passphrase)) {
            $_SESSION['user'] = $user;
            return $user;
        }
        $_SESSION['user'] = null;

        return false;
    }

    /**
     * Use bcrypt with cost of 20.
     *
     * @param string $passphrase The passphrase to hash
     * @return bool|string Then hashed passphrase, or false
     */
    private function hash($passphrase) {
        return password_hash($passphrase, PASSWORD_BCRYPT, array('cost'=>10));
    }

    /**
     * Check if the passphrase is matching to the stored hash.
     *
     * @param string $passphrase The passphrase given by the user
     * @param string $hash The hash stored in database
     * @return bool true is the passphrase matches the hash
     */
    public function verifyPassphrase($passphrase, $hash) {
        return password_verify($passphrase, $hash);
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

    public function create($name, $passphrase) {
        $user = $this->userRepository->findByName($name);

        if ($user) {
            return false;
        } else {
            $userId = $this->userRepository->save($name, $this->hash($passphrase));
            return $userId;
        }
    }

    public function findAll() {
        return $this->userRepository->findAll();
    }

    public function update($user) {
        if ($this->userRepository->update($user)) {
            return $user;
        } else {
            return false;
        }
    }

}
