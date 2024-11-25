<?php
class UserModel
{
    private $conn;
    private $table_name = "user";

    public $id;
    public $username;
    public $password;


    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Thêm người dùng
    public function create()
    {
        try {
            $query = "INSERT INTO " . $this->table_name . " SET username = :name,  password = :password";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":name", $this->username);
            $stmt->bindParam(":password", $this->password);

            if ($stmt->execute()) {
                return [
                    'errcode' => 0,
                    'message' => 'sign in successful',
                    'data' => null
                ];
            } else {
                return [
                    'errcode' => 1,
                    'message' => 'sign IN failed',
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

    public function readOne()
    {
        try {
            $query = "SELECT user_id,username FROM " . $this->table_name . " WHERE username = :username AND password = :password LIMIT 0,1";

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(":username", $this->username);
            $stmt->bindParam(":password", $this->password);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                return [
                    'errcode' => 0,
                    'message' => 'Login successful',
                    'data' => $result,
                ];
            } else {
                return [
                    'errcode' => 1,
                    'message' => 'Login failed',
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
