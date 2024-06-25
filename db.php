<?php

require 'autoload.php';
require_once 'config/config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

class Database extends Config
{

    // Start Login System
    public function loginUser($email, $password)
    {
        if (empty($email) && empty($password)) {
            $_SESSION['error'] = "Please fill in the form.";
            header("Location: login.php");
            return;
        }

        try {
            $sql = "SELECT * FROM users WHERE email = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$email]);

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                if ($user['rank'] === 0) {
                    $_SESSION['success'] = "Login successful";
                    $_SESSION['userId'] = $user['id'];
                    $_SESSION['userRank'] = $user['rank'];
                    header("location: user.php");
                } else {
                    $_SESSION['success'] = "Login successful";
                    $_SESSION['userId'] = $user['id'];
                    $_SESSION['userRank'] = $user['rank'];
                    header("location: admin.php");
                }
            } else {
                $_SESSION['error'] = "Invaild email or password";
                header("location: login.php");
            }
        } catch (PDOException $e) {
            $_SESSION['error'] = "Something went wrong, please try again.";
            header("location: login.php");
            echo "Error: " . $e->getMessage();
        }
    }

    public function regUser($fname, $lname, $phone, $pid, $email, $password, $c_password, $rank)
    {
        $checkUser = $this->conn->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
        $checkUser->execute([$email]);

        if (empty($fname) || empty($lname) || empty($phone) || empty($pid) || empty($email) || empty($password) || empty($c_password)) {
            $_SESSION['error'] = "Please fill in the form.";
            header("location: register.php");
            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = "Invalid email format.";
            header("location: register.php");
            return;
        }

        if ($checkUser->fetchColumn() > 0) {
            $_SESSION['error'] = "This email is already taken.";
            header("location: register.php");
            return;
        }

        if ($password == $c_password) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            try {
                $sql = "INSERT INTO users(firstname, lastname, phone, personnelid, email, password, rank) VALUES(?, ?, ?, ?, ?, ?, ?)";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([$fname, $lname, $phone, $pid, $email, $hashedPassword, $rank]);

                if ($stmt) {
                    $_SESSION['success'] = "Registration successfully";
                    header("location: login.php");
                } else {
                    $_SESSION['error'] = "Something went wrong, please try again.";
                    header("location: register.php");
                }
            } catch (PDOException $e) {
                $_SESSION['error'] = "Something went wrong, please try again.";
                header("location: register.php");
                echo "Error: " . $e->getMessage();
            }
        } else {
            $_SESSION['error'] = "Password do not match, please try again.";
            header("location: register.php");
        }
    }

    public function getUser($userId)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = ?");
            $stmt->execute([$userId]);

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                return $user;
            } else {
                echo "User not found.";
                return null;
            }
        } catch (PDOException $e) {
            $_SESSION['error'] = "Something went wrong, please try again.";
            echo "Error: " . $e->getMessage();
            header("Location: user.php");
        }
    }

    public function loginNoPass($email)
    {
        if (empty($email)) {
            $_SESSION['error'] = "No Email.";
            header("Location: login.php");
            return;
        }

        try {
            $sql = "SELECT * FROM users WHERE email = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$email]);

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                if ($user['rank'] === 0) {
                    $_SESSION['success'] = "Login successful";
                    $_SESSION['userId'] = $user['id'];
                    $_SESSION['userRank'] = $user['rank'];
                    header("location: user.php");
                } else {
                    $_SESSION['success'] = "Login successful";
                    $_SESSION['userId'] = $user['id'];
                    $_SESSION['userRank'] = $user['rank'];
                    header("location: admin.php");
                }
            } else {
                $_SESSION['error'] = "There is no user in the database.";
                header("location: login.php");
            }
        } catch (PDOException $e) {
            $_SESSION['error'] = "Something went wrong, please try again.";
            header("location: login.php");
            echo "Error: " . $e->getMessage();
        }
    }


    public function read()
    {
        $sql = "SELECT * FROM users ORDER BY id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function readOne($id)
    {
        $sql = "SELECT * FROM users WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function update($id, $fname, $lname, $phone, $pid, $email, $rank)
    {
        try {
            $sql = "UPDATE users SET firstname = ?, lastname = ?, phone = ?, personnelid = ?, email = ?, rank = ? WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$fname, $lname, $phone, $pid, $email, $rank, $id]);

            if ($stmt) {
                $_SESSION['success'] = "Update successfully";
                header("location: userlist.php");
            } else {
                $_SESSION['error'] = "Something went wrong, please try again.";
                header("location: userlist.php");
            }
        } catch (PDOException $e) {
            $_SESSION['error'] = "Something went wrong, please try again.";
            header("location: userlist.php");
            echo "Error: " . $e->getMessage();
        }
    }

    public function delete($id)
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM users WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            if ($stmt) {
                $_SESSION['success'] = "Delete User successfully";
                header("location: userlist.php");
            } else {
                $_SESSION['error'] = "Something went wrong, please try again.";
                header("location: userlist.php");
            }
        } catch (PDOException $e) {
            $_SESSION['error'] = "An error occurred while deleting the user.";
            header("Location: userlist.php");
            exit;
        }
    }

    public function deleteUserMessage($id)
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM messages WHERE sender_id = :sender_id OR receiver_id = :receiver_id");
            $stmt->bindParam(':sender_id', $id);
            $stmt->bindParam(':receiver_id', $id);
            $stmt->execute();
            return;
        } catch (PDOException $e) {
            $_SESSION['error'] = "An error occurred while deleting the user.";
            header("Location: userlist.php");
            exit;
        }
    }

    // End Login System

    // Start Add Room

    public function addRoom($rname, $type, $cap, $port, $etc, $imgContent)
    {
        try {
            $sql = "INSERT INTO room(room_name, type, cap, port, etc, image) VALUES(?, ?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$rname, $type, $cap, $port, $etc, $imgContent]);

            if ($stmt) {
                $_SESSION['success'] = "Add room successfully";
                header("location: roomlist.php");
            } else {
                $_SESSION['error'] = "Something went wrong, please try again.";
                header("location: roomlist.php");
            }
        } catch (PDOException $e) {
            $_SESSION['error'] = "Something went wrong, please try again.";
            header("location: roomlist.php");
            echo "Error: " . $e->getMessage();
        }
    }

    public function readRoom()
    {
        $sql = "SELECT * FROM room ORDER BY id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function readOneRoom($id)
    {
        try {
            $sql = "SELECT * FROM room WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$id]);

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                return $result;
            } else {
                echo "Room not found.";
                return null;
            }
        } catch (PDOException $e) {
            $_SESSION['error'] = "Something went wrong, please try again.";
            header("location: user.php");
            echo "Error: " . $e->getMessage();
        }
    }

    public function updateRoomNoImage($id, $rname, $type, $cap, $port, $etc)
    {
        try {
            $sql = "UPDATE room SET room_name = ?, type = ?, cap = ?, port = ?, etc = ? WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$rname, $type, $cap, $port, $etc, $id]);

            if ($stmt) {
                $_SESSION['success'] = "Update successfully";
                header("location: roomlist.php");
            } else {
                $_SESSION['error'] = "Something went wrong, please try again.";
                header("location: roomlist.php");
            }
        } catch (PDOException $e) {
            $_SESSION['error'] = "Something went wrong, please try again.";
            header("location: roomlist.php");
            echo "Error: " . $e->getMessage();
        }
    }

    public function updateRoom($id, $rname, $type, $cap, $port, $etc, $imgContent)
    {
        try {
            $sql = "UPDATE room SET room_name = ?, type = ?, cap = ?, port = ?, etc = ?, image = ? WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $rname);
            $stmt->bindParam(2, $type);
            $stmt->bindParam(3, $cap);
            $stmt->bindParam(4, $port);
            $stmt->bindParam(5, $etc);
            $stmt->bindParam(6, $imgContent, PDO::PARAM_LOB);
            $stmt->bindParam(7, $id);
            $stmt->execute();

            if ($stmt) {
                $_SESSION['success'] = "Room updated successfully";
                header("location: roomlist.php");
            } else {
                $_SESSION['error'] = "Something went wrong, please try again.";
                header("location: roomlist.php");
            }
        } catch (PDOException $e) {
            $_SESSION['error'] = "Something went wrong, please try again.";
            header("location: roomlist.php");
            echo "Error: " . $e->getMessage();
        }
    }

    public function deleteRoom($id)
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM room WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            if ($stmt) {
                $_SESSION['success'] = "Delete Room successfully";
                header("location: roomlist.php");
            } else {
                $_SESSION['error'] = "Something went wrong, please try again.";
                header("location: roomlist.php");
            }
        } catch (PDOException $e) {
            $_SESSION['error'] = "An error occurred while deleting the schedule.";
            header("Location: roomlist.php");
            exit;
        }
    }

    // End Add Room

    // Start Booking Schedule

    public function readSchedules($room_id)
    {
        $sql = "SELECT * FROM `schedule_list` WHERE `room_id` = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$room_id]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function readAllSchedules()
    {
        $sql = "SELECT * FROM schedule_list ORDER BY id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function readOneSchedules($id)
    {
        try {
            $sql = "SELECT * FROM schedule_list WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$id]);

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                return $result;
            } else {
                echo "Schedule not found.";
                return null;
            }
        } catch (PDOException $e) {
            $_SESSION['error'] = "Something went wrong, please try again.";
            header("location: admin.php");
            echo "Error: " . $e->getMessage();
        }
    }

    public function save_schedule($user_id, $room_id, $room_name, $first_name, $last_name, $email, $start_datetime, $end_datetime, $title, $description)
    {
        $checkSchedule = $this->conn->prepare("SELECT COUNT(*) FROM schedule_list WHERE room_id = ? AND ((start_datetime <= ? AND end_datetime >= ?) OR (start_datetime <= ? AND end_datetime >= ?))");
        $checkSchedule->execute([$room_id, $start_datetime, $start_datetime, $end_datetime, $end_datetime]);
        if ($checkSchedule->fetchColumn() > 0) {
            $_SESSION['error'] = "This room is already booked for this time slot.";
            header("Location: admin.php");
            return;
        } else {
            try {
                $sql = "INSERT INTO schedule_list(user_id, room_id, room_name, first_name, last_name, email, start_datetime, end_datetime, title, description) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([$user_id, $room_id, $room_name, $first_name, $last_name, $email, $start_datetime, $end_datetime, $title, $description]);

                if ($stmt) {
                    $_SESSION['success'] = "Add schedule successfully";
                    header("location: admin.php");
                } else {
                    $_SESSION['error'] = "Something went wrong, please try again.";
                    header("location: admin.php");
                }
            } catch (PDOException $e) {
                $_SESSION['error'] = "Something went wrong, please try again.";
                header("location: admin.php");
                echo "Error: " . $e->getMessage();
            }
        }
    }

    public function updateSchedule($id, $first_name, $last_name, $email, $start_datetime, $end_datetime, $title, $description)
    {
        try {
            $sql = "UPDATE schedule_list SET first_name = ?, last_name = ?, email = ?, start_datetime = ?, end_datetime = ?, title = ?, description = ? WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$first_name, $last_name, $email, $start_datetime, $end_datetime, $title, $description, $id]);

            if ($stmt) {
                $_SESSION['success'] = "Update schedule successfully";
                header("location: history_admin.php");
            } else {
                $_SESSION['error'] = "Something went wrong, please try again.";
                header("location: history_admin.php");
            }
        } catch (PDOException $e) {
            $_SESSION['error'] = "Something went wrong, please try again.";
            header("location: history_admin.php");
            echo "Error: " . $e->getMessage();
        }
    }

    public function deleteSchedule($id)
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM schedule_list WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            if ($stmt) {
                $_SESSION['success'] = "Delete schedule successfully";
                header("location: history_admin.php");
            } else {
                $_SESSION['error'] = "Something went wrong, please try again.";
                header("location: history_admin.php");
            }
        } catch (PDOException $e) {
            $_SESSION['error'] = "An error occurred while deleting the schedule.";
            header("Location: history_admin.php");
            exit;
        }
    }

    public function readUserSchedules($user_id)
    {
        $sql = "SELECT * FROM `schedule_list` WHERE `user_id` = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$user_id]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }


    // End Booking Schedule

    // Start Wait Schedule

    public function wait_save_schedule($user_id, $room_id, $room_name, $first_name, $last_name, $email, $start_datetime, $end_datetime, $title, $description, $subject, $mailContent) {
        $current_datetime = date('Y-m-d H:i:s');
        $response = ['success' => false, 'message' => ''];

        if ($start_datetime <= $current_datetime) {
            $response['message'] = "You cannot book a room for a past date and time.";
            return $response;
        }

        if ($start_datetime >= $end_datetime) {
            $response['message'] = "The start date and time must be before the end date and time.";
            return $response;
        }

        $checkSchedule = $this->conn->prepare("SELECT COUNT(*) FROM schedule_list WHERE room_id = ? AND ((start_datetime <= ? AND end_datetime >= ?) OR (start_datetime <= ? AND end_datetime >= ?))");
        $checkSchedule->execute([$room_id, $start_datetime, $start_datetime, $end_datetime, $end_datetime]);

        if ($checkSchedule->fetchColumn() > 0) {
            $response['message'] = "This room is already booked for this time slot.";
            return $response;
        }

        try {
            $sql = "INSERT INTO wait_schedule_list(user_id, room_id, room_name, first_name, last_name, email, start_datetime, end_datetime, title, description) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$user_id, $room_id, $room_name, $first_name, $last_name, $email, $start_datetime, $end_datetime, $title, $description]);

            if ($stmt) {
                $this->sendMail($email, $subject, $mailContent);
                $response['success'] = true;
                $response['message'] = "Add schedule successfully";
                return $response;
            } else {
                $response['message'] = "Something went wrong, please try again.";
                return $response;
            }
        } catch (PDOException $e) {
            $response['message'] = "Something went wrong, please try again.";
            $response['error'] = $e->getMessage();
            return $response;
        }
    }

    public function readWaitSchedules()
    {
        $sql = "SELECT * FROM wait_schedule_list ORDER BY id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }


    public function readWaitOneSchedules($id)
    {
        $sql = "SELECT * FROM wait_schedule_list WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function deleteWaitSchedules($id)
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM wait_schedule_list WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            if ($stmt) {
                $_SESSION['success'] = "Delete schedule successfully";
                header("location: confirm_room_admin.php");
            } else {
                $_SESSION['error'] = "Something went wrong, please try again.";
                header("location: confirm_room_admin.php");
            }
        } catch (PDOException $e) {
            $_SESSION['error'] = "An error occurred while deleting the schedule.";
            header("Location: confirm_room_admin.php");
            exit;
        }
    }

    public function save_confirm_schedule($user_id, $room_id, $room_name, $first_name, $last_name, $email, $start_datetime, $end_datetime, $title, $description)
    {
        try {
            $sql = "INSERT INTO schedule_list(user_id, room_id, room_name, first_name, last_name, email, start_datetime, end_datetime, title, description) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$user_id, $room_id, $room_name, $first_name, $last_name, $email, $start_datetime, $end_datetime, $title, $description]);

            if ($stmt) {
                $_SESSION['success'] = "Confirm schedule successfully";
                header("location: confirm_room_admin.php");
            } else {
                $_SESSION['error'] = "Something went wrong, please try again.";
                header("location: confirm_room_admin.php");
            }
        } catch (PDOException $e) {
            $_SESSION['error'] = "Something went wrong, please try again.";
            header("location: confirm_room_admin.php");
            echo "Error: " . $e->getMessage();
        }
    }

    public function readUserWaitSchedules($user_id)
    {
        $sql = "SELECT * FROM `wait_schedule_list` WHERE `user_id` = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$user_id]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    // End Wait Schedule

    // Start Live Chat

    public function getAllUsers()
    {
        $stmt = $this->conn->prepare("SELECT id, firstname, lastname, email FROM users WHERE rank = 0");
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $users;
    }

    public function getAdminUsers()
    {
        $stmt = $this->conn->prepare("SELECT id, firstname, lastname, email FROM users WHERE rank = 1");
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $users;
    }

    public function getUserById($userId)
    {
        $sql = "SELECT * FROM users WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAdminUserChat($adminId, $userId)
    {
        $sql = "SELECT * FROM messages WHERE (sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?) ORDER BY id ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $adminId, PDO::PARAM_INT);
        $stmt->bindParam(2, $userId, PDO::PARAM_INT);
        $stmt->bindParam(3, $userId, PDO::PARAM_INT);
        $stmt->bindParam(4, $adminId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function saveMessage($sender_id, $receiver_id, $message)
    {
        // ในที่นี้คุณต้องเขียนคำสั่ง SQL INSERT เพื่อเพิ่มข้อความลงในฐานข้อมูล
        $sql = "INSERT INTO messages (sender_id, receiver_id, message) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $sender_id, PDO::PARAM_INT);
        $stmt->bindParam(2, $receiver_id, PDO::PARAM_INT);
        $stmt->bindParam(3, $message, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function getMessagesByUserId($user_id)
    {
        $sql = "SELECT * FROM messages WHERE sender_id = ? OR receiver_id = ? ORDER BY id DESC LIMIT 0";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$user_id, $user_id]);
        $latestMessages = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $latestMessages;
    }

    public function createMessage($sender_id, $receiver_id, $message)
    {
        $sql = "INSERT INTO messages (sender_id, receiver_id, message) VALUES (:sender_id, :receiver_id, :message)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':sender_id', $sender_id);
        $stmt->bindParam(':receiver_id', $receiver_id);
        $stmt->bindParam(':message', $message);
        return $stmt->execute();
    }

    // End Live Chat

    // แจ้งเตือน Live Chat Start

    public function markMessagesAsReadUser($receiverId, $senderId)
    {
        $sql = "UPDATE messages SET user_read = 1 WHERE receiver_id = ? AND sender_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$receiverId, $senderId]);
    }

    public function markMessagesAsReadAdmin($receiverId, $senderId)
    {
        $sql = "UPDATE messages SET admin_read = 1 WHERE receiver_id = ? AND sender_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$receiverId, $senderId]);
    }

    public function countUnreadMessagesUser($userId, $adminId)
    {
        $sql = "SELECT COUNT(*) AS unread_messages FROM messages WHERE receiver_id = $userId AND sender_id = $adminId AND user_read = FALSE";
        $result = $this->conn->query($sql);
        if ($result && $result->rowCount() > 0) {
            $row = $result->fetch(PDO::FETCH_ASSOC);
            return $row['unread_messages'];
        } else {
            return 0;
        }
    }

    public function countUnreadMessagesAdmin($userId, $adminId)
    {
        $sql = "SELECT COUNT(*) AS unread_messages FROM messages WHERE receiver_id = $userId AND sender_id = $adminId AND admin_read = FALSE";
        $result = $this->conn->query($sql);
        if ($result && $result->rowCount() > 0) {
            $row = $result->fetch(PDO::FETCH_ASSOC);
            return $row['unread_messages'];
        } else {
            return 0;
        }
    }

    // แจ้งเตือน Live Chat End

    // Start Notification

    public function sendMail($email, $subject, $mailContent)
    {
        $mail = new PHPMailer(true);

        try {

            $mail->isSMTP();
            $mail->CharSet = 'UTF-8';
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'kanthammapitak_t@silpakorn.edu';
            $mail->Password   = 'mjxf rqtt iiaw vepe';
            $mail->SMTPSecure = 'PHPMailer::ENCRYPTION_STARTTLS';
            $mail->Port       = 587;

            //Recipients
            $mail->setFrom('kanthammapitak_t@silpakorn.edu', 'Ecs Booking');
            $mail->addAddress($email);
            $mail->addReplyTo('kanthammapitak_t@silpakorn.edu', 'Ecs Booking');

            //Content
            $mail->isHTML(true);
            $mail->Subject = $subject;

            $mail->Body = $mailContent;

            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            return true;
        } catch (Exception $e) {
            $_SESSION['error'] = "Message could not be sent.";
            header("location: admin.php");
            echo "Error: " . $e->getMessage();
        }
    }

    // End Notification

}
