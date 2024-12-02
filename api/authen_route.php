<?php
require_once dirname(__DIR__) . '\controller\UserController.php';
$controller = new UserController();
$method = $_SERVER['REQUEST_METHOD'];
if (isset($_SERVER['PATH_INFO']) && !empty($_SERVER['PATH_INFO'])) {
    $request = explode('/', trim($_SERVER['PATH_INFO'], '/'));
    switch ($method) {

        case 'POST':
            if ($request[0] == 'login') {
                $controller->login();
            } else if ($request[0] == 'signin') {
                $controller->signIn();
            } else if ($request[0] == 'logout') {
                $controller->logout();
            }
            break;
        default:
            break;
    }
}
