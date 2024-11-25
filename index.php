<?php

require_once('controller/TodoController.php');
require_once('controller/userController.php');



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <?php
    $todoController = new TodoController();

    if ($_SERVER['REQUEST_METHOD'] == "GET") {
        if (isset($_GET["action"])) {
            switch ($_GET["action"]) {
                case "get_fom_login":
                    $todoController->getLoginForm();
                    break;
                case "get_sign_form":
                    $todoController->getSignInForm();
                    break;
                case "get_add_task_fr":
                    $todoController->getAddTaskForm();
                    break;
                case "get_edit_task_fr":
                    $taskId = $_GET["taskId"];
                    $todoController->getTaskEditForm($taskId);
                    break;
                default:
                    $todoController->index($_GET["action"]);
                    break;
            }
        } else {
            $todoController->index();
        }
    }
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        if (isset($_POST["action"])) {
            switch ($_POST["action"]) {
                case "login":
                    $userController = new UserController($_POST["username"], $_POST["pass"]);
                    $userController->login();
                    break;
                case "signin":
                    $userController = new UserController($_POST["username"], $_POST["pass"]);
                    $userController->signIn();
                    break;
                case "addTask":
                    $todoController->addTask($_POST["title"], $_POST["content"], $_POST["priority"], $_SESSION["userdata"]["user_id"]);
                    break;
                case "updateTask":
                    $todoController->updateTask($_POST["task_id"], $_POST["title"], $_POST["status"], $_POST["content"], $_POST["priority"]);
                    break;
                case "deleteTask":
                    if (isset($_POST["task_id"])) {
                        $todoController->deleteTask($_POST["task_id"]);
                    }
                    break;
                case "filter":
                    $todoController->getFiledTask($_POST['filedName'], $_POST['value_filter']);
                    break;
                case 'updateListCompleted':
                    $todoController->updateAllCompelte(json_decode($_POST['listIdToUpdate']));
                    break;
                case 'logout':
                    session_unset();
                    session_destroy();
                    header("Location: index.php?action=get_fom_login");
                default:
                    break;
            }
        }
    }

    ?>
</body>

</html>