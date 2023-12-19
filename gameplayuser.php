<?php 
include('components/server.php');

if(isset($_COOKIE['GameID'])){
    $GameID = $_COOKIE['GameID'];
}else{
    $GameID = create_unique_GameID();
    setcookie('GameID', $GameID, time()+60*60*24*30);
}

if(isset($_POST['favorite'])){
    $GameID = $_POST['GameID'];
    $NameOfGame = $_POST['NameOfGame'];
    $Category = $_POST['Category'];
    $GameImage = $_POST['GameImage'];
}


if (isset($NameOfGame) && isset($GameImage) && isset($Category)) {
    $select_fav = $conn->prepare("SELECT * FROM `favorite` WHERE name = ?");
    $select_fav->execute([$NameOfGame]);

    if ($select_fav->rowCount() > 0) {
        $message[] = 'fav';
    } else {
        $insert_fav = $conn->prepare("INSERT INTO `favorite`(game_id, name, category,description, image) VALUES (?, ?, ?, ?,?)");
        $insert_fav->execute([$GameID, $NameOfGame, $Category,$GameDescription, $GameImage]);
    }
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
    <?php include 'components/userheader.php';?>
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
    
    <form method="post">
    <input type="hidden" name="GameID" value="<?= $fetch_game['GameID']; ?>">
    <input type="hidden" name="NameOfGame" value="<?= $fetch_game['NameOfGame']; ?>">
    <input type="hidden" name="Category" value="<?= $fetch_game['Category']; ?>">
    <input type="hidden" name="GameDescription" value="<?= $fetch_game['GameDescription']; ?>">
    <input type="hidden" name="GameImage" value="<?= $fetch_game['GameImage']; ?>">
    <input type="submit" class="Favbtn" value="Favorite" name="favorite">
</form>

        <?php }}else {
    echo '<p class="empty">no game found!</p>';
} ?>
</body>
</html>