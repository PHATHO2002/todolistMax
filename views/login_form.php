<div style="  width: 200px;
        display: flex;
        margin: auto;
        flex-direction: column;" action="" method="post">
    <h1>đăng nhập</h1>
    <div class="">
        <label for="userName">userName</label>
        <input id="username" type="text" name="username">
    </div>
    <div class="">
        <label for="pass">pass</label>
        <input id="password" type="password" name="pass">
    </div>
    <input style="display: none;" type="text" name="action" value="login">
    <div class="">
        <input id="login" type="submit" value="đăng nhập">
        <a href="index.php?page=signin">Đăng ký tại đây</a>
    </div>
    <p id="mess"></p>
</div>
<script>
    $('document').ready(function() {
        $('#login').on('click', function() {
            $.ajax({
                url: 'http://localhost/todolistMax/api/authen_route.php/login',
                method: 'POST',
                data: {
                    username: $('#username').val(),
                    password: $('#password').val()
                },
                success: function() {
                    window.location.href = "index.php"
                },
                error: function(jqXHR, textStatus, errorThrown) {

                    if (jqXHR.responseText) {
                        let respone = JSON.parse(jqXHR.responseText);
                        $('#mess').text(respone.message);
                    }

                }
            })
        })
    })
</script>