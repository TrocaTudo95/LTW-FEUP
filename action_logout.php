<?php
    session_start();
    if (isset($_SESSION['is_logged'])){
        $_SESSION['is_logged'] = false;
        unset($_SESSION['username']);
        header('Location: index.php');
    }
?>