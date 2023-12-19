<?php 
    include('components/server.php');

    if(isset($_COOKIE['GameID'])){
        $GameID = $_COOKIE['GameID'];
    }else{
        setcookie('GameID',create_unique_GameID(),time()+60*60*24*30);
    }

    if(isset($_GET['get_GameID'])){
        $get_GameID = $_GET['get_GameID'];
     }else{
        $get_GameID = '';
        header('location:main.php');
     }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/gameplay.css" rel="stylesheet">
    <script src="javas/app.js"></script>
    <title>x8</title>
</head>
<body>
    <!-- Nav Section Start -->
    <?php include 'components/header.php';?>
    <!-- Nav Section -->
    
    <?php
        $select_game = $conn->prepare("SELECT * FROM `game` WHERE GameID = ? LIMIT 1");
        $select_game->execute([$get_GameID]);
        if($select_game-> rowCount()>0){ 
            while($fetch_game = $select_game-> fetch(PDO::FETCH_ASSOC)){
    ?>
    <div class="game-screen">
    <iframe src=<?= $fetch_game['FilePath']; ?> scrolling="no" class="screen"> </iframe>
    </div>  
    
    <div class="desc">
        <button class="btndesc">Description</button>
    </div>
    <div class="rate">
        <button class="btnRating">Rating</button>
    </div>

        <?php }}else {
    echo '<p class="empty">no game found!</p>';
} ?>
</body>
</html>