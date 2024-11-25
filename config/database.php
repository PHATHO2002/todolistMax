<?php
function getDatabaseConnection()
{
    try {
        $conn = new PDO("mysql:host=localhost;dbname=todolist", "root", "");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        throw new Exception("Database connection failed: " . $e->getMessage());
    }
}
