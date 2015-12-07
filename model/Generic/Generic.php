<?php

namespace Model\Generic;

class Generic
{
    protected $pdo;

    /**
     * Generic constructor.
     * @param $pdo \PDO
     */
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }
}