<?php
session_start();
require_once dirname(__DIR__) . '\config\database.php';

use Models\UserModel;

require_once dirname(__DIR__) . '\models\user.php';
require_once dirname(__DIR__) . '\controller\BaseController.php';


require_once('BaseController.php');
class UserController extends BaseController
{
    public function __construct()
    {
        try {
            $this->db = getDatabaseConnection();
            $this->model = new UserModel($this->db);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'message' => 'Không thể kết nối với cơ sở dữ liệu. Chi tiết lỗi: ' . $e->getMessage(),
                'data' => null
            ]);
            exit();
        }
    }

    public function login()
    {
        $respone = $this->model->readOne($_POST['username'] ?? null, $_POST['password'] ?? null);
        if ($respone['httpcode'] == 200) {
            $_SESSION['userdata'] = $respone['data'];
        }
        $this->sendRespone($respone['httpcode'], $respone['message'], $respone['data']);
    }
    public function logout()
    {
        $this->checkSession();
        session_unset();
        session_destroy();
        $this->sendRespone(200, 'logout succesful', null);
    }
    public function signIn()
    {
        $username = $_POST['username'] ?? null;
        $password = $_POST['password'] ?? null;
        $respone = $this->model->createUser($username, $password);
        $this->sendRespone($respone['httpcode'], $respone['message'], $respone['data']);
    }
}
