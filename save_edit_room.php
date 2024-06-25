<?php
require_once "db.php";

$db = new Database();

if (isset($_POST['update_room'])) {

    $id = $_POST['id'];
    $rname = $_POST['room_name'];
    $type = $_POST['type'];
    $cap = $_POST['cap'];
    $port = $_POST['port'];
    $etc = $_POST['etc'];

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = $_FILES["image"]["tmp_name"];
        $imgContent = file_get_contents($image);

        $db->updateRoom($id, $rname, $type, $cap, $port, $etc, $imgContent);
    } else {
        $db->updateRoomNoImage($id, $rname, $type, $cap, $port, $etc);
    }
}
