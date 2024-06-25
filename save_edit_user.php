<?php
require_once "db.php";

$db = new Database();

if (isset($_POST['update_user'])) {
    $id = $_POST['id'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $phone = $_POST['phone'];
    $pid = $_POST['pid'];
    $email = $_POST['email'];
    $rank = $_POST['rank'];
    $db->update($id, $fname, $lname, $phone , $pid, $email, $rank);
}