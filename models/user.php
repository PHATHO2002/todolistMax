<?php

namespace Models;

use PDO;

require_once dirname(__DIR__) . '\models\base.php';
class UserModel extends BaseModels
{

    public function __construct($db)
    {
        $this->tableName = 'user';
        parent::__construct($db);
    }
    public function createUser($username, $password)
    {
        try {
            if ($err = $this->validateEmpty('username', $username)) {
                return $this->createResponse(404, $err);
            }
            if ($err = $this->validateEmpty('password', $password)) {
                return $this->createResponse(404, $err);
            }
            $isDuplicate = $this->selectByfiled('username', $username);
            if ($isDuplicate['httpcode'] == 200) {
                return $this->createResponse(409, 'username already exists', null);
            }
            $query = "INSERT INTO " . $this->tableName . " SET username = :username,password = :password";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":password", $password);
            $stmt->execute();
            return $this->createResponse(200, 'tạo thành công:', null);
        } catch (\PDOException $e) {
            return $this->createResponse(500, 'Database error:' . $e->getMessage());
        }
    }

    public function readOne($username, $password)
    {
        try {
            if ($err = $this->validateEmpty('username', $username)) {
                return $this->createResponse(404, $err);
            }
            if ($err = $this->validateEmpty('password', $password)) {
                return $this->createResponse(404, $err);
            }
            $query = "SELECT user_id,username FROM " . $this->tableName . " WHERE username = :username and password = :password";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":password", $password);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if (empty($result)) {
                return $this->createResponse(401, 'user or pass wrong');
            } else {
                return $this->createResponse(200, 'Login successful', $result);
            }
        } catch (\PDOException $e) {
            return $this->createResponse(500, 'database error:' . $e->getMessage());
        }
    }
}
