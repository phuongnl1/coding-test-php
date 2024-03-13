<!doctype html>
<html lang="en">

<head>
    <title>Logout</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>

<body>
    <script>
        localStorage.removeItem('token');
        localStorage.removeItem('user_id');
        localStorage.removeItem('email');
        // redirect to Article Management page
        window.location.href = '/user/login';
    </script>
</body>

</html>
