
<?php
session_start();
require_once("taskController.php");
class TodoController
{
    public function index($sort = null)
    {
        if (isset($_SESSION['userdata'])) {

            TaskController::getAllTask($_SESSION['userdata']['user_id'], $sort);
        } else {
            header("Location: index.php?action=get_fom_login");
            exit();
        }
    }
    public function getFiledTask($fieldName, $value)
    {
        if (isset($_SESSION['userdata'])) {
            TaskController::getFiledTask($_SESSION['userdata']['user_id'], $fieldName, $value);
        } else {
            header("Location: index.php?action=get_fom_login");
            exit();
        }
    }
    public function addTask($title, $content, $priority, $user_id)
    {
        $newTask = new TaskController($title, $content, $priority);
        $newTask->saveTask($user_id);
    }
    public function updateTask($task_id, $title, $status, $content, $priority)
    {
        TaskController::updateTask($task_id, $title, $status, $content, $priority);
    }
    public function updateAllCompelte($task_ids)
    {

        TaskController::updateAllComplete($task_ids);
    }
    public function deleteTask($task_id)
    {
        TaskController::deleteTask($task_id);
    }
    public function getTaskEditForm($task_id)
    {
        TaskController::getTaskFormEdit($task_id);
    }
    public function getLoginForm()
    {
        require_once 'views/login_form.php';
    }
    public function getSignInForm()
    {
        require_once 'views/sign_in_form.php';
    }
    public function getAddTaskForm()
    {
        require_once 'views/add_task_form.php';
    }
} ?>