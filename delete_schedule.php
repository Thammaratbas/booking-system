<?php 
session_start();
require_once "db.php";
include_once('alert.php');

$db = new Database();

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $db->deleteSchedule($id);
} else {
    echo '<div class="alert alert-danger" role="alert">Invalid request.</div>';
}
?>
