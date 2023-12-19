<?php
include('components/server.php');
unset($_SESSION['user_login']);
header('location: main.php');
?>