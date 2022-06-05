<?php
    require_once "../database/database.php";
    session_start();
    unset($_SESSION['admin']);
    header('location: ../../login.php');
?>