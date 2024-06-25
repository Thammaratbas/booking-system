<?php

session_start();

if (!isset($_SESSION['userId'])) {
    header('Location: login.php');
}

if ($_SESSION['userRank'] !== 0) {
    header('Location: admin.php');
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

    <style>
        body {
            min-height: 75rem;
            padding-top: 4.5rem;
        }
    </style>

</head>

<body>

    <?php require_once('nav_user.php'); ?>
    <?php include_once('alert.php'); ?>

    <div class="container">
        <div class="row mt-4">
            <div class="col-lg-12 d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="text-primary">The room has been successfully reserved.</h4>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-lg-12">
                <div id="showAlert"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive">
                    <table class="table table-striped table-boredered text-center">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>User ID</th>
                                <th>Room Name</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Start Datetime</th>
                                <th>End Datetime</th>
                                <th>Title</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            require_once 'db.php';
                            $database = new Database();
                            $user_id = $_SESSION['userId'];
                            $schedules = $database->readUserSchedules($user_id);

                            if (empty($schedules)) {
                                echo "<tr><td colspan='10'>No Schedules In Database</td></tr>";
                            } else {
                                foreach ($schedules as $schedule) : ?>
                                    <tr>
                                        <td><?= $schedule['id'] ?></td>
                                        <td><?= $schedule['user_id'] ?></td>
                                        <td><?= $schedule['room_name'] ?></td>
                                        <td><?= $schedule['first_name'] ?></td>
                                        <td><?= $schedule['last_name'] ?></td>
                                        <td><?= $schedule['email'] ?></td>
                                        <td><?= $schedule['start_datetime'] ?></td>
                                        <td><?= $schedule['end_datetime'] ?></td>
                                        <td><?= $schedule['title'] ?></td>
                                        <td><?= $schedule['description'] ?></td>
                                    </tr>
                            <?php endforeach;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <br>
    <br>

    <div class="container">
        <div class="row mt-4">
            <div class="col-lg-12 d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="text-primary">In the process of verifying information.</h4>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-lg-12">
                <div id="showAlert"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive">
                    <table class="table table-striped table-boredered text-center">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>User ID</th>
                                <th>Room Name</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Start Datetime</th>
                                <th>End Datetime</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            require_once 'db.php';
                            $database = new Database();
                            $user_id = $_SESSION['userId'];
                            $schedules = $database->readUserWaitSchedules($user_id);

                            if (empty($schedules)) {
                                echo "<tr><td colspan='10'>No Schedules In Database</td></tr>";
                            } else {
                                foreach ($schedules as $schedule) : ?>
                                    <tr>
                                        <td><?= $schedule['id'] ?></td>
                                        <td><?= $schedule['user_id'] ?></td>
                                        <td><?= $schedule['room_name'] ?></td>
                                        <td><?= $schedule['first_name'] ?></td>
                                        <td><?= $schedule['last_name'] ?></td>
                                        <td><?= $schedule['email'] ?></td>
                                        <td><?= $schedule['start_datetime'] ?></td>
                                        <td><?= $schedule['end_datetime'] ?></td>
                                        <td><?= $schedule['title'] ?></td>
                                        <td><?= $schedule['description'] ?></td>
                                        <td>
                                            <a href="delete_wait_schedule.php?id=<?= $schedule['id'] ?>" class="btn btn-danger btn-sm rounded-pull py-0" name="delete">Delete</a>
                                        </td>
                                    </tr>
                            <?php endforeach;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <?php require_once('live_chat_user.php'); ?>

    <!-- Script -->
    <audio id="notificationSound" src="sound/notification.mp3" preload="auto" loop></audio>
    <script src="js/notificationUser.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <!-- End -->
</body>

</html>