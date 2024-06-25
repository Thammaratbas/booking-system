<?php

require_once 'db.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <?php
    $url_referrer = "http://localhost/ecs_booking/ECS-Booking/send_test.php";

    if (!isset($_SERVER['HTTP_REFERER']) || $_SERVER['HTTP_REFERER'] !== $url_referrer) {
        echo "Access denied.";
        exit;
    }

    if (isset($_GET['email'])) {
        $email = $_GET["email"];
        $db = new Database();
        $db->loginNoPass($email);
    } else {
        echo "No email received.";
    }
    ?>




</body>

</html>