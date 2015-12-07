<?php

namespace Model;

use Model\Generic\Generic;

class Auth extends Generic
{
    public function isUserFound($login, $secret)
    {
        // sql injection and xss defence
        $login = htmlspecialchars($login, ENT_QUOTES, 'UTF-8');
        $secret = htmlspecialchars($secret, ENT_QUOTES, 'UTF-8');

        $stmt = $this->pdo->prepare('SELECT * FROM user WHERE login=:login AND secret=:secret');
        $stmt->bindParam(':login', $login);
        $stmt->bindParam(':secret', $secret);
        $stmt->execute();

        if ($stmt->fetchAll()) {
            return true;
        } else {
            return false;
        }
    }
}