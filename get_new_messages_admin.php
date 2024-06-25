<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    require_once('config/config.php');

    // เรียกใช้งานไฟล์ฐานข้อมูล
    require_once 'db.php';
    $database = new Database();

    // ตรวจสอบว่าผู้ใช้เป็นแอดมินหรือไม่
    if ($_SESSION['userRank'] !== 1) {
        // ถ้าไม่ใช่แอดมิน ไม่ต้องทำอะไรเพิ่มเติม
        exit();
    }

    // ดึงข้อมูลผู้ใช้ทั้งหมดจากฐานข้อมูล
    $users = $database->getAllUsers();

    // นับจำนวนข้อความใหม่ที่ยังไม่ได้อ่านทั้งหมด
    $newMessageCount = 0;
    foreach ($users as $user) {
        $newMessageCount += $database->countUnreadMessagesAdmin($_SESSION['userId'], $user['id']);
    }

    // ส่งค่าจำนวนข้อความใหม่กลับไปยัง JavaScript
    echo $newMessageCount;
?>
