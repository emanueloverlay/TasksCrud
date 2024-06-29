<?php

//Deshabilitar la visualización de errores
ini_set('display_errors', '0');
ini_set('display_startup_errors', '0');

// Habilitar el registro de errores
ini_set('log_errors', '1');
ini_set('error_log', 'logs/php_errors.log');


require_once 'app/controllers/TaskController.php';

// Tratamiento URL (solicitud)
$method = $_SERVER['REQUEST_METHOD'];
$requestUri = $_SERVER['REQUEST_URI'];

$basePath = str_replace('/taskscrud', '', $requestUri);
$segments = explode('/', trim($basePath, '/'));

// Enrutador
if (isset($segments[0]) && $segments[0] === 'tasks') {
    $controller = new TaskController();
    if ($method === 'GET') {
        if (isset($segments[1])) {
            $controller->getTaskById($segments[1]);
        } else {
            $controller->getAllTasks();
        }
    } elseif ($method === 'POST' && empty($segments[1])) {
        $controller->newTask();
    } elseif ($method === 'PUT' && isset($segments[1])) {
        $controller->updateTask($segments[1]);
    } elseif ($method === 'DELETE' && isset($segments[1])) {
        $controller->deleteTask($segments[1]);
    } else {
        echo json_encode(['error' => 'Método no permitido']);
    }
} else {
    echo json_encode(['error' => 'Ruta no válida']);
}

