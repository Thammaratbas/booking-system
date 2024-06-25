<?php

session_start();
require_once('config/config.php');

if (!isset($_SESSION['userId'])) {
    header('Location: login.php');
}

if ($_SESSION['userRank'] !== 1) {
    header('Location: user.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="CSS/nav.css">
    <link rel="stylesheet" href="CSS/welcome.css">

    <style>
        body {
            min-height: 75rem;
            padding-top: 4.5rem;
        }
    </style>

</head>

<body>

    <?php require_once('nav.php'); ?>
    <?php include_once('alert.php'); ?>
    <?php
    require_once "db.php";
    $db = new Database();

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $schedule = $db->readOne($id);
    } else {
        echo "Schedules ID not provided.";
    }
    ?>
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card p-5">
                    <div class="card-body">
                        <div class="mb-md-2 mt-md-4 pb-5">
                            <?php require_once('alert.php'); ?>
                            <h2 class="fw-bold mb-5">Edit This User</h2>
                            <form action="save_edit_user.php" method="post">
                                <input type="hidden" name="id" value="<?= $schedule['id'] ?>">
                                <label for="fname">First Name</label>
                                <input type="text" name="fname" class="form-control my-2" placeholder="First name" value="<?= $schedule['firstname'] ?>">
                                <label for="lname">Last Name</label>
                                <input type="text" name="lname" class="form-control my-2" placeholder="Last name" value="<?= $schedule['lastname'] ?>">
                                <label for="phone">Phone</label>
                                <input type="text" name="phone" class="form-control my-2" placeholder="Phone" value="<?= $schedule['phone'] ?>">
                                <label for="pid">Personnel ID</label>
                                <input type="text" name="pid" class="form-control my-2" placeholder="Personnel ID" value="<?= $schedule['personnelid'] ?>">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control my-2" placeholder="Email" value="<?= $schedule['email'] ?>">
                                <label for="rank">Rank</label>
                                <input type="text" name="rank" class="form-control my-2" placeholder="Rank" value="<?= $schedule['rank'] ?>">
                                <div class="d-grid gap-2 col-6 mx-auto">
                                    <button type="submit" class="btn btn-success btn-sm rounded-pull py-0" name="update_user">Save</button>
                                    <a href="userlist.php" class="btn btn-danger btn-sm rounded-pull py-0" name="cancel">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <!-- <script src="js/main.js"></script> -->
    <!-- End -->
</body>

</html>