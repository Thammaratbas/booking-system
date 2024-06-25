<?php
session_start();
require_once "db.php";
include_once('alert.php');

$db = new Database();


if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $db->readWaitOneSchedules($id);
    if ($result) {
        $user_id = $result['user_id'];
        $room_id = $result['room_id'];
        $room_name = $result['room_name'];
        $first_name = $result['first_name'];
        $last_name = $result['last_name'];
        $email = $result['email'];
        $start_datetime = $result['start_datetime'];
        $end_datetime = $result['end_datetime'];
        $title = $result['title'];
        $description = $result['description'];

        $subject = 'Confirmation of Classroom Booking';

        $mailContent = '
            <p>เรียนคุณ ' . $first_name . '</p>
            <p>ขอบคุณที่ได้ทำการจองห้องกับเรา ทางทีมของเราได้ตรวจสอบข้อมูลการจองของท่านเรียนร้อยแล้ว หากมีข้อสงสัยหรือคำถามเพิ่มเติมกรุณาติดต่อเราทางอีเมลหรือโทรศัพท์ด้านล่างนี้</p>
            <br>
            <p>ข้อมูลการจอง :</p>
            <p>ห้อง: ' . $room_name . '</p>
            <p>ชื่อ: ' . $first_name . '</p>
            <p>นามสกุล: ' . $last_name . '</p>
            <p>อีเมล: ' . $email . '</p>
            <p>วันที่และเวลาที่จอง: ' . $start_datetime . ' ถึง ' . $end_datetime . '</p>
            <p>หัวข้อการจอง: ' . $title . '</p>
            <p>รายละเอียดเพิ่มเติม: ' . $description . '</p>
            <br>
            <p>อีเมล: ecs_booking@gmail.com</p>
            <p>ขอบคุณมากครับ/ค่ะ</p>
            <p>ECS Booking</p>
            ';
            
        $db->sendMail($email, $subject, $mailContent);
        $db->save_confirm_schedule($user_id, $room_id, $room_name, $first_name, $last_name, $email, $start_datetime, $end_datetime, $title, $description);
        $db->deleteWaitSchedules($id);
    } else {
        echo "Error: No data found for the given ID.";
    }
}
