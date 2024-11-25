<?php

require_once('config/database.php');
require_once('models/user.php');

class UserController
{
    private $username;
    private $password;

    public function __construct($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
    }


    public static function validateNotEmptyAndLength($fieldName, $fieldValue, $minLength = null)
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

    public function login()
    {
        try {
            if ($error = self::validateNotEmptyAndLength('Username', $this->username)) {
                header("Location: index.php?action=get_fom_login&err=$error");
                exit();
            }
            if ($error = self::validateNotEmptyAndLength('Password', $this->password)) {
                header("Location: index.php?action=get_fom_login&err=$error");
                exit();
            }
            $db = getDatabaseConnection();
            $userModel = new UserModel($db);
            $userModel->username = $this->username;
            $userModel->password = $this->password;
            $response = $userModel->readOne();
            $message = $response['message'];

            if (!$response['errcode']) {
                $_SESSION['userdata'] = $response['data'];
                header("Location: index.php");
                exit();
            } else {
                header("Location: index.php?action=get_fom_login&err=$message");
                exit();
            }
        } catch (Exception $e) {
            header("Location: index.php?action=get_fom_login&err=" . $e->getMessage());
            exit();
        }
    }

    public function signIn()
    {
        try {

            if ($error = self::validateNotEmptyAndLength('Username', $this->username)) {
                header("Location: index.php?action=get_sign_form&err=$error");
                exit();
            }
            if ($error = self::validateNotEmptyAndLength('Password', $this->password, 6)) {
                header("Location: index.php?action=get_sign_form&err=$error");
                exit();
            }


            $db = getDatabaseConnection();
            $userModel = new UserModel($db);
            $userModel->username = $this->username;
            $userModel->password = $this->password;
            $response = $userModel->create();
            $message = $response['message'];

            if (!$response['errcode']) {
                header("Location: index.php?action=get_sign_form&err=$message");
                exit();
            } else {
                header("Location: index.php?action=get_sign_form&err=$message");
                exit();
            }
        } catch (Exception $e) {
            header("Location: index.php?action=get_sign_form&err=" . $e->getMessage());
            exit();
        }
    }
}
