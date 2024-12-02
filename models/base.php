<?php

namespace Models;

use PDO;

class BaseModels
{
    protected $tableName;
    protected $db;
    public function __construct($db)
    {
        $this->db = $db;
    }
    protected function validateEmpty($fieldName, &$value)
    {
        $value = trim($value);

        if (empty($value)) {
            return "$fieldName cannot be empty.";
        }
        return null;
    }
    protected function createResponse($httpCode, $message, $data = null)
    {
        return [
            'httpcode' => $httpCode,
            'message' => $message,
            'data' => $data
        ];
    }
    public function selectALL()
    {
        try {

            $query = 'SELECT * FROM ' . $this->tableName;
            $stmt = $this->db->prepare($query);
            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (!empty($result)) {
                return $this->createResponse(200, 'Get all successful', $result);
            } else {
                return $this->createResponse(404, 'No data found');
            }
        } catch (\PDOException $e) {

            return $this->createResponse(500, 'Database error:' . $e->getMessage());
        }
    }
    public function selectByfiled($fieldName, $value)
    {
        try {
            if ($err = $this->validateEmpty($fieldName, $value)) {
                return $this->createResponse(404, $err);
            }
            $query = 'SELECT * FROM ' . $this->tableName . " WHERE $fieldName = :$fieldName";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":$fieldName", $value);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (!empty($result)) {
                return $this->createResponse(200, 'Get data successful', $result);
            } else {
                return $this->createResponse(404, 'No data found');
            }
        } catch (\PDOException $e) {
            return $this->createResponse(500, 'Database error:' . $e->getMessage());
        }
    }
    public function selectOneByfiled($fieldName, $value)
    {
        try {
            if ($err = $this->validateEmpty($fieldName, $value)) {
                return $this->createResponse(404, $err);
            }
            $query = 'SELECT * FROM ' . $this->tableName . " WHERE $fieldName = :$fieldName";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":$fieldName", $value);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!empty($result)) {
                return $this->createResponse(200, 'Get one successful', $result);
            } else {
                return $this->createResponse(404, 'No data found');
            }
        } catch (\PDOException $e) {
            return $this->createResponse(500, 'Database error:' . $e->getMessage());
        }
    }
    public function deleteOneByFiled($fieldName, $value)
    {
        try {

            if ($err = $this->validateEmpty($fieldName, $value)) {
                return $this->createResponse(404, $err);
            }
            $query = "DELETE FROM " . $this->tableName . " WHERE $fieldName = :$fieldName";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":$fieldName", $value);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return $this->createResponse(200, 'delete  successful');
            } else {
                return $this->createResponse(404, "not found $value");
            }
        } catch (\PDOException $e) {
            return $this->createResponse(500, 'Database error: ' . $e->getMessage());
        }
    }
}
