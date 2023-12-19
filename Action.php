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
    <link href="css/main.css" rel="stylesheet">
    <script src="javas/app.js"></script>
    <title>x8</title>
</head>
<body>
    <!-- Nav Section Start -->
    <!-- <?php include 'components/header.php';?> -->
    <!-- Nav Section -->

    <!-- Banner Start-->

    <div class="filter-wrapper">
      <div id="search-container">
        <input
          type="search"
          id="search-input"
          placeholder="Search product name here.."
        />
        <button id="search">Search</button>
      </div>
      <div id="buttons">
        <button class="button-value" onclick="filterProduct('Action and Adventure Games')">
          Action and Adventure Games
        </button>
        <button class="button-value" onclick="filterProduct('Driving')">
            Driving
        </button>
        <button class="button-value" onclick="filterProduct('Fighting')">
            Fighting
        </button>
        <button class="button-value" onclick="filterProduct('For girls')">
        For girls
        </button>
        <button class="button-value" onclick="filterProduct('Shooting')">
        Shooting
        </button>
        <button class="button-value" onclick="filterProduct('Sports')">
        Sports
        </button>
        <button class="button-value" onclick="filterProduct('Other')">
        Other
        </button>
        </div></div>

    <!-- Banner End -->

    <!-- Add game information -->
    <section class="games">
        <h1 class="heading">All Games</h1>
    <?php
        $select_game = $conn->prepare("SELECT * FROM `game` WHERE Category");
        $select_game->execute();
        if($select_game-> rowCount()>0){ while($fetch_game = $select_game-> fetch(PDO::FETCH_ASSOC)){
    ?>
    <div class="wrapper">
        <div class="cols">
            <div class="col" ontouchstart="this.classList.toggle('hover');">

            <a href="gameplay.php?get_GameID=<?=$fetch_game['GameID'];?>">

                <div class="container">
                    <div class="front">
                    <form action="" method="POST">
                    <img src="uploaded_files/<?= $fetch_game['GameImage']; ?>" class="Gameimage" alt="">
                        <div class="inner">
                            <span>
                                <div class="creator_icon">
                                    <img src="" alt="">
                                </div>
                                <div class="game-name">
                                    <p class="des"><i class="fas fa-india-rupee-sign"></i><?= $fetch_game
                                    ['NameOfGame']; ?></p>
                                </div>
                                <div class="rate">
                                    <p>ratings</p>
                                </div>
                            </span>
                        </div><!--inner--> 
                    </div><!--front--> 
                    <div class="back">
                        <div class="inner">
                            <p><?= $fetch_game['GameDescription'] ?></p>
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