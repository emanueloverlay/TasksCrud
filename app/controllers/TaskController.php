<?php

require_once __DIR__ . '/../models/Task.php';
class TaskController {

    public function getAllTasks() {
        $listTasks = Task::getAllTasks();
        echo json_encode($listTasks);
    }

    public function getTaskById($id) {
        $task = Task::getTaskById($id);

        if (!$task) {
            echo json_encode(['error' => 'No se encontró un ID para su búsqueda.']);
            return;
        }

        echo json_encode($task);
    }


    public function newTask() {
        if (!isset($_POST['description'], $_POST['dateHour'], $_POST['status'])) {
            $msg = ['error' => 'Faltan datos en la solicitud'];
            echo json_encode($msg);
            return;
        }

        $description = $_POST['description'];
        $dateHour = $_POST['dateHour'];
        $status = $_POST['status'];

        $newTask = new Task($description, $dateHour, $status);
        $result = $newTask->saveTask();

        if ($result) {
            $msg = ['message' => 'Tarea guardada correctamente'];
        } else {
            $msg = ['error' => 'Error al guardar la tarea'];
        }

        echo json_encode($msg);
    }


    public function updateTask($id) {

        // Leer el cuerpo de la solicitud
        $input = file_get_contents('php://input');

        // Decodificar JSON
        $data = json_decode($input, true);

        if (!isset($data['description'], $data['dateHour'], $data['status'])) {
            $msg = ['error' => 'Faltan datos en la solicitud'];
            echo json_encode($msg);
            return;
        }

        $description = $data['description'];
        $dateHour = $data['dateHour'];
        $status = $data['status'];

        $updatedTask = new Task($description, $dateHour, $status);
        $updatedTask->id = $id;

        $result = $updatedTask->updateTask();


        if ($result) {
            $msg = ['message' => 'Tarea actualizada correctamente'];
        } else {
            $msg = ['error' => 'Error al actualizar la tarea'];
        }

        echo json_encode($msg);
    }

    public function deleteTask($id) {

        $result = Task::deleteTask($id);

        if ($result) {
            $msg = ['message' => 'Tarea eliminada correctamente'];
        } else {
            $msg = ['error' => 'Error al eliminar la tarea'];
        }

        echo json_encode($msg);
    }
}