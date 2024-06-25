<?php
session_start();
require_once 'config/config.php';
require_once 'db.php';

if (isset($_GET['receiver_id']) && isset($_GET['sender_id'])) {
    $receiverId = $_GET['receiver_id'];
    $senderId = $_GET['sender_id'];

    // เรียกใช้งานคลาส Database
    $database = new Database();

    // อัพเดตสถานะข้อความเป็น "อ่านแล้ว"
    $database->markMessagesAsReadUser($receiverId, $senderId);
}
