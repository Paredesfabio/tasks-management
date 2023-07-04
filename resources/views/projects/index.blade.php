<!-- resources/views/projects/index.blade.php -->
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
        <h1>Projects</h1>
        <ul class="list-group">
            @foreach ($projects as $project)
                <li class="list-group-item">{{ $project->name }}</li>
            @endforeach
        </ul>
        <br>
        <form id="createProjectForm" class="mb-3">
            <div class="row">
                <div class="col-md-6">
                    <input type="text" name="name" class="form-control" placeholder="Project Name" required>
                </div>
                <div class="col-md-6">
                    <input type="text" name="description" class="form-control" placeholder="Project Description">
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Create Project</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Submit form via AJAX
        $("#createProjectForm").submit(function(e) {
            e.preventDefault();
            var formData = $(this).serialize();

            $.ajax({
                type: 'POST',
                url: "{{ route('projects.store') }}",
                data: formData,
                success: function(response) {
                    console.log(response);
                    var newProject = '<li class="list-group-item">' + response.name + '</li>';
                    $("ul.list-group").append(newProject);
                    $("#createProjectForm")[0].reset();
                }
            });
        });
    </script>
</body>
</html>
