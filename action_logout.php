<?php
    session_start();
    if ($_SESSION['csrf'] !== $_POST['csrf']) {
      die('-3');
    }
    if (isset($_SESSION['is_logged'])){
        $_SESSION['is_logged'] = false;
        unset($_SESSION['username']);
        header('Location: index.php');
    }
?>
