<?php

namespace Model;

class Auth
{
    private $pdo;

    /**
     * Auth constructor.
     * @param $pdo \PDO
     */
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function isUserFound($login, $secret)
    {
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