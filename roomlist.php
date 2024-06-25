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

    <!-- Add New Room Modal Start -->
    <div class="modal fade" tabindex="-1" id="addNewRoomModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <?php include_once('alert.php'); ?>
                    <h5 class="modal-header">Add New Room</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="action.php" method="POST" enctype="multipart/form-data">
                        <label for="rname">Room name</label>
                        <input type="text" name="rname" class="form-control my-2" placeholder="Room name">
                        <label for="type">Type</label>
                        <input type="text" name="type" class="form-control my-2" placeholder="Type">
                        <label for="cap">Capacity</label>
                        <input type="text" name="cap" class="form-control my-2" placeholder="Capacity">
                        <label for="port">Port</label>
                        <input type="text" name="port" class="form-control my-2" placeholder="Port">
                        <label for="etc">Details</label>
                        <input type="text" name="etc" class="form-control my-2" placeholder="Details">
                        <label for="upload">Upload image</label>
                        <input type="file" class="form-control my-2" name="image">
                        <div class="d-grid gap-2 col-6 mx-auto">
                            <button type="submit" class="btn btn-secondary btn-lg mt-5" name="addroom">Add Room</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Add New Room Modal End -->

    <div class="container">
        <div class="row mt-4">
            <div class="col-lg-12 d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="text-primary">All room in the database</h4>
                </div>
                <div>
                    <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#addNewRoomModal">Add Room</button>
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
                                <th style="width: 200px;">Room name</th>
                                <th>Type</th>
                                <th>Capacity</th>
                                <th>Port</th>
                                <th>Details</th>
                                <th>Image</th>
                                <th style="width: 150px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            require_once 'db.php';
                            $database = new Database();
                            $rooms = $database->readRoom();

                            if (empty($rooms)) {
                                echo "<tr><td colspan='8'>No Room In Database</td></tr>";
                            } else {
                                foreach ($rooms as $room) : ?>
                                    <tr>
                                        <td><?= $room['id'] ?></td>
                                        <td><?= $room['room_name'] ?></td>
                                        <td><?= $room['type'] ?></td>
                                        <td><?= $room['cap'] ?></td>
                                        <td><?= $room['port'] ?></td>
                                        <td><?= $room['etc'] ?></td>
                                        <td><img src="data:image/jpeg;base64,<?= base64_encode($room['image']) ?>" alt="Room Image" style="width: 50%;"></td>
                                        <td>
                                            <a href="edit_room.php?id=<?= $room['id'] ?>" class="btn btn-success btn-sm rounded-pull py-0" name="edit">Edit</a>
                                            <a href="delete_room.php?id=<?= $room['id'] ?>" class="btn btn-danger btn-sm rounded-pull py-0" name="delete">Delete</a>
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

    <?php require_once('live_chat_admin.php'); ?>

    <!-- Script -->
    <audio id="notificationSound" src="sound/notification.mp3" preload="auto" loop></audio>
    <script src="js/notification.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <!-- End -->
</body>

</html>