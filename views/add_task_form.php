<form action="" method="POST" style="display: flex; flex-direction: column; align-items: center; width: 300px; margin: auto; border: 1px solid #ccc; padding: 20px; border-radius: 8px;">
    <h2 style="text-align: center;">Add Task</h2>
    <label for="title" style="margin-bottom: 5px;">Title:</label>
    <input type="text" id="title" name="title" placeholder="Enter task title" style="width: 100%; padding: 8px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 4px;">


    <label for="content" style="margin-bottom: 5px;">Content:</label>
    <textarea id="content" name="content" placeholder="Enter task content" style="width: 100%; padding: 8px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 4px;"></textarea>

    <label for="priority" style="margin-bottom: 5px;">Priority:</label>
    <select id="priority" name="priority" style="width: 100%; padding: 8px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 4px;">
        <option value="1">Low</option>
        <option value="2">Medium</option>
        <option value="3">High</option>
    </select>
    <input type="text" style="display: none;" name="action" value="addTask">
    <button type="submit" style="padding: 10px 20px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer;">Add Task</button>
    <a href="index.php">Quay về trang chính</a>
    <?php if (isset($_GET['err'])) {
        $err = $_GET['err'];
        echo "<p>$err</p>";
    } ?>
</form>