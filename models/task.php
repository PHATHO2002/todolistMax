<?php
class TaskModel
{
    private $conn;
    private $table_name = "task";

    public $title;
    public $status;
    public $content;
    public $priority;
    public $completed;
    public function __construct($db)
    {
        $this->conn = $db;
    }
    public function selectAll($userId)
    {
        try {
            $query = "SELECT * FROM " . $this->table_name . " WHERE user_id = :user_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":user_id", $userId);
            if ($stmt->execute()) {
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return [
                    'errcode' => 0,
                    'message' => 'get all successful',
                    'data' => $result
                ];
            } else {
                return [
                    'errcode' => 1,
                    'message' => 'get all failed',
                    'data' => null
                ];
            }
        } catch (PDOException $e) {
            return [
                'errcode' => 2,
                'message' => 'Database error: ' . $e->getMessage(),
                'data' => null
            ];
        }
    }
    public function selectField($userId, $fieldName, $value)
    {
        try {
            $query = "SELECT * FROM " . $this->table_name . " WHERE user_id = :user_id  AND $fieldName =:$fieldName ";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":user_id", $userId);
            $stmt->bindParam(":$fieldName", $value);

            if ($stmt->execute()) {
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return [
                    'errcode' => 0,
                    'message' => 'Get records successfully',
                    'data' => $result
                ];
            } else {
                return [
                    'errcode' => 1,
                    'message' => 'Get records failed.',
                    'data' => null
                ];
            }
        } catch (PDOException $e) {
            return [
                'errcode' => 2,
                'message' => 'Database error: ' . $e->getMessage(),
                'data' => null
            ];
        }
    }
    public function selectOne($taskId)
    {
        try {
            $query = "SELECT * FROM " . $this->table_name . " WHERE task_id = :task_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":task_id", $taskId);
            if ($stmt->execute()) {
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                return [
                    'errcode' => 0,
                    'message' => 'get all successful',
                    'data' => $result
                ];
            } else {
                return [
                    'errcode' => 1,
                    'message' => 'get all failed',
                    'data' => null
                ];
            }
        } catch (PDOException $e) {
            return [
                'errcode' => 2,
                'message' => 'Database error: ' . $e->getMessage(),
                'data' => null
            ];
        }
    }
    public function create($user_id)
    {
        try {

            $query = "INSERT INTO " . $this->table_name . " SET title = :title,  status = :status,content=:content,priority=:priority,completed=:completed,user_id=:user_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":title", $this->title);
            $stmt->bindParam(":status", $this->status);
            $stmt->bindParam(":content", $this->content);
            $stmt->bindParam(":priority", $this->priority);
            $stmt->bindParam(":completed", $this->completed);
            $stmt->bindParam(":user_id", $user_id);

            if ($stmt->execute()) {
                return [
                    'errcode' => 0,
                    'message' => 'add task successful',
                    'data' => null
                ];
            } else {
                return [
                    'errcode' => 1,
                    'message' => 'add task failed',
                    'data' => null
                ];
            }
        } catch (PDOException $e) {
            return [
                'errcode' => 2,
                'message' => 'Database error: ' . $e->getMessage(),
                'data' => null
            ];
        }
    }
    public function update($task_id)
    {
        try {

            $query = "UPDATE " . $this->table_name . " 
                  SET title = :title, status = :status, content = :content, priority = :priority,completed=:completed
                  WHERE task_id = :task_id";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":title", $this->title);
            $stmt->bindParam(":status", $this->status);
            $stmt->bindParam(":content", $this->content);
            $stmt->bindParam(":priority", $this->priority);
            $stmt->bindParam(":completed", $this->completed);
            $stmt->bindParam(":task_id", $task_id);


            if ($stmt->execute()) {
                return [
                    'errcode' => 0,
                    'message' => 'Task updated successfully',
                    'data' => null
                ];
            } else {
                return [
                    'errcode' => 1,
                    'message' => 'Task update failed',
                    'data' => null
                ];
            }
        } catch (PDOException $e) {
            return [
                'errcode' => 2,
                'message' => 'Database error: ' . $e->getMessage(),
                'data' => null
            ];
        }
    }
    public function updateOneFiled($task_id, $fieldName, $newValue)
    {
        try {
            $query = "UPDATE " . $this->table_name . " 
                  SET $fieldName = :newValue
                  WHERE task_id = :task_id";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":newValue", $newValue);
            $stmt->bindParam(":task_id", $task_id);

            if ($stmt->execute()) {
                return [
                    'errcode' => 0,
                    'message' => 'Task updated successfully',
                    'data' => null
                ];
            } else {
                return [
                    'errcode' => 1,
                    'message' => 'Task update failed',
                    'data' => null
                ];
            }
        } catch (PDOException $e) {
            return [
                'errcode' => 2,
                'message' => 'Database error: ' . $e->getMessage(),
                'data' => null
            ];
        }
    }

    public  function delete($task_id)
    {
        try {

            $query = "DELETE FROM " . $this->table_name . " WHERE task_id = :task_id";
            $stmt = $this->conn->prepare($query);


            $stmt->bindParam(":task_id", $task_id);

            if ($stmt->execute()) {
                return [
                    'errcode' => 0,
                    'message' => 'Task deleted successfully',
                    'data' => null
                ];
            } else {
                return [
                    'errcode' => 1,
                    'message' => 'Failed to delete task',
                    'data' => null
                ];
            }
        } catch (PDOException $e) {
            return [
                'errcode' => 2,
                'message' => 'Database error: ' . $e->getMessage(),
                'data' => null
            ];
        }
    }
}
