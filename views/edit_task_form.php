<div style="display: flex;flex-direction: column;width: 200px;margin: auto;" class="">
    <h2>Edit Task</h2>
    <label for="title">Title:</label>
    <input style="display: none;" id="task_id" type="text" value="<?php
                                                                    if (isset($_GET['task_id'])) {
                                                                        echo $_GET['task_id'];
                                                                    } ?>">
    <input type="text" id="titleEdit" name="title" placeholder="Enter task title">

    <label for="content">Content:</label>
    <textarea id="contentEdit" name="content" placeholder="Enter task content"></textarea>
    <select id="statusEdit" name="status" style="width: 100%; padding: 8px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 4px;">
        <option class="incom_option" value="incomplete">incomplete</option>
        <option class="com_option" value="completed">completed</option>
    </select>

    <label for="priority">Priority:</label>
    <select id="priorityEdit" name="priority">
        <option value="1">Low</option>
        <option value="2">Medium</option>
        <option value="3">High</option>
    </select>

    <input type="text" name="action" value="addTask" hidden>
    <button id="update_bt" type="submit">Update Task</button>
    <p class="mess_Update"></p>
    <a href="index.php">về trang chính</a>
</div>
<script>
    $(document).ready(function() {
        function feshTask() {
            $.ajax({
                url: 'http://localhost/todolistMax/api/task_route.php/task',
                method: 'GET',
                data: {
                    task_id: <?php echo $_GET['task_id'] ?? null ?>
                },
                success: function(responeJson) {
                    let respone = JSON.parse(responeJson);
                    $('#titleEdit').val(respone.data['title']);
                    $('#contentEdit').val(respone.data['content']);
                    if (respone.data['status'] == 'incomplete') {
                        $('#statusEdit').val('incomplete');
                    } else {
                        $('#statusEdit').val('completed');

                    }
                    switch (respone.data['priority']) {
                        case 1:
                            $('#priorityEdit').val(1);
                            break;
                        case 2:
                            $('#priorityEdit').val(2);
                            break;
                        case 3:
                            $('#priorityEdit').val(3);
                            break;
                        default:
                            break;
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {

                    if (jqXHR.responseText) {
                        let respone = JSON.parse(jqXHR.responseText);
                        $('.mess_Update').text(respone.message);
                    }

                }
            })
        }
        feshTask();
        $('#update_bt').on('click', function() {
            $.ajax({
                url: 'http://localhost/todolistMax/api/task_route.php/update',
                method: 'POST',
                data: {
                    task_id: $('#task_id').val(),
                    title: $('#titleEdit').val(),
                    status: $('#statusEdit').val(),
                    content: $('#contentEdit').val(),
                    priority: $('#priorityEdit').val()
                },
                success: function(responeJson) {
                    let respone = JSON.parse(responeJson);
                    $('.mess_Update').text(respone.message);
                },
                error: function(jqXHR, textStatus, errorThrown) {

                    if (jqXHR.responseText) {
                        let respone = JSON.parse(jqXHR.responseText);
                        $('.mess_Update').text(respone.message);
                    }

                }
            })
        })
    })
</script>