<?php

namespace Taskalka\Models;

use MongoDB\Collection;
use Taskalka\Exceptions\PageError;

/**
 * Created by PhpStorm.
 * User: masterx2
 * Date: 17.12.16
 * Time: 16:05
 */
class User {

    public $id;
    public $login;
    public $email;
    public $password;
    public $sessionId;

    function __construct() {

    }

    /**
     * @return string
     */
    public function getSessionId() {
        return $this->sessionId;
    }

    public static function new($login, $email,$password) {
        $user = new static();

        $user->sessionId = uniqid();
        $user->login = $login;
        $user->email = $email;
        $user->password = sha1($password);

        return $user;
    }

    public static function fromCollection($query, Collection $collection) {
        $result = $collection->findOne($query);

        if (!$result) return false;

        $user = new static();

        $user->sessionId = $result['sessionId'];
        $user->login = $result['login'];
        $user->password = $result['password'];
        $user->email = $result['email'];

        return $user;
    }

    public function save(Collection $collection) {
        $collection->insertOne([
            'login' => $this->login,
            'password' => $this->password,
            'email' => $this->email,
            'sessionId' => $this->sessionId
        ]);
    }
}