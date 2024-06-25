<?php
require_once "db.php";

$db = new Database();

if (isset($_POST['update_schedule'])) {
    $id = $_POST['id'];
    $first_name = $_POST['fname'];
    $last_name = $_POST['lname'];
    $email = $_POST['email'];
    $start_datetime = $_POST['sdate'];
    $end_datetime = $_POST['edate'];
    $title = $_POST['title'];
    $description = $_POST['etc'];
    $db->updateSchedule($id, $first_name, $last_name, $email, $start_datetime, $end_datetime, $title, $description);
}