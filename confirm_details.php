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
        $room = $db->readWaitOneSchedules($id);
    } else {
        echo "Room ID not provided.";
    }
    ?>
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card p-5">
                    <div class="card-body">
                        <div class="mb-md-2 mt-md-4 pb-5">
                            <?php require_once('alert.php'); ?>
                            <h2 class="fw-bold mb-5">Register</h2>
                            <form>
                                <label for="user_id">User ID</label>
                                <input type="text" name="user_id" class="form-control my-2" placeholder="User ID" value="<?= $room['user_id'] ?>">
                                <label for="rname">Room Name</label>
                                <input type="text" name="rname" class="form-control my-2" placeholder="Room name" value="<?= $room['room_name'] ?>">
                                <label for="fname">First Name</label>
                                <input type="text" name="fname" class="form-control my-2" placeholder="First name" value="<?= $room['first_name'] ?>">
                                <label for="lname">Last Name</label>
                                <input type="text" name="lname" class="form-control my-2" placeholder="Last name" value="<?= $room['last_name'] ?>">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control my-2" placeholder="email" value="<?= $room['email'] ?>">
                                <label for="sdatetime">Start Datetime</label>
                                <input type="text" name="sdatetime" class="form-control my-2" placeholder="Start datetime" value="<?= $room['start_datetime'] ?>">
                                <label for="edatetime">End Datetime</label>
                                <input type="text" name="edatetime" class="form-control my-2" placeholder="End datetime" value="<?= $room['end_datetime'] ?>">
                                <label for="title">Title</label>
                                <input type="text" name="title" class="form-control my-2" placeholder="Title" value="<?= $room['title'] ?>">
                                <label for="description">Description</label>
                                <textarea name="description" class="form-control my-2" placeholder="Description"><?= $room['description'] ?></textarea>
                                <div class="d-grid gap-2 col-6 mx-auto">
                                    <a href="save_wait_schedule.php?id=<?= $room['id'] ?>" class="btn btn-success btn-sm rounded-pull py-0"  name="confirm">Confirm</a>
                                    <a href="delete_wait_schedule_admin.php?id=<?= $room['id'] ?>" class="btn btn-danger btn-sm rounded-pull py-0"  name="cancel">Cancel</a>
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