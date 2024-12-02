<?php

$username = $_SESSION['userdata']['username'] ?? null;
echo "<p> Xin Chào  $username  </p>";
?>
<button id="logoutBt">log out</button>
<h1>danh sách công việc</h1>
<div style="display: flex;justify-content: center;" id="list-task"></div>
<button id="update_status_bt" style="margin: auto;display: block;margin-top: 20px;">Cập nhật trạng thái</button>
<div style="display: flex;justify-content: center;padding-top: 20px;">
    <div style="display: flex;flex-direction: column;width: 200px; " class="">
        <h2>Add Task</h2>
        <label for="title">Title:</label>
        <input type="text" id="titleAdd" name="title" placeholder="Enter task title">

        <label for="content">Content:</label>
        <textarea id="contentAdd" name="content" placeholder="Enter task content"></textarea>

        <label for="priority">Priority:</label>
        <select id="priorityAdd" name="priority">
            <option value="1">Low</option>
            <option value="2">Medium</option>
            <option value="3">High</option>
        </select>

        <input type="text" name="action" value="addTask" hidden>
        <button id="Add_bt" type="submit">Add Task</button>
        <p class="mess-add"></p>
    </div>
    <div style="padding-left: 20px;" class="">
        <h2>Tìm kiếm theo title</h2>
        <label for="title">Title:</label>
        <input type="text" id="titleSearch" name="title" placeholder="Enter task title">
        <button id="search_bt" type="submit">search Task</button>
        <div id="search_result"></div>
    </div>
    <div class="" style="display: flex;flex-direction: column; padding-left: 20px;">
        <h3>Xắp xếp</h3>
        <button id="sort_Status_Bt">xắp xếp theo trạng thái</button>
        <button id="sort_Priority_Bt">xắp xếp theo ưu tiên</button>

    </div>
    <div class="filter" style=" padding-left: 20px;">
        <h3>Lọc</h3>
        <label for="status">status:</label>
        <select id="status_filter" name="status">
            <option class="incom_option" value="incomplete">incomplete</option>
            <option class="com_option" value="completed">completed</option>
        </select>
        <label for="priority">Priority:</label>
        <select id="priority_filter" name="priority">
            <option value="1">Low</option>
            <option value="2">Medium</option>
            <option value="3">High</option>
        </select>
        <button id="filterBt">Lọc</button>
        <div id="filter_result"></div>
    </div>
</div>

<script>
    $(document).ready(function() {
        function feshTasks() {
            $.ajax({
                url: 'http://localhost/todolistMax/api/task_route.php/task',
                method: 'GET',
                data: {

                },
                success: function(responeJson) {
                    let respone = JSON.parse(responeJson);
                    let html = '';
                    respone.data.forEach((element, index) => {
                        let priorityText = '';
                        if (element.priority === 1) {
                            priorityText = 'low';
                        } else if (element.priority === 2) {
                            priorityText = 'medium';
                        } else if (element.priority === 3) {
                            priorityText = 'hard';
                        }
                        html += `
            <div style="padding-left: 10px;" >
            <div class="${element.status} task-item" data-index=${index}> 
                <h3>Title: ${element.title}</h3>
                <p>Status: ${element.status}</p>
                <p>Content: ${element.content}</p>
                <p>Priority: ${priorityText}</p>
                <input class="checkComplete" type="checkbox" data-index=${index} task_id=${element.task_id} >
                <label>Đã hoàn thành</label>    
            </div>
            <div style="display: flex;">
                <a href="index.php?page=edit_form&task_id=${element.task_id}">Sửa</a> 
                    <input id="delete-task" type="submit" task_id=${element.task_id} value="Xóa"/>
            </div>
        </div>`
                    });
                    $('#list-task').html(html);
                    const list_task_item = $('.task-item');
                    const checkCompletes = $('.checkComplete');
                    $('.completed').each(function() {
                        let index = $(this).attr('data-index');
                        $(checkCompletes[index]).css({
                            'display': 'none'
                        });
                        $(this).css({
                            'text-decoration': 'line-through',
                            'opacity': '0.5',
                            'font-style': 'italic'
                        });
                    });
                    let task_ids_complete = [];
                    checkCompletes.each(function(index, checkbox) {
                        $(checkbox).on('change', function() {
                            if ($(checkbox).prop('checked')) {
                                task_ids_complete.push($(checkbox).attr('task_id'));
                            }
                        });
                    });
                    $('#update_status_bt').on('click', function() {
                        $.ajax({
                            url: 'http://localhost/todolistMax/api/task_route.php/compeltes',
                            method: 'POST',
                            data: {
                                task_ids: task_ids_complete
                            },
                            success: function() {
                                feshTasks();
                            },
                            error: function(jqXHR, textStatus, errorThrown) {

                            }
                        });
                    })
                },
                error: function(jqXHR, textStatus, errorThrown) {

                    if (jqXHR.responseText) {
                        let respone = JSON.parse(jqXHR.responseText);
                        $('#mess').text(respone.message);
                    }

                }
            })
        };

        function sortStatus() {
            $.ajax({
                url: 'http://localhost/todolistMax/api/task_route.php/task',
                method: 'GET',
                data: {

                },
                success: function(responeJson) {
                    let respone = JSON.parse(responeJson);
                    let html = '';
                    respone.data.sort((a, b) => a.completed - b.completed);
                    respone.data.forEach((element, index) => {
                        let priorityText = '';
                        if (element.priority === 1) {
                            priorityText = 'low';
                        } else if (element.priority === 2) {
                            priorityText = 'medium';
                        } else if (element.priority === 3) {
                            priorityText = 'hard';
                        }
                        html += `
            <div style="padding-left: 10px;" >
            <div class="${element.status} task-item" data-index=${index}> 
                <h3>Title: ${element.title}</h3>
                <p>Status: ${element.status}</p>
                <p>Content: ${element.content}</p>
                <p>Priority: ${priorityText}</p>
                <input class="checkComplete" type="checkbox" id="checkbox1" task_id=${element.task_id} >
                <label>Đã hoàn thành</label>    
            </div>
            <div style="display: flex;">
                <a href="index.php?page=edit_form&task_id=${element.task_id}">Sửa</a> 
                    <input id="delete-task" type="submit" task_id=${element.task_id} value="Xóa"/>
            </div>
        </div>`
                    });
                    $('#list-task').html(html);
                },
                error: function(jqXHR, textStatus, errorThrown) {

                    if (jqXHR.responseText) {
                        let respone = JSON.parse(jqXHR.responseText);
                        $('#mess').text(respone.message);
                    }

                }
            })
        }

        function sortPriority() {
            $.ajax({
                url: 'http://localhost/todolistMax/api/task_route.php/task',
                method: 'GET',
                data: {

                },
                success: function(responeJson) {
                    let respone = JSON.parse(responeJson);
                    let html = '';
                    respone.data.sort((a, b) => a.priority - b.priority);
                    respone.data.forEach((element, index) => {
                        let priorityText = '';
                        if (element.priority === 1) {
                            priorityText = 'low';
                        } else if (element.priority === 2) {
                            priorityText = 'medium';
                        } else if (element.priority === 3) {
                            priorityText = 'hard';
                        }
                        html += `
            <div style="padding-left: 10px;" >
            <div class="${element.status} task-item" data-index=${index}> 
                <h3>Title: ${element.title}</h3>
                <p>Status: ${element.status}</p>
                <p>Content: ${element.content}</p>
                <p>Priority: ${priorityText}</p>
                <input class="checkComplete" type="checkbox" id="checkbox1" task_id=${element.task_id} >
                <label>Đã hoàn thành</label>    
            </div>
            <div style="display: flex;">
                <a href="index.php?page=edit_form&task_id=${element.task_id}">Sửa</a> 
                    <input id="delete-task" type="submit" task_id=${element.task_id} value="Xóa"/>
            </div>
        </div>`
                    });
                    $('#list-task').html(html);
                },
                error: function(jqXHR, textStatus, errorThrown) {

                    if (jqXHR.responseText) {
                        let respone = JSON.parse(jqXHR.responseText);
                        $('#mess').text(respone.message);
                    }

                }
            })
        }
        $(document).on('click', '#delete-task', function() {
            let task_id = $(this).attr('task_id');
            $.ajax({
                url: 'http://localhost/todolistMax/api/task_route.php/delete',
                method: 'POST',
                data: {
                    task_id: task_id
                },
                success: function(responseDeleteJson) {
                    let response = JSON.parse(responseDeleteJson);
                    alert(response.message);
                    feshTasks();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    if (jqXHR.responseText) {
                        let respone = JSON.parse(jqXHR.responseText);
                        alert(respone.message);
                    }
                }
            });
        });

        $(document).on('change', '.checkComplete', function() {

            if ($(this).prop('checked')) {

                $(this).css({
                    'text-decoration': 'line-through',
                    'opacity': '0.5',
                    'font-style': 'italic'
                });
            } else {
                $(this).css({
                    'text-decoration': 'none',
                    'opacity': '1',
                    'font-style': 'normal'
                });
            }
        })
        $('#Add_bt').on('click', function() {
            $.ajax({
                url: 'http://localhost/todolistMax/api/task_route.php/add',
                method: 'POST',
                data: {
                    title: $('#titleAdd').val(),
                    content: $('#contentAdd').val(),
                    priority: $('#priorityAdd').val()
                },
                success: function(responseJson) {
                    let response = JSON.parse(responseJson);
                    $('.mess-add').text(response.message);
                    $('#titleAdd').val('');
                    $('#contentAdd').val('');
                    feshTasks();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    if (jqXHR.responseText) {
                        let respone = JSON.parse(jqXHR.responseText);
                        $('.mess-add').text(respone.message);
                    }
                }
            });
        })
        $('#search_bt').on('click', function() {
            $.ajax({
                url: 'http://localhost/todolistMax/api/task_route.php/task',
                method: 'GET',
                data: {
                    title: $('#titleSearch').val(),
                },
                success: function(responseJson) {
                    let response = JSON.parse(responseJson);
                    let html = '';
                    response.data.forEach(function(element) {
                        let priorityText = '';
                        if (element.priority === 1) {
                            priorityText = 'low';
                        } else if (element.priority === 2) {
                            priorityText = 'medium';
                        } else if (element.priority === 3) {
                            priorityText = 'hard';
                        }
                        html += `<div> <p>Title: ${element.title}</p>
                <p>Status: ${element.status}</p>
                <p>Content: ${element.content}</p>
                <p>Priority: ${priorityText}</p> </div>`
                    })
                    $('#search_result').html(html);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    if (jqXHR.responseText) {
                        let respone = JSON.parse(jqXHR.responseText);
                        $('#search_result').text(respone.message);
                    }
                }
            });
        })
        $('#logoutBt').on('click', function() {
            $.ajax({
                url: 'http://localhost/todolistMax/api/authen_route.php/logout',
                method: 'POST',
                data: {

                },
                success: function() {
                    window.location.href = 'index.php';
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    if (jqXHR.responseText) {
                        let respone = JSON.parse(jqXHR.responseText);
                        alert(respone.message);
                    }
                }
            });
        })
        $('#sort_Status_Bt').on('click', function() {
            sortStatus();
        })
        $('#sort_Priority_Bt').on('click', function() {
            sortPriority();
        })
        $('#filterBt').on('click', function() {
            $.ajax({
                url: 'http://localhost/todolistMax/api/task_route.php/filter',
                method: 'POST',
                data: {
                    status: $('#status_filter').val(),
                    priority: $('#priority_filter').val()
                },
                success: function(responeJson) {
                    let response = JSON.parse(responeJson);
                    let html = '';
                    response.data.forEach(function(element) {
                        let priorityText = '';
                        if (element.priority === 1) {
                            priorityText = 'low';
                        } else if (element.priority === 2) {
                            priorityText = 'medium';
                        } else if (element.priority === 3) {
                            priorityText = 'hard';
                        }
                        html += `<div> <p>Title: ${element.title}</p>
                <p>Status: ${element.status}</p>
                <p>Content: ${element.content}</p>
                <p>Priority: ${priorityText}</p> </div>`
                    })
                    $('#filter_result').html(html);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    if (jqXHR.responseText) {
                        let respone = JSON.parse(jqXHR.responseText);
                        $('#filter_result').text(respone.message);
                    }
                }
            });
        })
        feshTasks();
    })
</script>