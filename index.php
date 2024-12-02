<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

<body>
    <?php
    if (isset($_SESSION["userdata"])) {
        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            if (isset($_GET["page"])) {
                switch ($_GET["page"]) {
                    case "edit_form":
                        include_once("views/edit_task_form.php");
                        break;
                }
            } else {
                include_once 'views/index.php';
            }
        }
    } else {
        if (isset($_GET['page']) && $_GET['page'] == 'signin') {
            include_once "views/sign_in_form.php";
        } else {
            include_once "views/login_form.php";
        }
    }
    ?>
</body>

</html>