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

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="CSS/nav.css">
    <link rel="stylesheet" href="CSS/button.css">
    <style>
        body {
            min-height: 75rem;
            padding-top: 4.5rem;
        }
    </style>

    <title>User</title>
</head>

<body>
    <?php require_once('nav.php'); ?>
    <?php require_once('alert.php'); ?>

    <div class="container mt-5">
        <div class="row">
            <?php
            require_once 'db.php';
            $database = new Database();
            $rooms = $database->readRoom();
            foreach ($rooms as $room) : ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="data:image/jpeg;base64,<?= base64_encode($room['image']) ?>" class="card-img-top" alt="Room Image">
                        <div class="card-body">
                            <h5 class="card-title"><?= $room['room_name'] ?></h5>
                            <p class="card-text">Type: <?= $room['type'] ?></p>
                            <p class="card-text">Capacity: <?= $room['cap'] ?></p>
                            <a href="room_details_admin.php?id=<?= $room['id'] ?>" class="btn btn-primary">View Details</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <?php require_once('live_chat_admin.php'); ?>
    
    <!-- Script -->
    <audio id="notificationSound" src="sound/notification.mp3" preload="auto" loop></audio>
    <script src="js/notification.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <!-- End -->

</body>

</html>