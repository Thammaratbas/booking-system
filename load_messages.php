<?php
// ตรวจสอบการเชื่อมต่อกับฐานข้อมูล
require_once 'db.php';
$database = new Database();

// ตรวจสอบค่า user_id ที่ส่งมาจาก AJAX request
if (isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];

    // ดึงข้อความทั้งหมดระหว่างผู้ใช้ที่เข้าสู่ระบบและผู้ใช้ที่ถูกเลือก
    $messages = $database->getAdminUserChat($_SESSION['userId'], $user_id);

    // แสดงข้อความในรูปแบบ HTML
    foreach ($messages as $message) {
        if ($message['sender_id'] == $_SESSION['userId']) {
            echo '<div class="text-end"><p>' . $message['message'] . '</p></div>';
        } else {
            echo '<div><p>' . $message['message'] . '</p></div>';
        }
    }
} else {
    // หากไม่มี user_id ส่งมาให้คืนค่าว่าง
    echo '';
}
?>
