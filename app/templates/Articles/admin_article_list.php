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
    .row.content {height: 1500px}

    /* Set gray background color and 100% height */
    .sidenav {
      background-color: #f1f1f1;
      height: 100%;
    }

    /* On small screens, set height to 'auto' for sidenav and grid */
    @media screen and (max-width: 767px) {
      .sidenav {
        height: auto;
        padding: 15px;
      }
      .row.content {height: auto;}
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
    <div class="col-sm-9" id="articles">
    </div>
  </div>
</div>
<script>
        $(document).ready(function() {
            $.ajax({
                    type: 'GET',
                    url: '/articles.json',
                    headers: {
                        "Authorization": "Bear " + localStorage.getItem('token')
                    },
                    success: function(response) {
                        var html = '';
                        response.articles.forEach((item) => {
                            html += `
                                <h2>${item.title}</h2>
                                <h5><span class="glyphicon glyphicon-time"></span> Post by ${item.user.email}, ${item.created_at}.</h5>
                                <h5><span class="label label-primary">${item.likes} likes</span> <span data-id="${item.id}" class="label label-danger delete-button">Delete</span><br></h5>
                                <p>${item.body}</p>
                                <hr>
                            `;
                            });
                        $('#articles').html(html);

                        $('.delete-button').each(function () {
                            var $this = $(this);
                            $this.on("click", function () {
                                var article_id = $(this).data('id');
                                var url = `/articles/${article_id}.json`;
                                console.log(article_id);
                                callAjax(url, 'DELETE', localStorage.getItem('token'), '/admin/article/list');
                            });
                        });
                    },
                    error: function(xhr, status, error) {
                        // Display error message
                        $('#articles').text(xhr.responseJSON.message);
                    }
                });

            function callAjax($url, $method, $token, $redirect) {
                console.log($token);
                $.ajax({
                    type: $method,
                    url: $url,
                    headers: {
                        "Authorization": "Bear " + $token
                    },
                    success: function(response) {
                        console.log(response);
                        window.location.href = $redirect;
                    },
                    error: function(xhr, status, error) {
                        // Display error message
                        $('#articles').text(xhr.responseJSON.message);
                    }
                });
            }
            });
    </script>
</body>
</html>
