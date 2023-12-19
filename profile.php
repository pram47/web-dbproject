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
            header("refresh:1; url=log-sig.php");
        }
        
    }

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
        <?php include 'components/header.php';?>
    </nav>
    </header>
    <!-- <div class="container">
        
        <div class="row mt-5">
            <div class="col-12">
                <form action="upload.php" method="POST" enctype="multipart/form-data">
                    <div class="text-center justify-content-center align-items-center p-4 border-2 border-dashed rounded-3">
                        <h6 class="my-2">Select image file to upload</h6>
                        <input type="file" name="file" class="form-control streched-link" accept="image/gif, image/jpeg, image/png">
                        <p class="small mb-0 mt-2"><b>Note:</b> Only JPG, JPEG, PNG & GIF files are allowed to upload</p>
                    </div>
                    <div class="d-sm-flex justify-content-end mt-2">
                        <input type="submit" name="submit" value="Upload" class="btn btn-sm btn-primary mb-3">
                    </div>
                </form>
            </div>
        </div>
        
        <div class="row">
            <?php  if (!empty($_SESSION['statusMsg'])) { ?>
                <div class="alert alert-success" role="alert">
                    <?php 
                        echo $_SESSION['statusMsg']; 
                        unset($_SESSION['statusMsg']);
                    ?>
                </div>
            <?php } ?>
        </div> -->

        <div class="row g-2">
            <?php 
                $query = $conn->query("SELECT * FROM images ORDER BY uploaded_on DESC");
                if ($query !== false && $query->rowCount() > 0) {
                    while($row = $query->fetch(PDO::FETCH_ASSOC)) {
                        $imageURL = 'uploads/'.$row['file_name'];
                    ?>
                    <div class="col-sm-6 col-lg-4 col-xl-3">
                        <div class="card shadow h-100">
                            <img src="<?php echo $imageURL ?>" alt="" width="100%" class="card-img">
                        </div>
                    </div>
                <?php 
                    }
                } else { ?>
                <p>No image found...</p>
            <?php } ?>
        </div>
    </div>
    


    <?php
        if (isset($_SESSION['user_login'])){
            $user_id = $_SESSION['user_login'];
            $stmt = $conn->query("select * from users where id = $user_id");
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        ?>
        <!-- <?php echo $row['firstname']?> -->

    <!-- <img src="image/aqua cry.png" alt="Italian Trulli" class = "profile_img"> -->
    <table class="table">
        <thead>
            <tr>
            <th scope="col">#</th>
            <th scope="col">Username</th>
            <th scope="col">Email</th>
            <!-- <th scope="col">Date of birth</th>
            <th scope="col">Profile image</th> -->
            </tr>
        </thead>
        <tbody>
            
            <tr>

            <th scope="row"><?= $row['id'];?></th>
            <td><?= $row['username'];?></td>
            <td><?= $row['email'];?></td>
            <!-- <td width="250px"><img class="rounded" width="100%" src="uploads/<?php echo $row['img']; ?>" alt=""></td> -->



            <th scope="row"><?= $row['id'];?></th>
            <td><?= $row['username'];?></td>
            <td><?= $row['email'];?></td>
            <td>
                <a href="edit.php?id=<?= $row['id']; ?>"></a>
                <a href="edit.php?id=<?= $row['id']; ?>" class="btn btn-primary">Edit</a>
                <a href="?delete=<?= $row['id']; ?>" class="btn btn-danger" onclick="return confirm('are you sure you want to delete?')">Delete</a>
                <a href="profile.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Profile</a>
            </td>
            </tr>

        </tbody>
    </table>






</body>
</html>