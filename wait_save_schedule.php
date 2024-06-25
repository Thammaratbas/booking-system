<?php
session_start();
require_once "db.php";
include_once('alert.php');

$db = new Database();

$user = $db->getUser($_SESSION['userId']);
$user_id = $user['id'];
$room_id = $_POST['room_id'];
$room_name = $_POST['room_name'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$start_datetime = $_POST['start_datetime'];
$end_datetime = $_POST['end_datetime'];
$title = $_POST['title'];
$description = $_POST['description'];

$subject = 'Your Room Reservation Has Been Successfully Recorded for Verification';

$mailContent = '
    <p>เรียนคุณ ' . $_POST['first_name'] . '</p>
    <p>ขอบคุณที่ได้ทำการจองห้องกับเรา ทางทีมของเราได้รับข้อมูลการจองของท่านแล้วและกำลังดำเนินการตรวจสอบ</p>
    <p>โปรดรอการยืนยันจากทางเราอีกครั้ง หากมีข้อสงสัยหรือคำถามเพิ่มเติมกรุณาติดต่อเราทางอีเมลหรือโทรศัพท์ด้านล่างนี้</p>
    <p>ข้อมูลการจอง :</p>
    <p>ห้อง: ' . $_POST['room_name'] . '</p>
    <p>ชื่อ: ' . $_POST['first_name'] . '</p>
    <p>นามสกุล: ' . $_POST['last_name'] . '</p>
    <p>อีเมล: ' . $_POST['email'] . '</p>
    <p>วันที่และเวลาที่จอง: ' . $_POST['start_datetime'] . ' ถึง ' . $_POST['end_datetime'] . '</p>
    <p>หัวข้อการจอง: ' . $_POST['title'] . '</p>
    <p>รายละเอียดเพิ่มเติม: ' . $_POST['description'] . '</p>
    <br>
    <p>อีเมล: ecs_booking@gmail.com</p>
    <p>ขอบคุณมากครับ/ค่ะ</p>
    <p>ECS Booking</p>
    ';

$response = $db->wait_save_schedule($user_id, $room_id, $room_name, $first_name, $last_name, $email, $start_datetime, $end_datetime, $title, $description, $subject, $mailContent);
echo json_encode($response);
