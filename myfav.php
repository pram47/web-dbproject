<?php 
    include('components/server.php');
    if(isset($_COOKIE['GameID'])){
        $GameID = $_COOKIE['GameID'];
    }else{
        setcookie('GameID',create_unique_GameID(),time()+60*60*24*30);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/myfav.css" rel="stylesheet">
    <script src="javas/app.js"></script>
    <title>x8</title>
</head>
<body>
    <!-- Nav Section Start -->
    <?php include 'components/userheader.php';?>
    <!-- Nav Section -->
    <section class="games">
        <h1 class="heading">My Favorite</h1>
    <?php
        $select_fav = $conn->prepare("SELECT * FROM `favorite`");
        $select_fav->execute();
        if($select_fav-> rowCount()>0){ while($fetch_fav = $select_fav-> fetch(PDO::FETCH_ASSOC)){
    ?>
    <div class="wrapper">
        <div class="cols">
            <div class="col" ontouchstart="this.classList.toggle('hover');">

            <a href="gameplayuser.php?get_GameID=<?=$fetch_fav['game_id'];?>">

                <div class="container">
                    <div class="front">
                    <form action="" method="POST">
                    <img src="uploaded_files/<?= $fetch_fav['image']; ?>" class="image" alt="">
                        <div class="inner">
                            <span>
                                <div class="creator_icon">
                                    <img src="" alt="">
                                </div>
                                <div class="game-name">
                                    <p class="des"><i class="fas fa-india-rupee-sign"></i><?= $fetch_fav
                                    ['name']; ?></p>
                                </div>
                                
                            </span>
                        </div><!--inner--> 
                    </div><!--front--> 
                    <div class="back">
                        <div class="inner">
                            <p><?= $fetch_fav['description'] ?></p>
                        </div> <!--inner-->
                    </div> <!--back-->           
                    </form>
                        
                </div><!--container--></a>
            </div><!--col-->
        </div><!--cols-->
        
            
    </div><!--wrapper-->
                        <?php
                                }
                        }
                        else{
                            echo'<p class="empty">no games found!</p>';
                        }
                        ?>
                        
    </section>
    <!-- Add game information -->         
</body>
</html>