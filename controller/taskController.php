<?php
require_once('config/database.php');
require_once('models//task.php');

class TaskController
{
    private $title;
    private $status = 'incomplete';
    private $content;
    private $priority;
    private  $completed = 0;

    public function __construct($title, $content, $priority)
    {
        $this->title = $title;
        $this->content = $content;
        $this->priority = $priority;
    }

    public static function validateNotEmptyAndLength($fieldName, &$fieldValue, $minLength = null)
    {
        $fieldValue = trim($fieldValue);

        if (empty($fieldValue)) {
            return "$fieldName cannot be empty.";
        }

        if ($minLength && strlen($fieldValue) < $minLength) {
            return "$fieldName must be at least $minLength characters long.";
        }

        return null;
    }
    public static function getAllTask($userId, $sort = null)
    {
        try {
            if ($error = self::validateNotEmptyAndLength('User ID', $userId)) {
                $mess = $error;
                require_once('views/index.php');
                return;
            }
            $db = getDatabaseConnection();
            $taskModel = new TaskModel($db);
            $respone = $taskModel->selectAll($userId);
            if (!$respone['errcode']) {
                $tasks = $respone['data'];
                $Sort = $sort;
                require_once('views/index.php');
            } else {
                $mess = $respone['message'];
                require_once('views/index.php');
            }
        } catch (Exception $e) {
            $mess = $e;
            require_once('views/index.php');
        }
    }
    public static function getFiledTask($userId, $fieldName, $value)
    {
        try {
            if ($error = self::validateNotEmptyAndLength('User ID', $userId)) {
                $mess = $error;
                require_once('views/index.php');
                return;
            }
            if ($error = self::validateNotEmptyAndLength('fieldName', $fieldName)) {
                $mess = $error;
                require_once('views/index.php');
                return;
            }
            if ($error = self::validateNotEmptyAndLength($fieldName, $value)) {
                $mess = $error;
                require_once('views/index.php');
                return;
            }
            $db = getDatabaseConnection();
            $taskModel = new TaskModel($db);

            $respone = $taskModel->selectField($userId, $fieldName, $value);
            if (!$respone['errcode']) {
                $tasks = $respone['data'];
                require_once('views/index.php');
            } else {
                $mess = $respone['message'];
                require_once('views/index.php');
            }
        } catch (Exception $e) {
            $mess = $e;
            require_once('views/index.php');
        }
    }
    public static function getTaskFormEdit($taskId)
    {
        try {
            if ($error = self::validateNotEmptyAndLength('Task ID', $taskId)) {
                $mess = $error;
                require_once('views/edit_task_form.php');
                return;
            }
            $db = getDatabaseConnection();
            $taskModel = new TaskModel($db);
            $respone = $taskModel->selectOne($taskId);
            if (!$respone['errcode']) {
                $task = $respone['data'];
                require_once('views/edit_task_form.php');
            } else {
                $mess = $respone['message'];
                require_once('views/edit_task_form.php');
            }
        } catch (Exception $e) {
            $mess = $e;
            require_once('views/edit_task_form.php');
        }
    }
    public function saveTask($userId)
    {
        try {

            if ($error = self::validateNotEmptyAndLength('Title', $this->title)) {
                header("Location: index.php?action=get_add_task_fr&err=$error");
                exit();
            }
            if ($error = self::validateNotEmptyAndLength('Content', $this->content)) {
                header("Location: index.php?action=get_add_task_fr&err=$error");
                exit();
            }
            if ($error = self::validateNotEmptyAndLength('Priority', $this->priority)) {
                header("Location: index.php?action=get_add_task_fr&err=$error");
                exit();
            }

            $db = getDatabaseConnection();
            $taskModel = new TaskModel($db);
            $taskModel->title = $this->title;
            $taskModel->status = $this->status;
            $taskModel->content = $this->content;
            $taskModel->priority = $this->priority;
            $taskModel->completed = $this->completed;
            $response = $taskModel->create($userId);
            $message = $response['message'];
            header("Location: index.php?action=get_add_task_fr&err=$message");
            exit();
        } catch (Exception $e) {
            header("Location: index.php?action=get_add_task_fr&err=" . $e->getMessage());
            exit();
        }
    }
    public static function updateTask($taskId, $newTitle, $newStatus, $newContent, $newPriority)
    {
        try {
            if ($error = self::validateNotEmptyAndLength('Title', $newTitle)) {
                header("Location: index.php?action=get_edit_task_fr&taskId=$taskId&err=$error");
                exit();
            }
            if ($error = self::validateNotEmptyAndLength('Content', $newContent)) {
                header("Location: index.php?action=get_edit_task_fr&taskId=$taskId&err=$error");
                exit();
            }
            if ($error = self::validateNotEmptyAndLength('Priority', $newPriority)) {
                header("Location: index.php?action=get_edit_task_fr&taskId=$taskId&err=$error");
                exit();
            }

            $db = getDatabaseConnection();
            $taskModel = new TaskModel($db);
            $taskModel->title = $newTitle;
            $taskModel->status = $newStatus;
            $taskModel->content = $newContent;
            $taskModel->priority = $newPriority;
            if ($newStatus == 'completed') {

                $taskModel->completed = 1;
            } else {

                $taskModel->completed = 0;
            }
            $response = $taskModel->update($taskId);
            $message = $response['message'];
            header("Location: index.php?action=get_edit_task_fr&taskId=$taskId&err=$message");
            exit();
        } catch (Exception $e) {
            header("Location: index.php?action=get_edit_task_fr&taskId=$taskId&err=" . $e->getMessage());
            exit();
        }
    }
    public static function updateAllComplete($taskIds)
    {
        try {

            $db = getDatabaseConnection();
            $taskModel = new TaskModel($db);
            foreach ($taskIds as $taskId) {
                $taskModel->updateOneFiled($taskId, 'status', 'completed');
                $taskModel->updateOneFiled($taskId, 'completed', 1);
            }

            header("Location: index.php");
            exit();
        } catch (Exception $e) {
            header("Location: index.php?err=" . $e->getMessage());
            exit();
        }
    }
    public static function deleteTask($taskId)
    {
        try {

            if ($error = self::validateNotEmptyAndLength('Task ID', $taskId)) {
                echo "<script>
                    alert('$error');
                    window.location.href = 'index.php';
                </script>";
                exit();
            }

            $db = getDatabaseConnection();
            $taskModel = new TaskModel($db);
            $response = $taskModel->delete($taskId);
            $message = $response['message'];

            echo "<script>
                alert('$message');
                window.location.href = 'index.php';
            </script>";
            exit();
        } catch (Exception $e) {
            echo "<script>
                alert('$e');
                window.location.href = 'index.php';
            </script>";
            exit();
        }
    }
}
