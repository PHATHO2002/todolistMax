<body>
    <form style="width: 200px;
        display: flex;
        margin: auto;
        flex-direction: column;" action="" method="POST">
        <h1>Đăng ký</h1>
        <div class="">
            <label for="userName">username</label>
            <input type="text" name="username">
        </div>
        <div class="">
            <label for="pass">pass</label>
            <input type="password" name="pass">
        </div>
        <input style="display: none;" type="text" name="action" value="signin">
        <div class="">
            <input type="submit" value="Đăng ký">
            <a href="index.php?action=get_fom_login">Đăng Nhập tại đây</a>
        </div>
        <?php if (isset($_GET['err'])) {
            $err = $_GET['err'];
            echo "<p>$err</p>";
        } ?>
    </form>