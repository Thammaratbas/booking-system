<?php

session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="CSS/welcome.css">
</head>

<body class="vh-100 gradient-custom">

    <!-- Login Form -->
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card p-5">
                    <div class="card-body">
                        <div class="mb-md-5 mt-md-4 pb-5">
                            <?php include_once('alert.php'); ?>
                            <h2 class="fw-bold mb-5">Login</h2>
                            <form action="action.php" method="POST">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control my-2" placeholder="email">
                                <label for="password">Password</label>
                                <input type="password" name="password" class="form-control my-2" placeholder="password">
                                <div class="d-grid gap-4 mt-5">
                                    <button type="submit" class="btn btn-secondary btn-lg my-2" name="login">Login</button>
                                </div>
                            </form>
                            <h3>If you are not yet a member, <a href="register.php">click here</a> to become a member.</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End -->


    <!-- Script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <!-- End -->
</body>

</html>