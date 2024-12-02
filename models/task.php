<?php

namespace Models;

use Models\BaseModels;

require_once dirname(__DIR__) . '\models\base.php';

class TaskModel extends BaseModels
{
    public function __construct($db)
    {
        $this->tableName = 'task';
        parent::__construct($db);
    }
    public function createTask($user_id, $data)
    {
        try {
            if ($err = $this->validateEmpty('title', $data['title'])) {
                return $this->createResponse(404, $err);
            }
            if ($err = $this->validateEmpty('content', $data['content'])) {
                return $this->createResponse(404, $err);
            }
            if ($err = $this->validateEmpty('priority', $data['priority'])) {
                return $this->createResponse(404, $err);
            }
            if ($err = $this->validateEmpty('user_id', $user_id)) {
                return $this->createResponse(404, $err);
            }

            $query = "INSERT INTO " . $this->tableName . " SET title = :title,  status = :status,content=:content,priority=:priority,completed=:completed,user_id=:user_id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":title", $data['title']);
            $status = 'incomplete';
            $stmt->bindParam(":status",   $status);
            $stmt->bindParam(":content", $data['content']);
            $stmt->bindParam(":priority", $data['priority']);
            $completed = 0;
            $stmt->bindParam(":completed", $completed);
            $stmt->bindParam(":user_id", $user_id);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return $this->createResponse(200, 'add  successful');
            } else {
                return $this->createResponse(404, "not found $user_id");
            }
        } catch (\PDOException $e) {
            return $this->createResponse(500, 'Database error:' . $e->getMessage());
        }
    }
    public function update($task_id, $data)
    {
        try {
            if ($err = $this->validateEmpty('task_id', $task_id)) {
                return $this->createResponse(404, $err);
            }
            if ($err = $this->validateEmpty('title', $data['title'])) {
                return $this->createResponse(404, $err);
            }
            if ($err = $this->validateEmpty('status', $data['status'])) {
                return $this->createResponse(404, $err);
            }
            if ($err = $this->validateEmpty('content', $data['content'])) {
                return $this->createResponse(404, $err);
            }
            if ($err = $this->validateEmpty('priority', $data['priority'])) {
                return $this->createResponse(404, $err);
            }
            $query = "
                UPDATE " . $this->tableName . " 
                SET 
                title = :title, 
                status = :status, 
                content = :content, 
                priority = :priority, 
                completed = :completed 
                WHERE 
                task_id = :task_id 
            ";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":task_id", $task_id);
            $stmt->bindParam(":title", $data['title']);
            $stmt->bindParam(":content", $data['content']);
            $stmt->bindParam(":priority", $data['priority']);
            $stmt->bindParam(":status", $data['status']);;
            if ($data['content'] == 'incomplete') {
                $completed = 0;
            } else {
                $completed = 1;
            }
            $stmt->bindParam(":completed", $completed);

            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return $this->createResponse(200, 'Update successful');
            } else {
                return $this->createResponse(404, "Task not found or no changes made");
            }
        } catch (\PDOException $e) {
            return $this->createResponse(500, 'Database error: ' . $e->getMessage());
        }
    }
    public function filterByStatusPriority($status, $priority)
    {
        try {
            if ($err = $this->validateEmpty('status', $status)) {
                return $this->createResponse(404, $err);
            }
            if ($err = $this->validateEmpty('priority', $priority)) {
                return $this->createResponse(404, $err);
            }
            $query = 'SELECT * FROM ' . $this->tableName . " WHERE status = :status and priority = :priority ";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":status", $status);
            $stmt->bindParam(":priority", $priority);
            $stmt->execute();
            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            if (!empty($result)) {
                return $this->createResponse(200, 'Get data successful', $result);
            } else {
                return $this->createResponse(404, 'No data found');
            }
        } catch (\PDOException $e) {
            return $this->createResponse(500, 'Database error: ' . $e->getMessage());
        }
    }
    public function updateCompletes($task_ids)
    {
        try {
            if (!is_array($task_ids) || empty($task_ids)) {
                return $this->createResponse(404, 'no data found');
            }
            foreach ($task_ids as $task_id) {

                $query = "
                UPDATE " . $this->tableName . " 
                SET  
                status = :status, 
                completed = :completed 
                WHERE 
                task_id = :task_id 
            ";
                $stmt = $this->db->prepare($query);
                $status = 'completed';
                $completed = 1;
                $stmt->bindParam(":status", $status);
                $stmt->bindParam(":completed", $completed);
                $stmt->bindParam(":task_id", $task_id);
                $stmt->execute();
                if ($stmt->rowCount() <= 0) {
                    return $this->createResponse(404, "Task id = $task_id not found or no changes made");
                }
            }
            return $this->createResponse(200, 'Update successful');
        } catch (\PDOException $e) {
            return $this->createResponse(500, 'Database error: ' . $e->getMessage());
        }
    }
}
