<?php

namespace Model;

use Model\Generic\Generic;

class Task extends Generic
{
    public function getTasks($type) {
        $tasks = array();
        if (in_array($type, array('queue', 'success', 'failed'))) {
            $stmt = $this->pdo->prepare('SELECT * FROM task WHERE type = :type');
            $stmt->bindParam(':type', $type);
            $stmt->execute();
            while ($row = $stmt->fetch()) {
                array_push($tasks, $row);
            }
        }
        return $tasks;
    }

    public function save()
    {

    }

    public function delete($id)
    {

    }
}