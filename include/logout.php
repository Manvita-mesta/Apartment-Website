<?php

    session_start();

    unset($_SESSION['isLogin']);
    unset($_SESSION['name']);
    unset($_SESSION['type']);
    unset($_SESSION['id']);

    echo "<script>alert('You have logged out successfully');location.href='../index.php'</script>";

?>