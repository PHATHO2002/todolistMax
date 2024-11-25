<form action="" method="POST" style="display: flex; flex-direction: column; align-items: center; width: 300px; margin: auto; border: 1px solid #ccc; padding: 20px; border-radius: 8px;">
    <h2 style="text-align: center;">Edit Task</h2>

    <label for="title" style="margin-bottom: 5px;">Title:</label>
    <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($task['title']); ?>" required placeholder="Enter task title" style="width: 100%; padding: 8px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 4px;">

    <label for="status" style="margin-bottom: 5px;">Status:</label>
    <select id="status" name="status" style="width: 100%; padding: 8px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 4px;">
        <option value="incomplete" <?php echo ($task['status'] == 'incomplete') ? 'selected' : ''; ?>>Incomplete</option>
        <option value="completed" <?php echo ($task['status'] == 'completed') ? 'selected' : ''; ?>>completed</option>
    </select>

    <label for="content" style="margin-bottom: 5px;">Content:</label>
    <input type="text" id="content" name="content" value="<?php echo htmlspecialchars($task['content']); ?>" placeholder="Enter task content" required style="width: 100%; padding: 8px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 4px;">

    <label for="priority" style="margin-bottom: 5px;">Priority:</label>
    <select id="priority" name="priority" style="width: 100%; padding: 8px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 4px;">
        <option value="1" <?php echo ($task['priority'] == 'low') ? 'selected' : ''; ?>>Low</option>
        <option value="2" <?php echo ($task['priority'] == 'medium') ? 'selected' : ''; ?>>Medium</option>
        <option value="3" <?php echo ($task['priority'] == 'high') ? 'selected' : ''; ?>>High</option>
    </select>
    <input type="text" name="task_id" value="<?php echo htmlspecialchars($task['task_id']); ?>" style="display: none;">

    <input type="text" name="action" value="updateTask" style="display: none;">
    <button type="submit" style="padding: 10px 20px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer;">Update</button>

    <a href="index.php" style="margin-top: 10px; text-decoration: none; color: #007bff;">Quay về trang chính</a>

    <?php
    if (isset($_GET['err'])) {
        $err = htmlspecialchars($_GET['err']);
        echo "<p style='color: red;'>$err</p>";
    }
    ?>
</form>