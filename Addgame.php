<?php
    include('components/server.php');

    // ตรวจสอบว่ามี session เปิดอยู่หรือไม่
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if(isset($_COOKIE['GameID'])){
        $GameID = $_COOKIE['GameID'];
    }else{
        setcookie('GameID',create_unique_GameID(),time()+60*60*24*30);
    }
    

    if (isset($_POST['add_game'])) {
        $NameOfGame = filter_var($_POST['NameOfGame'], FILTER_SANITIZE_STRING);
        $GameCreator = filter_var($_POST['GameCreator'], FILTER_SANITIZE_STRING);
        $FilePath = filter_var($_POST['FilePath'], FILTER_SANITIZE_STRING);
        $Category = isset($_POST['Category']) ? filter_var($_POST['Category'], FILTER_SANITIZE_STRING) : '';
        $GameDescription = filter_var($_POST['GameDescription'], FILTER_SANITIZE_STRING);

        $GameImage = $_FILES['GameImage']['name'];
        $GameImage = filter_var($GameImage, FILTER_SANITIZE_STRING);
        $ext = pathinfo($GameImage, PATHINFO_EXTENSION);
        $rename = create_unique_GameID() . '.' . $ext;
        $image_tmp_name = $_FILES['GameImage']['tmp_name'];
        $image_size = $_FILES['GameImage']['size'];
        $image_folder = 'uploaded_files/' . $rename;

        $warning_msg = array();
        $success_msg = array();

        if ($image_size > 2000000) {
            $warning_msg[] = 'Image size is too large!';
        } else {
            // รับ user_id จาก session
            $user_id = $_SESSION['user_login'];

        // Generate a unique GameID
        $GameID = create_unique_GameID();

        // Check if the generated GameID already exists in the database
        $stmt = $conn->prepare("SELECT GameID FROM game WHERE GameID = ?");
        $stmt->execute([$GameID]);

        // If the GameID already exists, generate a new one until a unique one is found
        while ($stmt->fetchColumn()) {
            $GameID = create_unique_GameID();
        }
        
        $insert_game = $conn->prepare("INSERT INTO game (GameID, NameOfGame, GameCreator,
        FilePath, Category, GameDescription, GameImage, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

        
        $insert_game->execute([$GameID, $NameOfGame, $GameCreator, $FilePath, $Category, $GameDescription, $rename, $user_id]);
        $success_msg[] = 'Game uploaded!';
        move_uploaded_file($image_tmp_name, $image_folder);
}}
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/addgames.css" rel="stylesheet">
    <title>x8</title>
</head>
<body>
    <!-- Nav Section Start -->
    <?php include 'components/userheader.php';?>
    <!-- Nav Section -->

    <!-- Add -->
    <section class="add-game">
        <form action="" method="POST" enctype="multipart/form-data">
            <h3>Game Details</h3>
            <p>Game Name <span>*</span></p>
            <input type="text" name="NameOfGame" required maxlength="50" placeholder="Enter Game" class="box">
            <p>Game Creator Name <span>*</span></p>
            <input type="text" name="GameCreator" required maxlength="50" placeholder="Enter Game Creator" class="box">
            <p>Game Link<span>*</span></p>
            <input type="text" name="FilePath" required  placeholder="Enter Game Link" class="box">

            <p>Game Description/How to play <span>*</span></p>
            <input type="text" name="GameDescription" required maxlength="350" placeholder="Enter Game Description" class="box-desc">
            <p>MainCategory<span>*</span></p>
            <select name="Category" id="Category">
            <option value="Action">Action and Adventure Games</option>
                <option value="Driving">Driving</option>
                <option value="Fighting">Fighting</option>
                <option value="Girls">For girls</option>
                <option value="Shooting">Shooting</option>
                <option value="Sports">Sports</option>
                <option value="Other">Other</option>
            </select>
            <p>Game Image<span>*</span></p>
            <input type="file" name="GameImage" required accept="image/*" class="box">
            <input type="submit" value="Add game" name="add_game" class="btn">
            <button type="button" class="btn" onclick="redirectToUpload()">go back</button>

        </form>
    </section>
    <!-- Add -->
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="javas/script.js"></script>
    <?php include 'components/alert.php'; ?>
    <script>
<?php if(isset($_SESSION['alert'])): ?>
    swal({
        title: "<?php echo $_SESSION['alert']['title']; ?>",
        text: "<?php echo $_SESSION['alert']['text']; ?>",
        icon: "<?php echo $_SESSION['alert']['icon']; ?>",
        button: "OK",
    }).then((value) => {
        if (value) {
            window.location.href = "upload.php";
        }
    });
    <?php unset($_SESSION['alert']); ?>
<?php endif; ?>

    function redirectToUpload() {
        window.location.href = 'upload.php';
    }




</script>
</body>
</html>
