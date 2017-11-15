<?php
  if (!isset($_POST['username'])) die('No username');
  if (!isset($_POST['password'])) die('No password');
  session_start();                         // starts the session
  include_once('database/connection.php'); // connects to the database
  include_once('database/users.php');      // loads the functions responsible for the users table

  if (userExists($dbh, $_POST['username'])){
    if (checkPassword($dbh,$_POST['username'],$_POST['password'])){
      header('Location: display_user_lists.php?id=' . $_POST['username']);
      $_SESSION['username'] = $_POST['username'];
      $_SESSION['is_logged'] = true;
    }
  }

  
?>
