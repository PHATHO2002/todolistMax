<?php

class BaseController
{
    protected $db;
    protected $model;

    protected function sendRespone($httpCode, $message, $data)
    {
        http_response_code($httpCode);
        echo json_encode([
            'message' => $message,
            'data' =>  $data
        ]);
    }
    protected function checkSession()
    {
        session_start();
        if (!isset($_SESSION['userdata'])) {
            $this->sendRespone(401, "Chưa đăng nhập hoặc session hết hạn", null);
            exit;
        }
    }
}
