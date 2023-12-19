<?php 

    session_start();
    
    require_once 'components/server.php';

    if (isset($_POST['update'])) {
        $id = $_POST['id'];
        $username = $_POST['username'];

        $sql = $conn->prepare("UPDATE users SET username = :username WHERE id = :id");
        $sql->bindParam(":id", $id);
        $sql->bindParam(":username", $username);
        $sql->execute();

        if ($sql) {
            $_SESSION['success'] = "Data has been updated successfully";
            header("location: profile.php");
        } else {
            $_SESSION['error'] = "Data has not been updated successfully";
            header("location: index.php");
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <style>
        .container {
            max-width: 550px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1>Edit Data</h1>
        <hr>
        <form action="edit.php" method="post" enctype="multipart/form-data">
            <?php
                if (isset($_GET['id'])) {
                        $id = $_GET['id'];
                        $stmt = $conn->query("SELECT * FROM users WHERE id = $id");
                        $stmt->execute();
                        $data = $stmt->fetch();
                }
            ?>


                <div class="mb-3">
                    <input type="hidden" name="id" value="<?php echo $id; ?>"> <!-- Add this line -->
                    <label for="username" class="col-form-label">Username:</label>
                    <input type="text" value="<?php echo $data['username']; ?>" required class="form-control" name="username">
                </div>

                <hr>
                <a href="profile.php" class="btn btn-secondary">Go Back</a>
                <button type="submit" name="update" class="btn btn-primary">Update</button>
            </form>
    </div>

</html>