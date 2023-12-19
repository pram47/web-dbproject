<?php
    session_start();
    require_once 'components/server.php';
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <link rel="stylesheet" href="css/testlogin.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <header>
    <!-- Nav Section Start -->
    <?php include 'components/header.php';?>
    <!-- Nav Section -->
    </header>
    <!-- Link Register -->

    <!-- <div class="login-register">
        <p>Don't have an account?</p>
        <a href="#" class="register-link">Register</a>
    </div> -->

    <!-- Link Register -->
    <div class="form" id="signupForm">
        <h2>Sign up</h2>
        <div class="form-box" >
                <form action="signup_db.php" method = "post">
                    <?php if(isset($_SESSION['error'])) {?>
                        <div class = "alert alert-danger" role = "alert">
                            <?php
                                echo $_SESSION['error'];
                                unset($_SESSION['error']);
                            ?>
                        </div>
                    <?php }?>


                    <?php if(isset($_SESSION['success'])) {?>
                        <div class = "alert alert-success" role = "alert">
                            <?php
                                
                                echo $_SESSION['success'];
                                unset($_SESSION['success']);
                            ?>
                        </div>
                    <?php }?>

                    <?php if(isset($_SESSION['warning'])) {?>
                        <div class = "alert alert-warning" role = "alert">
                            <?php
                                $_SESSION['alert_type'] = 'warning';
                                echo $_SESSION['warning'];
                                unset($_SESSION['warning']);
                            ?>
                        </div>
                    <?php }?>

                    <div class="input-box">
                        <span class="icon"><ion-icon aria-describedby="email"></ion-icon></span>
                        <input type="email"  name="email" required>
                        <label for="">Email</label>
                    </div>
                    <div class="input-box">
                        <span class="icon"><ion-icon aria-describedby="password"></ion-icon></span>
                        <input type="password" name="password" required>
                        <label for="">Password</label>
                    </div>
                    <div class="input-box">
                        <span class="icon"><ion-icon aria-describedby="username"></ion-icon></span>
                        <input type="text" name="username" required>
                        <label for="">Username</label>
                    </div>
                    <div class="input-box">
                        <span class="icon"><ion-icon  aria-describedby="date_of_birth"></ion-icon></span>
                        <input type="date" name="date_of_birth" required>
                        <label for="">Date of birth</label>
                    </div>
                    <button type="submit" name="signup" class="btnSignup">Sign up</button>
                    <p>already signup? click here to <a href="signin.php">sign in</a></p>

                </form>
        </div>
        \
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        var alertType = "<?php echo isset($_SESSION['alert_type']) ? $_SESSION['alert_type'] : ''; ?>";
        var form = document.getElementById('signupForm');

        // Apply different classes based on the alert type
        if (alertType) {
            form.classList.add(alertType);
        }
    });
    </script>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>