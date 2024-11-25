<form style="  width: 200px;
        display: flex;
        margin: auto;
        flex-direction: column;" action="" method="post">
    <h1>đăng nhập</h1>
    <div class="">
        <label for="userName">userName</label>
        <input type="text" name="username">
    </div>
    <div class="">
        <label for="pass">pass</label>
        <input type="password" name="pass">
    </div>
    <input style="display: none;" type="text" name="action" value="login">
    <div class="">
        <input type="submit" value="đăng nhập">
        <a href="index.php?action=get_sign_form">Đăng ký tại đây</a>
    </div>
    <?php if (isset($_GET['err'])) {
        $err = $_GET['err'];
        echo "<p>$err</p>";
    } ?>
</form>