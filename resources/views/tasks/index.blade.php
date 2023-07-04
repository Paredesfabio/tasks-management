<!-- resources/views/tasks/index.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Managament Tasks with Projects') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">

</head>
<body>
    <div class="container">
        <h1>{{ config('app.name', 'Managament Tasks with Projects') }}</h1>
        <div class="row">
            <div class="col-md-4">
                <select id="projectSelect" class="form-select mb-3">
                    <option value="">All Projects</option>
                    @foreach ($projects as $project)
                        <option value="{{ $project->id }}">{{ $project->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div id="taskList" class="mb-3">
            @foreach ($tasks as $task)
                <div class="taskItem card mb-2" data-task-id="{{ $task->id }}" data-project-id="{{ $task->project_id }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $task->name }}</h5>
                        <p class="card-text">Priority: {{ $task->priority }}</p>
                        <div class="d-flex">
                            <button class="btn btn-sm btn-primary editTaskBtn" data-task-id="{{ $task->id }}" style="margin-right: 10px;">Edit</button>
                            <form class="deleteTaskForm" style="display: inline-block;" action="{{ route('tasks.destroy', $task->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger alert-delete">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <form id="createTaskForm" class="mb-3">
            <div class="row">
                <div class="col-md-6">
                    <input type="text" name="name" class="form-control" placeholder="Task Name" required>
                </div>
                <div class="col-md-4">
                    <select name="project_id" class="form-select" required>
                        <option value="">Select Project</option>
                        @foreach ($projects as $project)
                            <option value="{{ $project->id }}">{{ $project->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">Create Task</button>
                </div>
            </div>
        </form>
    </div>

    <div class="modal fade" id="editTaskModal" tabindex="-1" aria-labelledby="editTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTaskModalLabel">Edit Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editTaskForm">
                        @csrf
                        @method('PATCH')
                        <div class="mb-3">
                            <label for="editTaskName" class="form-label">Task Name</label>
                            <input type="text" class="form-control" id="editTaskName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="editTaskProject" class="form-label">Project</label>
                            <select class="form-select" id="editTaskProject" name="project_id" required>
                                @foreach ($projects as $project)
                                    <option value="{{ $project->id }}">{{ $project->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Task</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        var csrfToken = "{{ csrf_token() }}";

        $(function() {
            $("#taskList").sortable({
                axis: 'y',
                update: function(event, ui) {
                    var taskIds = [];
                    $('.taskItem').each(function() {
                        taskIds.push($(this).data('task-id'));
                    });
                    $.ajax({
                        type: 'PATCH',
                        url: "{{ route('tasks.updatePriorities') }}",
                        data: {
                            task_ids: taskIds
                        },
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        success: function(response) {
                            console.log(response);
                            $("#taskList").empty();
                            response.forEach(function(task) {
                                var taskItem = '<div class="taskItem card mb-2" data-task-id="' + task.id + '" data-project-id="' + task.project_id + '">' +
                                                '<div class="card-body">' +
                                                '<h5 class="card-title">' + task.name + '</h5>' +
                                                '<p class="card-text">Priority: ' + task.priority + '</p>' +
                                                '<div class="d-flex">' +
                                                '<button class="btn btn-sm btn-primary editTaskBtn" data-task-id="' + task.id + '" style="margin-right: 10px;">Edit</button>' +
                                                '<form class="deleteTaskForm" style="display: inline-block;" action="{{ route('tasks.destroy', '') }}/' + task.id + '" method="POST">' +
                                                '@csrf' +
                                                '@method('DELETE')' +
                                                '<button type="submit" class="btn btn-sm btn-danger alert-delete">Delete</button>' +
                                                '</form>' +
                                                '</div>' +
                                                '</div>' +
                                                '</div>';
                                $("#taskList").append(taskItem);
                            });
                        }
                    });
                }
            });

            $("#projectSelect").change(function() {
                var selectedProjectId = $(this).val();
                $('.taskItem').hide();
                if (selectedProjectId) {
                    $('.taskItem[data-project-id="' + selectedProjectId + '"]').show();
                } else {
                    $('.taskItem').show();
                }
            });

            $('.editTaskBtn').click(function() {
                var taskId = $(this).data('task-id');
                var taskItem = $('.taskItem[data-task-id="' + taskId + '"]');
                var taskName = taskItem.find('.card-title').text().trim();
                var taskProjectId = taskItem.data('project-id');

                $('#editTaskForm').attr('action', "{{ route('tasks.update', '') }}" + '/' + taskId);
                $('#editTaskForm').find('input[name="name"]').val(taskName);
                $('#editTaskForm').find('select[name="project_id"]').val(taskProjectId);
                $('#editTaskModal').modal('show');
            });

            // Submit form via AJAX
            $("#createTaskForm").submit(function(e) {
                e.preventDefault();
                var formData = $(this).serialize();

                $.ajax({
                    type: 'POST',
                    url: "{{ route('tasks.store') }}",
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function(response) {
                        console.log(response);
                        // Append new task to the task list
                        var newTask = '<div class="taskItem card mb-2" data-task-id="' + response.id + '" data-project-id="' + response.project_id + '">' +
                            '<div class="card-body">' +
                            '<h5 class="card-title">' + response.name + '</h5>' +
                            '<p class="card-text">Priority: ' + response.priority + '</p>' +
                            '<div class="d-flex">' +
                            '<button class="btn btn-sm btn-primary editTaskBtn" data-task-id="' + response.id + '">Edit</button>' +
                            '<form class="deleteTaskForm" style="display: inline-block;" action="{{ route('tasks.destroy', '') }}/' + response.id + '" method="POST">' +
                            '@csrf' +
                            '@method('DELETE')' +
                            '<button type="submit" class="btn btn-sm btn-danger">Delete</button>' +
                            '</form>' +
                            '</div>' +
                            '</div>' +
                            '</div>';
                        $("#taskList").append(newTask);
                        $("#createTaskForm")[0].reset();
                    }
                });
            });

            $('.alert-delete').click(function(event){
                var form =  $(this).closest("form");
                event.preventDefault();
                Swal.fire({
                    title: 'DELETE TASK',
                    text: 'Do you want to continue ?',
                    icon: 'warning',
                    showConfirmButton: true,
                    showDenyButton: true,
                    confirmButtonText: 'Confirm',
                    denyButtonText: 'Cancel',
                }).then((result) => {
                    if (result.isConfirmed) form.submit();
                })

            });
        });
    </script>
</body>
</html>
