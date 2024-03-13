<!DOCTYPE html>
<html lang="en">

<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
        /* Set height of the grid so .sidenav can be 100% (adjust if needed) */
        .row.content {
            height: 1500px
        }

        /* Set gray background color and 100% height */
        .sidenav {
            background-color: #f1f1f1;
            height: 100%;
        }

        .custom_hidden {
            display: none;
        }

        /* On small screens, set height to 'auto' for sidenav and grid */
        @media screen and (max-width: 767px) {
            .sidenav {
                height: auto;
                padding: 15px;
            }

            .row.content {
                height: auto;
            }
        }
    </style>
</head>

<body>

    <div class="container-fluid">
        <div class="row content">
            <div class="col-sm-3 sidenav">
                <h4>Article Management</h4>
                <ul class="nav nav-pills nav-stacked">
                    <li><a href="/admin/article/list">Articles list</a></li>
                    <li><a href="/admin/article/create">Create new article</a></li>
                    <li><a href="#section2">Logout</a></li>
                </ul>
            </div>
            <div class="col-sm-9">
                <div class="card">
                    <div class="card-header">
                        <h1>Create new article</h1>
                    </div>

                    <div class="card-body">
                        <div id="error-msg" class="alert alert-danger custom_hidden"></div>
                        <form id="create-form">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" id="title" name="title" required>
                            </div>
                            <div class="form-group">
                                <label for="body">Body</label>
                                <textarea class="form-control" name="body" id="body" rows="3"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Create</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#create-form').submit(function(event) {
                event.preventDefault();
                var formData = {
                    title: $('#title').val(),
                    body: $('#body').val(),
                    user_id: localStorage.getItem('user_id'),
                    created_at: '2024-03-12 01:20:22',
                    updated_at: '2024-03-12 01:20:22'
                };

                $.ajax({
                    type: 'POST',
                    url: '/articles.json',
                    headers: {
                        "Authorization": "Bear " + localStorage.getItem('token')
                    },
                    data: formData,
                    success: function(response) {
                        localStorage.setItem('token', response.token);
                        // redirect to Article Management page
                        window.location.href = '/admin/article/list';
                    },
                    error: function(xhr, status, error) {
                        // Display error message
                        $('#error-msg').text(xhr.responseJSON.message);
                        $('#error-msg').removeClass("custom_hidden");
                    }
                });
            });
        });
    </script>
</body>

</html>
