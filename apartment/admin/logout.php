<?php
    session_start();
    $_SESSION['login'] = false;

    unset($_SESSION['login']);

    header("Location: login.php");

?>