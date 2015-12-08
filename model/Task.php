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

    public function save($title)
    {
        $stmt = $this->pdo->prepare("INSERT INTO task(`title`, `type`) VALUES(:title, 'queue')");
        $stmt->bindParam(':title', $title);
        $stmt->execute();
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare("UPDATE task SET type='failed' WHERE id=:id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public function done($id)
    {
        $stmt = $this->pdo->prepare("UPDATE task SET type='success' WHERE id=:id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
}