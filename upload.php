<?php 
    include('components/server.php');
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

    if(isset($_COOKIE['GameID'])){
        $GameID = $_COOKIE['GameID'];
    } else {
        setcookie('GameID', create_unique_GameID(), time() + 60 * 60 * 24 * 30);
    }


    // if (isset($_GET['delete'])) {
    //     $delete_id = $_GET['delete'];
    //     $deletestmt = $conn->query("DELETE FROM game WHERE GameID = $delete_id");
    //     $deletestmt->execute();

    //     if ($deletestmt) {
    //         echo "<script>alert('Data has been deleted successfully');</script>";
    //         // $_SESSION['success'] = "Data has been deleted succesfully";
    //         header("refresh:1; url=upload.php");
    //     }
        
    // }

    if (isset($_GET['delete_user']) && isset($_GET['delete_game'])) {
        $delete_user_id = $_GET['delete_user'];
        $delete_game_id = $_GET['delete_game'];
    
        $deletestmt = $conn->prepare("DELETE FROM game WHERE GameID = ? AND user_id = ?");
        $deletestmt->execute([$delete_game_id, $delete_user_id]);
    
        if ($deletestmt) {
            echo "<script>alert('Data has been deleted successfully');</script>";
            header("refresh:1; url=upload.php");
        }
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/upload.css" rel="stylesheet">
    <script src="javas/app.js"></script>
    <title>x8</title>
</head>
<body>
    <!-- Nav Section Start -->
    <?php include 'components/userheader.php';?>
    <!-- Nav Section -->

    <?php
        if (isset($_SESSION['user_login'])){
            $user_id = $_SESSION['user_login'];
            $stmt = $conn->query("select * from users where id = $user_id");
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        ?>
        <!-- <?php echo $row['firstname']?> -->

    <!-- All My Game -->
    <div class="addgame">
        <a href="Addgame.php"><button class="btnLogin">Add Game</button></a>
    </div>
    <section class="games">
        <table>
            <thead>
                <th>Image</th>
                <th>Name of Game</th>
                <th>Game Creator</th>
                <th>File Path</th>
                <th>Description</th>
            </thead>
            <tbody>
                <?php
                    $uploadList = $conn->prepare("SELECT * FROM `game` WHERE user_id = ?");
                    $uploadList->execute([$user_id]);

                    if($uploadList->rowCount() > 0) {
                        while($fetch_gamelist = $uploadList->fetch(PDO::FETCH_ASSOC)) {
                ?>
                            <tr>
                                <td><img src="uploaded_files/<?= $fetch_gamelist['GameImage']; ?>" class="Gameimage" height="100" alt="" ></td>
                                <td><p class="des"><i class="fas fa-india-rupee-sign"></i><?= $fetch_gamelist['NameOfGame']; ?></p></td>
                                <td><p class="des"><i class="fas fa-india-rupee-sign"></i><?= $fetch_gamelist['GameCreator']; ?></p></td>
                                <td><p class="des"><i class="fas fa-india-rupee-sign"></i><?= $fetch_gamelist['FilePath']; ?></p></td>
                                <td><p class="des"><i class="fas fa-india-rupee-sign"></i><?= $fetch_gamelist['GameDescription']; ?></p></td>
                                <!-- <td><a href="upload_edit.php" class="btn btn-primary">Edit</a></td> -->
                                <!-- <td><a href="?delete=<?= $row['id']; ?>" class="btn btn-danger" onclick="return confirm('are you sure you want to delete?')">Delete</a></td> -->
                                <td>
                                    <a href="?delete_user=<?= $user_id ?>&delete_game=<?= $fetch_gamelist['GameID']; ?>" 
                                    class="btn btn-danger" 
                                    onclick="return confirm('Are you sure you want to delete?')">Delete</a>
                                </td>

                                <td>
                                    <form action="" method="post">
                                    
                                    </form>
                                </td>
                            </tr>
                <?php
                        }
                    } else {
                        // Handle case when no games are found
                        echo "<tr><td colspan='5'>No games found</td></tr>";
                    }
                ?>
            </tbody>
        </table>
    </section>
    <!-- Add game information -->         
</body>
</html>
