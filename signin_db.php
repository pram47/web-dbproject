<?php
    session_start();
    require_once 'components/server.php';

    if (isset($_POST['signin'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        if (empty($email)) {
            $_SESSION['error'] = 'please enter email';
            $_SESSION['alert_type'] = 'error';
            header("location: signin.php");
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'invalid email';
            $_SESSION['alert_type'] = 'error';
            header("location: signin.php");
        } else if (empty($password)) {
            $_SESSION['error'] = 'please enter password';
            $_SESSION['alert_type'] = 'error';
            header("location: signin.php");

        } else {
            try {
                $check_data = $conn->prepare("SELECT * FROM users where email = :email");
                $check_data->bindParam(":email", $email);
                $check_data->execute();
                $row = $check_data->fetch(PDO::FETCH_ASSOC);

                if ($check_data->rowCount() > 0) {
                    if ($email == $row['email']) {
                        if (password_verify($password, $row['password'])) {
                            $_SESSION['user_login'] = $row['id'];
                            header("Location:mainuser.php");
                        }else {
                            $_SESSION['error'] = 'wrong password';
                            header("Location:signin.php");
                        }
                    } else {
                        $_SESSION['error'] = 'wrong email';
                        header("Location:signin.php");
                    }
                } else {
                    $_SESSION['error'] = "There is no information in the system.";
                    header("Location:signin.php");
                }
                
                
            } catch(PDOException $e){
                echo $e->getMessage();
            }
        }
    }
?>