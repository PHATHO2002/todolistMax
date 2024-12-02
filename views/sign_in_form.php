<body>
    <div style="width: 200px;
        display: flex;
        margin: auto;
        flex-direction: column;">
        <h1>Đăng ký</h1>
        <div class="">
            <label for="userName">username</label>
            <input id="username" type="text" name="username">
        </div>
        <div class="">
            <label for="pass">pass</label>
            <input id="password" type="password" name="password">
        </div>
        <div class="">
            <input id="signin" type="button" value="Đăng ký">
            <a href="index.php">Đăng Nhập tại đây</a>
        </div>
        <p id="mess"></p>
    </div>
    <script>
        $('document').ready(function() {
            $('#signin').on('click', function() {
                $.ajax({
                    url: 'http://localhost/todolistMax/api/authen_route.php/signin',
                    method: 'POST',
                    data: {
                        username: $('#username').val(),
                        password: $('#password').val()
                    },
                    success: function(responseJson) {
                        let response = JSON.parse(responseJson);
                        $('#mess').text(response.message);
                        $('#username').val('');
                        $('#password').val('');
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