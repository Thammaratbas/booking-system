<?php
require_once "db.php";

$db = new Database();

// Start Login System //

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $db->loginUser($email, $password);
}

if (isset($_POST['register'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $phone = $_POST['phone'];
    $pid = $_POST['pid'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $c_password = $_POST['c_password'];
    $rank = $_POST['rank'];

    $subject = 'Welcome to ECS Bookig';
    $mailContent = "<div style='text-align: center; font-size: 20px; font-weight: bold;'>Welcome to ECS Booking</div><br>";
    $mailContent .= "<div style='text-align: center;'>Use the following email to login:</div><br>";
    $mailContent .= "<div style='text-align: center;'>Email: $email</div><br>";
    $mailContent .= "<div style='text-align: center;'><a href='https://ecsbooking.com/welcome.php' style='font-size: 18px; text-decoration: none; background-color: #333; color: white; padding: 12px 20px; border: none; border-radius: 4px; cursor: pointer;'>Go to Welcome Page</a></div>";


    $db->sendMail($email, $subject, $mailContent);
    $db->regUser($fname, $lname, $phone, $pid, $email, $password, $c_password, $rank);
}

// End Login System //

// Start User List //

if (isset($_GET['read'])) {
    $users = $db->read();
    $output = '';
    if ($users) {
        foreach ($users as $row) {
            $output .= '<tr>
                    <td>' . $row['id'] . '</td>
                    <td>' . $row['firstname'] . '</td>
                    <td>' . $row['lastname'] . '</td>
                    <td>' . $row['phone'] . '</td>
                    <td>' . $row['personnelid'] . '</td>
                    <td>' . $row['email'] . '</td>
                    <td>' . $row['rank'] . '</td>
                    <td>
                        <a href="#" id="' . $row['id'] . '" class="btn btn-success btn-sm rounded-pull py-0 editlink" data-bs-toggle="modal" data-bs-target="#editUserModal">Edit</a>
                        <a href="#" id="' . $row['id'] . '" class="btn btn-danger btn-sm rounded-pull py-0 deletelink">Delete</a>
                    </td>
                </tr>';
        }
        echo $output;
    } else {
        echo '<tr>
                <td colspan="7">No users found in the Database</td>
            </tr>';
    }
}

if (isset($_GET['edit'])) {
    $id = $_GET['id'];
    $user = $db->readOne($id);
    echo json_encode($user);
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $phone = $_POST['phone'];
    $pid = $_POST['pid'];
    $email = $_POST['email'];
    $rank = $_POST['rank'];
    $db->update($id, $fname, $lname, $phone, $pid, $email, $rank);
}

if (isset($_GET['delete'])) {
    $id = $_GET['id'];
    $db->delete($id);
}

// End User List //

// Start Room List //

if (isset($_POST['addroom']) && isset($_FILES['image']) && $_FILES['image']['error'] == 0) {

    $image = $_FILES["image"]["tmp_name"];
    $imgContent = file_get_contents($image);

    $rname = $_POST['rname'];
    $type = $_POST['type'];
    $cap = $_POST['cap'];
    $port = $_POST['port'];
    $etc = $_POST['etc'];
    $db->addRoom($rname, $type, $cap, $port, $etc, $imgContent);
}

// End Room List //

// Start Notification //



// End Notification //