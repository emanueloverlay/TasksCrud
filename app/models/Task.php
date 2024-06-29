<?php

require_once __DIR__ . '/../core/Database.php';

class Task {
    public $id;
    public $description;
    public $dateHour;
    public $status;

    public function __construct($description = "", $dateHour = "", $status = "") {
        $this->description = $description;
        $this->dateHour = $dateHour;
        $this->status = $status;
    }

    static public function getAllTasks() {
        $mysqli = Database::getInstanceDB();
        $stmt = $mysqli->prepare("SELECT * FROM tasks");

        if (!$stmt) {
            throw new Exception('Error en la preparación de la consulta: ' . $mysqli->error);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        $listTasks = [];

        if ($result) {
            while ($task = $result->fetch_assoc()) {
                $listTasks[] = $task;
            }
        }

        $stmt->close();
        return $listTasks;
    }

    static public function getTaskById($id) {
        $mysqli = Database::getInstanceDB();
        $stmt = $mysqli->prepare("SELECT * FROM tasks WHERE id_task=?");

        if (!$stmt) {
            throw new Exception('Error en la preparación de la consulta: ' . $mysqli->error);
        }

        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $task = $result->fetch_assoc();
        $stmt->close();

        return $task;
    }

    public function saveTask() {
        $mysqli = Database::getInstanceDB();
        $stmt = $mysqli->prepare("INSERT INTO tasks (description_task, date_hour_task, status_task) VALUES (?, ?, ?)");

        if (!$stmt) {
            throw new Exception('Error en la preparación de la consulta: ' . $mysqli->error);
        }

        $stmt->bind_param("sss", $this->description, $this->dateHour, $this->status);
        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }

    public function updateTask() {
        $mysqli = Database::getInstanceDB();
        $stmt = $mysqli->prepare("UPDATE tasks SET description_task=?, date_hour_task=?, status_task=? WHERE id_task=?");

        if (!$stmt) {
            throw new Exception('Error en la preparación de la consulta: ' . $mysqli->error);
        }

        $stmt->bind_param("sssi", $this->description, $this->dateHour, $this->status, $this->id);
        $stmt->execute();

        $rowsAffected = $stmt->affected_rows;

        $stmt->close();

        return ($rowsAffected > 0);
    }

    public static function deleteTask($id) {
        $mysqli = Database::getInstanceDB();
        $stmt = $mysqli->prepare("DELETE FROM tasks WHERE id_task=?");

        if (!$stmt) {
            throw new Exception('Error en la preparación de la consulta: ' . $mysqli->error);
        }

        $stmt->bind_param("i", $id);
        $stmt->execute();
        $rowsAffected = $stmt->affected_rows;

        $stmt->close();

        return ($rowsAffected > 0);
    }




}