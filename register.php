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
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card p-5">
                    <div class="card-body">
                        <div class="mb-md-2 mt-md-4 pb-5">
                            <?php require_once('alert.php'); ?>
                            <h2 class="fw-bold mb-5">Register</h2>
                            <form action="action.php" method="POST">
                                <label for="fname">First name</label>
                                <input type="text" name="fname" class="form-control my-2" placeholder="first name">
                                <label for="lname">Last name</label>
                                <input type="text" name="lname" class="form-control my-2" placeholder="last name">
                                <label for="phone">Phone</label>
                                <input type="text" name="phone" class="form-control my-2" placeholder="phone">
                                <label for="pid">Personnel ID</label>
                                <input type="text" name="pid" class="form-control my-2" placeholder="personnel id">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control my-2" placeholder="email">
                                <label for="password">Password</label>
                                <input type="password" name="password" class="form-control my-2" placeholder="password">
                                <label for="password">Confirm Password</label>
                                <input type="password" name="c_password" class="form-control my-2" placeholder="confirm password">
                                <input type="hidden" name="rank" value="0">
                                <div class="d-grid gap-2 col-6 mx-auto">
                                    <button type="submit" class="btn btn-secondary btn-lg mt-5" name="register">Register</button>
                                </div>
                            </form>
                            <h3>If you are already a member, <a href="login.php">click here</a> to log in.</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>