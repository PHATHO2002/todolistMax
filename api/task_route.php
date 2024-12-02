<?php
require_once dirname(__DIR__) . '\controller\TaskController.php';
$controller = new TaskController();
$method = $_SERVER['REQUEST_METHOD'];
if (isset($_SERVER['PATH_INFO']) && !empty($_SERVER['PATH_INFO'])) {
    $request = explode('/', trim($_SERVER['PATH_INFO'], '/'));
    switch ($method) {
        case 'GET':
            if ($request[0] == 'task') {
                if (isset($_GET['task_id'])) {
                    $controller->getOneTask();
                } else if (isset($_GET['title'])) {
                    $controller->searchByTitle();
                } else {
                    $controller->selectAll();
                }
            }
            break;
        case 'POST':
            if ($request[0] == 'delete') {
                $controller->delete();
                break;
            } else if ($request[0] == 'add') {
                $controller->createTask();
                break;
            } elseif ($request[0] == 'update') {
                $controller->updateTask();
                break;
            } elseif ($request[0] == 'filter') {
                $controller->filterByStatusPriority();
                break;
            } elseif ($request[0] == 'compeltes') {
                $controller->updateCompletes();
                break;
            }
        default:
            break;
    }
}
