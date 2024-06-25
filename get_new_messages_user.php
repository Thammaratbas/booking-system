<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    require_once('config/config.php');

    // ตรวจสอบว่าผู้ใช้เข้าสู่ระบบหรือไม่
    if (!isset($_SESSION['userId'])) {
        exit(); // ถ้าไม่ได้เข้าสู่ระบบให้จบการทำงานทันที
    }

    // เรียกใช้งานไฟล์ฐานข้อมูล
    require_once 'db.php';
    $database = new Database();

    // ดึงข้อมูลผู้ใช้ทั้งหมดจากฐานข้อมูลที่มีสิทธิ์เป็นแอดมิน (userRank = 1)
    $admins = $database->getAdminUsers();

    // นับจำนวนข้อความใหม่ที่ยังไม่ได้อ่านทั้งหมด
    $newMessageCount = 0;
    foreach ($admins as $admin) {
        $newMessageCount += $database->countUnreadMessagesUser($_SESSION['userId'], $admin['id']);
    }

    // ส่งค่าจำนวนข้อความใหม่กลับไปยัง JavaScript
    echo $newMessageCount;
?>
