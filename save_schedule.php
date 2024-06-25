<?php 
session_start();
require_once "db.php";
include_once('alert.php');

$db = new Database();


if (isset($_POST['save'])) {
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
    $db->save_schedule($user_id, $room_id, $room_name, $first_name, $last_name, $email, $start_datetime, $end_datetime, $title, $description);
}