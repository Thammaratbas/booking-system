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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="CSS/nav.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="stylesheet" href="./fullcalendar/lib/main.min.css">
    <link rel="stylesheet" href="CSS/user_room.css">

    <style>
        :root {
            --bs-success-rgb: 71, 222, 152 !important;
        }

        html,
        body {
            min-height: 75rem;
            padding-top: 4.5rem;
        }

        .btn-info.text-light:hover,
        .btn-info.text-light:focus {
            background: #000;
        }

        table,
        tbody,
        td,
        tfoot,
        th,
        thead,
        tr {
            border-color: #ededed !important;
            border-style: solid;
            border-width: 1px !important;
        }
    </style>

    <title>Document</title>
</head>

<body class="bg-light">
    <?php require_once('nav_user.php') ?>
    <?php
    require_once "db.php";

    $db = new Database();

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $room = $db->readOneRoom($id);
        $user = $db->getUser($_SESSION['userId']);
    } else {
        echo "Room ID not provided.";
    }
    ?>

    <div class="container py-5" id="page-container">
        <div class="row">
            <div class="col-md-9">
                <div id="calendar"></div>
            </div>
            <div class="col-md-3">
                <div class="cardt rounded-0 shadow">
                    <div class="card-header bg-gradient bg-primary text-light">
                        <h5 class="card-title custom-card-title">Booking Form</h5>
                    </div>
                    <div class="card-body">
                        <div class="container-fluid">
                            <form action="wait_save_schedule.php" method="post" id="schedule-form">
                                <input type="hidden" name="id" value="">
                                <input type="hidden" name="room_id" value="<?= $room['id'] ?>">
                                <input type="hidden" name="room_name" value="<?= $room['room_name'] ?>">
                                <div class="form-group mb-2">
                                    <label for="first_name" class="control-label">First Name</label>
                                    <input type="text" class="form-control form-control-sm rounded-0" name="first_name" id="first_name" placeholder="กรุณากรอกชื่อ" value="<?= $user['firstname'] ?>" required readonly>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="last_name" class="control-label">Last Name</label>
                                    <input type="text" class="form-control form-control-sm rounded-0" name="last_name" id="last_name" placeholder="กรุณากรอกนามสกุล" value="<?= $user['lastname'] ?>" required readonly>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="email" class="control-label">Email</label>
                                    <input type="email" class="form-control form-control-sm rounded-0" name="email" id="email" placeholder="กรุณากรอกชื่อ Email" value="<?= $user['email'] ?>" required readonly>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="start_datetime" class="control-label">Start</label>
                                    <input type="datetime-local" class="form-control form-control-sm rounded-0" name="start_datetime" id="start_datetime" required>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="end_datetime" class="control-label">End</label>
                                    <input type="datetime-local" class="form-control form-control-sm rounded-0" name="end_datetime" id="end_datetime" required>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="title" class="control-label">Title</label>
                                    <select class="form-control form-control-sm rounded-0" name="title" id="title" required onchange="showOtherTitle()">
                                        <option value="" disabled selected>เลือกประเภทการใช้ห้อง</option>
                                        <option value="สอบ">สอบ</option>
                                        <option value="สอนชดเชย">สอนชดเชย</option>
                                        <option value="อ่านหนังสือ">อ่านหนังสือ</option>
                                        <option value="อื่นๆ">อื่น ๆ</option>
                                    </select>
                                    <input type="text" class="form-control form-control-sm rounded-0 mt-2" name="other_title" id="other_title" placeholder="กรุณากรอกรายละเอียด" style="display: none;">
                                </div>
                                <div class="form-group mb-2">
                                    <label for="description" class="control-label">Description</label>
                                    <textarea rows="3" class="form-control form-control-sm rounded-0" name="description" id="description" placeholder="รายละเอียดเพิ่มเติมกรณีต้องการอะไรเพิ่ม" required></textarea>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="text-center">
                            <button class="btn custom-btn btn-sm rounded-0" type="submit" form="schedule-form" name="save"><i class="fa-solid fa-circle-check"></i> Book</button>
                            <button class="btn btn-danger btn-sm rounded-0" type="button" onclick="window.location.href='user.php'">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Event Details Modal -->
    <div class="modal fade" tabindex="-1" data-bs-backdrop="static" id="event-details-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-0">
                <div class="modal-header rounded-0">
                    <h5 class="modal-title">Schedule Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body rounded-0">
                    <div class="container-fluid">
                        <dl>
                            <dt class="text-muted">Title</dt>
                            <dd id="title" class="fw-bold fs-4"></dd>
                            <dt class="text-muted">Description</dt>
                            <dd id="description" class=""></dd>
                            <dt class="text-muted">Start</dt>
                            <dd id="start" class=""></dd>
                            <dt class="text-muted">End</dt>
                            <dd id="end" class=""></dd>
                        </dl>
                    </div>
                </div>
                <div class="modal-footer rounded-0">
                    <div class="text-end">
                        <button type="button" class="btn btn-secondary btn-sm rounded-0" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Event Details Modal -->

    <?php
    require_once "db.php";

    $db = new Database();

    $room_id = $room['id'];
    $schedules = $db->readSchedules($room_id);
    $sched_res = [];
    foreach ($schedules as $row) {
        $row['sdate'] = date("F d, Y h:i A", strtotime($row['start_datetime']));
        $row['edate'] = date("F d, Y h:i A", strtotime($row['end_datetime']));
        $sched_res[$row['id']] = $row;
    }
    ?>
    <?php
    if (isset($conn)) $conn->close();
    ?>

    <?php require_once('live_chat_user.php'); ?>

</body>
<!-- Script -->
<script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="./fullcalendar/lib/main.min.js"></script>
<script src="https://kit.fontawesome.com/9bdea71349.js" crossorigin="anonymous"></script>
<audio id="notificationSound" src="sound/notification.mp3" preload="auto" loop></audio>
<script src="js/notificationUser.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script>
    var scheds = $.parseJSON('<?= json_encode($sched_res) ?>')
</script>
<script src="./js/script.js"></script>
<script>
    function showOtherTitle() {
        var title = document.getElementById('title').value;
        var otherTitleInput = document.getElementById('other_title');
        if (title === 'อื่นๆ') {
            otherTitleInput.style.display = 'block';
            otherTitleInput.required = true;
        } else {
            otherTitleInput.style.display = 'none';
            otherTitleInput.required = false;
        }
    }
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#schedule-form').on('submit', function(e) {
            $.ajax({
                url: 'wait_save_schedule.php',
                data: $(this).serialize(),
                type: 'POST',
                success: function(response) {
                    var data = JSON.parse(response);
                    if (data.success) {
                        console.log(data);
                        swal("Success!", data.message, "success").
                        then(() => {
                            window.location.href = 'user.php';
                        });
                    } else {
                        console.log(data);
                        swal("Success!", data.message, "error").
                        then(() => {
                            location.reload();
                        });
                    }
                },
                error: function(data) {
                    swal("Oops...", "Something went wrong :(", "error");
                }
            });
            e.preventDefault();
        });
    });
</script>

<!-- End Script -->


</html>