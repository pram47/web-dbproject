<?php
session_start();
require_once 'components/server.php';

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $deletestmt = $conn->query("DELETE FROM users WHERE id = $delete_id");
    $deletestmt->execute();

    if ($deletestmt) {
        echo "<script>alert('Data has been deleted successfully');</script>";
        // $_SESSION['success'] = "Data has been deleted succesfully";
        header("refresh:1; url=main.php");
    }
}

// if (isset($_GET['delete'])) {
//     $delete_id = $_GET['delete'];
//     $deletestmt = $conn->query("DELETE FROM users WHERE id = $delete_id");
//     $deletestmt->execute();

//     if ($deletestmt) {
//         echo "<script>alert('Data has been deleted successfully');</script>";
//         header("refresh:1; url=user.php");
//     }
// }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Upload Image System</title>
    <link rel="stylesheet" href="css/profile.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
</head>
<body>
    <header>
        <nav>
            <?php include 'components/userheader.php'; ?>
        </nav>
    </header>

    <?php
    if (isset($_SESSION['user_login'])) {
        $user_id = $_SESSION['user_login'];
        $stmt = $conn->query("select * from users where id = $user_id");
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    ?>

    <table class="table">
        <thead>
            <tr>
                <th scope="col" style="visibility: hidden;">#</th>
                <th scope="col">Username</th>
                <th scope="col">Email</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="row" style="visibility: hidden;"><?= $row['id']; ?></th>

                <td><?= $row['username']; ?></td>
                <td><?= $row['email']; ?></td>
                <td>
                    <a href="edit.php?id=<?= $row['id']; ?>" class="btn btn-primary">Edit</a>
                    <a href="?delete=<?= $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete?')">Delete</a>
                    <!-- <a href="profile.php?id=<?= $row['id']; ?>" class="btn btn-primary">Profile</a> -->
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>
