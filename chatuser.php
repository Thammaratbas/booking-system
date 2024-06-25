<?php
session_start();
require_once('config/config.php');

// ตรวจสอบว่าผู้ใช้เข้าสู่ระบบหรือไม่
if (!isset($_SESSION['userId'])) {
    header('Location: login.php');
}

// เรียกใช้งานไฟล์ฐานข้อมูล
require_once 'db.php';
$database = new Database();

// ตรวจสอบว่ามีการรับค่า user_id ผ่าน URL หรือไม่
if (!isset($_GET['user_id'])) {
    header('Location: chatlist.php');
}

$user_id = $_GET['user_id'];

// ตรวจสอบว่าผู้ใช้ที่เลือกอยู่ในฐานข้อมูลหรือไม่
$user = $database->getUserById($user_id);
if (!$user) {
    header('Location: chatlist.php');
}

// ดึงข้อมูลผู้ใช้ที่เลือกจากฐานข้อมูล
$user_info = $database->getUserById($user_id);

// ดึงข้อความระหว่างแอดมินกับผู้ใช้ที่เลือก
$messages = $database->getAdminUserChat($_SESSION['userId'], $user_id);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat with <?= $user_info['firstname'] . ' ' . $user_info['lastname'] ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="CSS/chat.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="CSS/nav.css">
</head>

<body>

    <?php require_once('nav_user.php'); ?>
    <?php require_once('alert.php');?>

        <div class="wrapper">
            <section class="chat-area">
                <header>
                    <h2><?= $user_info['firstname'] . ' ' . $user_info['lastname'] ?></h2>
                    <a href="chatadmin.php" class="btn btn-primary">Back to Chat List</a>
                </header>
                    <div class="chat-box" id="chat-container">
                    <!-- เรียกใช้งานฟังก์ชัน loadNewMessages เมื่อหน้าเว็บโหลดเสร็จ -->
                    <?php foreach ($messages as $message) : ?>
                        <?php if ($message['sender_id'] == $_SESSION['userId']) : ?>
                            <!-- ข้อความจากผู้ใช้ปัจจุบัน -->
                            <div class="text-end">
                                <p><?= $message['message'] ?></p>
                            </div>
                        <?php else : ?>
                            <!-- ข้อความจากผู้ใช้ที่ถูกเลือก -->
                            <div>
                                <p><?= $message['message'] ?></p>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    </div>

                    <form action="#" id="message-form" class="typing-area">
                        <div class="input-group mb-3">
                            <input type="text" id="message-input" class="input-field" placeholder="Type a message here..." autocomplete="off">
                            <button type="submit" class="btn btn-primary"><i>Send</i></button>
                        </div>
                    </form>

            </section>
        </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script>
        function loadNewMessages() {
            $.ajax({
                url: 'load_messages.php',
                type: 'POST',
                data: {
                    user_id: <?= $user_id ?>
                },
                success: function(response) {
                    $('#chat-container').empty();
                    $('#chat-container').append(response);
                    $('#chat-container').scrollTop($('#chat-container')[0].scrollHeight);
                },
                error: function(xhr, status, error) {
                    console.error('Error loading messages:', error);
                }
            });
        }

        $(document).ready(function() {
            loadNewMessages();

            $('#message-form').submit(function(e) {
                e.preventDefault();
                var message = $('#message-input').val();
                $.ajax({
                    url: 'send_message.php',
                    type: 'POST',
                    data: {
                        receiver_id: <?= $user_id ?>,
                        message: message
                    },
                    success: function(response) {
                        $('#message-input').val('');
                        loadNewMessages();
                    },
                    error: function(xhr, status, error) {
                        console.error('Error sending message:', error);
                    }
                });
            });

            setInterval(loadNewMessages, 1000);
        });

    </script>

    <!-- Script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <!-- End -->
    
</body>

</html>

