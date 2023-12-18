<?php
    session_start();
    require_once 'config/db.php';

    if (isset($_POST['signup'])) {
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $username = $_POST['username'];
        $date_of_birth = $_POST['date_of_birth'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        

        if (empty($firstname)) {
            $_SESSION['error'] = 'please enter name';
            $_SESSION['alert_type'] = 'error';
            header("location: log-sig.php");
        } else if (empty($lastname)) {
            $_SESSION['error'] = 'please enter lastname';
            $_SESSION['alert_type'] = 'error';
            header("location: log-sig.php");
        } else if (empty($username)) {
            $_SESSION['error'] = 'please enter username';
            $_SESSION['alert_type'] = 'error';
            header("location: log-sig.php");
        } else if (empty($email)) {
            $_SESSION['error'] = 'please enter email';
            $_SESSION['alert_type'] = 'error';
            header("location: log-sig.php");
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'invalid email';
            $_SESSION['alert_type'] = 'error';
            header("location: log-sig.php");
        } else if (empty($password)) {
            $_SESSION['error'] = 'please enter password';
            $_SESSION['alert_type'] = 'error';
            header("location: log-sig.php");
        } else if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5) {
            $_SESSION['error'] = 'password need to be 5 - 20 characters';
            $_SESSION['alert_type'] = 'error';
            header("location: log-sig.php");
        } else if (empty($date_of_birth)) {
            $_SESSION['error'] = 'please enter your birth date';
            $_SESSION['alert_type'] = 'error';
            header("location: log-sig.php");
        } else {
            try {
                $check_email = $conn->prepare("SELECT email FROM users where email = :email");
                $check_email->bindParam(":email", $email);
                $check_email->execute();
                $row = $check_email->fetch(PDO::FETCH_ASSOC);

                if ($row['email'] == $email) {
                    $_SESSION['warning'] = "This email already exists. <a href='signin.php'>Click here</a> to sign in";
                    $_SESSION['alert_type'] = 'warning';
                    header("location: log-sig.php");
                } else if (!isset($_SESSION['error'])) {
                    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $conn->prepare("INSERT INTO users (firstname, lastname, email, password, username, date_of_birth) VALUES (:firstname, :lastname, :email, :password, :username, :date_of_birth)");
                    $stmt->bindParam(":firstname", $firstname);
                    $stmt->bindParam(":lastname", $lastname);
                    $stmt->bindParam(":email", $email);
                    $stmt->bindParam(":password", $passwordHash);
                    $stmt->bindParam(":username", $username);
                    $stmt->bindParam(":date_of_birth", $date_of_birth); // Corrected binding here
                    $stmt->execute();
                    $_SESSION['success'] = "Signup success. <a href='signin.php' class='alert-link'>Click here</a> to sign in";
                    $_SESSION['alert_type'] = 'success';
                    header("location: log-sig.php");
                } else {
                    $_SESSION['error'] = "Something went wrong";
                    $_SESSION['alert_type'] = 'error';
                    header("location: log-sig.php");
                }
                
                
            } catch(PDOException $e){
                echo $e->getMessage();
            }
        }
    }
?>