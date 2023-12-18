<?php 

    session_start();
    include_once 'config/db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Upload Image System</title>
    <link rel="stylesheet" href="profile.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
</head>
<body>
    <header>
    <nav>
        <div class="logo">
            <a href="#">MySite</a>
        </div>
        
        <ul class="menu">
            <li><a href="#">Contact</a></li>
            <li><a href="#">Sign up</a></li>
            <li><button class="btnLogin">Login</button></li>
        </ul>
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
        </div>

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
    </div> -->
    
    <img src="image/aqua cry.png" alt="Italian Trulli" class = "profile_img">
    <table class="table">
        <thead>
            <tr>
            <th scope="col">#</th>
            <th scope="col">First name</th>
            <th scope="col">Last name</th>
            <th scope="col">Username</th>
            <th scope="col">Email</th>
            <th scope="col">Date of birth</th>
            <th scope="col">action</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $stmt = $conn->query("select * from users");
                $stmt->execute();
                $users = $stmt->fetchAll();

                if (!$users) {
                    echo "<p><td colspan='6' class='text-center'>No data available</td></p>";
                } else {
                    foreach($users as $user) {

            ?>
            <tr>
            <th scope="row"><?= $user['id'];?></th>
            <td><?= $user['firstname'];?></td>
            <td><?= $user['lastname'];?></td>
            <td><?= $user['username'];?></td>
            <td><?= $user['email'];?></td>
            <td><?= $user['date_of_birth'];?></td>
            <td>
                <a href="edit.php?id=<?= $user['id']; ?>"></a>
            </td>
            </tr>
            <?php } 
                }?>
        </tbody>
    </table>






</body>
</html>