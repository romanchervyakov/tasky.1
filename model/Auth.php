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

        $stmt = $this->pdo->prepare('SELECT * FROM user WHERE login=:login');
        $stmt->bindParam(':login', $login);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
           if (password_verify($secret, $stmt->fetch()['secret'])) {
               return true;
           }
        }

        return false;
    }
}