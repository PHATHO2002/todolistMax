<?php
$username = $_SESSION['userdata']['username'];
echo "<p> Xin Chào  $username  </p>";
echo '<form action="" method="POST">
<input style="display: none;" type="text" name="action" value="logout">
<input type="submit" value="đăng xuất">
</form>';
echo '<h1>List danh sách công việc</h1>';
echo '<div class="list-task-item" style="display: flex; align-items: center; justify-content: center;">';

if (isset($Sort)) {
    if ($Sort == 'sort_status') {
        usort($tasks, function ($a, $b) {
            return $a['completed'] - $b['completed'];
        });
    } else if ($Sort == 'sort_priority') {
        usort($tasks, function ($a, $b) {
            return $a['priority'] - $b['priority'];
        });
    }
}

if (empty($tasks)) {
    echo '<h1> danh sách trống</h1>';
} else {
    $priority_map = [
        1 => 'Low',
        2 => 'Medium',
        3 => 'High'
    ];

    foreach ($tasks as $key => $task) {
        $priority_text = isset($priority_map[$task['priority']]) ? $priority_map[$task['priority']] : 'Unknown';
        echo '
        <div style="padding-left: 10px;"  >
            <div class="' . $task['status'] . ' task-item" data-index=' . $key . ' > 
                <h3>Title: ' . $task['title'] . '</h3>
                <p>Status: ' . $task['status'] . '</p>
                <p>Content: ' . $task['content'] . '</p>
                <p>Priority: ' .  $priority_text . '</p>
                <input class="checkComplete" type="checkbox" id="checkbox1" task_id=' . $task['task_id'] . ' >
                <label>Đã hoàn thành</label>    
            </div>
            <div style="display: flex;">
                <a href="index.php?action=get_edit_task_fr&taskId=' . $task['task_id'] . '">Sửa</a>
                <form action="" method="POST">
                    <input style="display: none;" name="task_id" value="' . $task['task_id'] . '"/> 
                    <input style="display: none;" name="action" value="deleteTask"/> 
                    <input type="submit" value="Xóa"/>
                </form>
            </div>
        </div>';
    }
}

echo ' </div>';

echo '
<div class="" style="display: flex; justify-content: center;">
    <form style="padding: 10px;" action="" method="POST">
        <input name="listIdToUpdate" class="listToUpdate" style="display: none;">
        <input style="display: none;" name="action" value="updateListCompleted"/> 
        <input type="submit" value="cập nhập trạng thái">
    </form>
</div>
';

echo '<div style="display: flex; justify-content: center;">';
echo '<div style="padding: 10px;"><a href="index.php?action=get_add_task_fr">add new task</a></div>';
echo '<div style="padding: 10px;"><a href="index.php?action=sort_status">xắp xếp theo trạng thái</a></div>';
echo '<div style="padding: 10px;"><a href="index.php?action=sort_priority">xắp xếp theo độ ưu tiên</a></div>';
echo '<div style="padding: 10px;"><a href="index.php">Mặc định</a></div>';
echo '<form style="padding: 10px;" action="" method="POST">
    <select name="value_filter" id="">
        <option value="1">low</option>
        <option value="2">medium</option>
        <option value="3">hard</option>
    </select>
    <input style="display: none;" name="action" type="text" value="filter">
    <input style="display: none;" name="filedName" type="text" value="priority">
    <input type="submit" value="Lọc ưu tiên ">
</form>';
echo '<form style="padding: 10px;" action="" method="POST">
    <select name="value_filter" id="">
        <option value="incomplete">incompeleted</option>
        <option value="completed">compeleted</option>
    </select>
    <input style="display: none;" name="action" type="text" value="filter">
    <input style="display: none;" name="filedName" type="text" value="status">
    <input type="submit" value="Lọc trạng thái">
</form>';
echo '</div>';
?>
<script>
    const checkCompletes = document.querySelectorAll('.checkComplete');
    const list_task_item = document.querySelectorAll('.task-item');
    const CompleteTasks = document.querySelectorAll('.completed');
    const listIdToUpdates = document.querySelector('.listToUpdate');

    CompleteTasks.forEach(function(e) {
        let index = e.getAttribute('data-index');
        checkCompletes[index].style.display = "none";
        e.style.textDecoration = 'line-through';
        e.style.opacity = '0.5';
        e.style.fontStyle = 'italic';
    });
    let idIndatas = [];
    checkCompletes.forEach(function(checkbox, index) {
        checkbox.addEventListener('change', function() {
            if (checkbox.checked) {
                idIndatas.push(checkbox.getAttribute('task_id'));
                listIdToUpdates.value = JSON.stringify(idIndatas);
                list_task_item[index].style.textDecoration = 'line-through';
                list_task_item[index].style.opacity = '0.5';
                list_task_item[index].style.fontStyle = 'italic';
            } else {
                list_task_item[index].style.textDecoration = 'none';
                list_task_item[index].style.opacity = '1';
                list_task_item[index].style.fontStyle = 'normal';
            }
        });
    });
</script>