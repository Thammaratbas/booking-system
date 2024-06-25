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

    <div class="container">
        <div class="row mt-4">
            <div class="col-lg-12 d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="text-primary">All users in the database</h4>
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
                                <th>Room ID</th>
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
                            $rooms = $database->readWaitSchedules();
                            foreach ($rooms as $room) : ?>
                                <tr>
                                    <td><?= $room['id'] ?></td>
                                    <td><?= $room['user_id'] ?></td>
                                    <td><?= $room['room_id'] ?></td>
                                    <td><?= $room['room_name'] ?></td>
                                    <td><?= $room['first_name'] ?></td>
                                    <td><?= $room['last_name'] ?></td>
                                    <td><?= $room['email'] ?></td>
                                    <td><?= $room['start_datetime'] ?></td>
                                    <td><?= $room['end_datetime'] ?></td>
                                    <td><?= $room['title'] ?></td>
                                    <td><?= $room['description'] ?></td>
                                    <td>
                                        <a href="confirm_details.php?id=<?= $room['id'] ?>" class="btn btn-success btn-sm rounded-pull py-0">Details</a>
                                    </td>
                                <?php endforeach; ?>
                </div>
            </div>
        </div>
        </tr>
        </tbody>
        </table>
    </div>
    </div>
    </div>
    </div>

    <?php require_once('live_chat_admin.php'); ?>

</body>

<!-- Script -->
<audio id="notificationSound" src="sound/notification.mp3" preload="auto" loop></audio>
<script src="js/notification.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<!-- End -->

</html>