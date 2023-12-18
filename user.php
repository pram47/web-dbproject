<?php
require_once 'config/db.php';
session_start();
if (!isset($_SESSION['user_login'])) {
    header('location: signin.php');
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>User Page</title>
</head>
<body>
    <div class = "container">
        <?php
        if (isset($_SESSION['user_login'])){
            $user_id = $_SESSION['user_login'];
            $stmt = $conn->query("select * from users where id = $user_id");
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        ?>
        <h3 class = "mt-4">Welcome User , <?php echo $row['firstname']?></h3>
        <a href="logout.php" class ='btn btn-danger'> Logout</a>
        <a href="profile.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Profile</a>
        

        <!-- <a href = "profile.php=<?= $user['id']; ?>" class="btn btn-primary">Profile</a> -->
        <!-- <a href = "profile.php" class="btn btn-primary">Profile</a> -->
        

    </div>
    
</body>
</html>