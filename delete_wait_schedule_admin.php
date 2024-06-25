<?php 
session_start();
require_once "db.php";
include_once('alert.php');

$db = new Database();

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $db->readWaitOneSchedules($id);
    $email = $result['email'];
    
    $subject = 'Cancellation of Reservation';

    $mailContent = '
    <p>เรียนคุณ ' . $result['first_name'] . '</p>
    <p>ด้วยเหตุผลบางประการทางเราไม่สามารถให้คุณ ' . $result['first_name'] . ' จองห้องดังกล่าวได้ขออภัยมา ณ ที่นี้ หากมีข้อสงสัยหรือคำถามเพิ่มเติมกรุณาติดต่อเราทางอีเมลหรือโทรศัพท์ด้านล่างนี้</p>
    <br>
    <p>ข้อมูลการจอง :</p>
    <p>ห้อง: ' . $result['room_name'] . '</p>
    <p>ชื่อ: ' . $result['first_name'] . '</p>
    <p>นามสกุล: ' .$result['last_name'] . '</p>
    <p>อีเมล: ' . $result['email'] . '</p>
    <p>วันที่และเวลาที่จอง: ' . $result['start_datetime'] . ' ถึง ' . $result['end_datetime'] . '</p>
    <p>หัวข้อการจอง: ' . $result['title'] . '</p>
    <p>รายละเอียดเพิ่มเติม: ' . $result['description'] . '</p>
    <br>
    <p>อีเมล: ecs_booking@gmail.com</p>
    <p>ขอบคุณมากครับ/ค่ะ</p>
    <p>ECS Booking</p>
    ';

    $db->sendMail($email, $subject, $mailContent);
    $db->deleteWaitSchedules($id);
} else {
    echo '<div class="alert alert-danger" role="alert">Invalid request.</div>';
}
?>
