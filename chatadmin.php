<?php
session_start();
require_once('config/config.php');

// ตรวจสอบว่าผู้ใช้เข้าสู่ระบบหรือไม่
if (!isset($_SESSION['userId'])) {
    header('Location: login.php');
}

// ตรวจสอบว่าผู้ใช้เป็นแอดมินหรือไม่
if ($_SESSION['userRank'] !== 0) {
    header('Location: user.php');
}

// เรียกใช้งานไฟล์ฐานข้อมูล
require_once 'db.php';
$database = new Database();

// ดึงข้อมูลผู้ใช้ทั้งหมดจากฐานข้อมูลที่มีสิทธิ์เป็นแอดมิน (userRank = 1)
$admins = $database->getAdminUsers();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat List</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
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
    <?php require_once('alert.php');?>

    <div class="container mt-5">
        <h2>Chat List</h2>
        <a href="user.php" class="btn btn-secondary mb-3">Back to User Page</a>
        <table class="table">
            <thead>
                <tr>
                    <th>Email</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Messages</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($admins as $admin) : ?>
                    <tr>
                        <td><?= $admin['email'] ?></td>
                        <td><?= $admin['firstname'] ?></td>
                        <td><?= $admin['lastname'] ?></td>
                        <td>
                            <?php
                                // เช็คว่ามีข้อความใหม่หรือไม่
                                $unreadMessages = $database->countUnreadMessagesUser($_SESSION['userId'], $admin['id']);
                                
                                // แสดงเครื่องหมายเตือนหรือจุดถ้ามีข้อความใหม่
                                if ($unreadMessages > 0) {
                                    echo '<span class="badge bg-danger">New</span>';
                                }
                            ?>
                        </td>
                        <td>
                            <a href="chatuser.php?user_id=<?= $admin['id'] ?>" class="btn btn-primary" onclick="markAsRead(<?= $_SESSION['userId'] ?>, <?= $admin['id'] ?>)">Chat</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Script -->
    <script>
        function markAsRead(receiverId, senderId) {
            // ส่ง request ไปยังไฟล์ PHP โดยใช้ AJAX
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // สามารถทำอะไรกับข้อมูลที่ได้จากการ request ได้ตามต้องการ
                    // ในที่นี้ไม่ต้องการการตอบกลับจากไฟล์ PHP ดังนั้นไม่จำเป็นต้องทำอะไรเพิ่มเติม
                }
            };
            xhttp.open("GET", "mark_as_read_user.php?receiver_id=" + receiverId + "&sender_id=" + senderId, true);
            xhttp.send();
        }
    </script>
    <audio id="notificationSound" src="sound/notification.mp3" preload="auto" loop></audio>
    <script src="js/notification.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <!-- End -->

</body>

</html>
