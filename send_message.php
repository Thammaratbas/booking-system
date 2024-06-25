<?php
// ตรวจสอบการเชื่อมต่อกับฐานข้อมูล
require_once 'db.php';
$database = new Database();

// ตรวจสอบค่า receiver_id และ message ที่ส่งมาจาก AJAX request
if (isset($_POST['receiver_id']) && isset($_POST['message'])) {
    $receiver_id = $_POST['receiver_id'];
    $message = $_POST['message'];

    // สร้างข้อความใหม่ในฐานข้อมูล
    $database->createMessage($_SESSION['userId'], $receiver_id, $message);
} else {
    // หากข้อมูลไม่ครบถ้วนให้ส่งคำตอบว่างกลับ
    echo '';
}
?>
