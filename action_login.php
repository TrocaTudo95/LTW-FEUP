<?php
  if (!isset($_POST['username'])) die('No username');
  if (!isset($_POST['password'])) die('No password');
  session_start();                         // starts the session
  include_once('database/connection.php'); // connects to the database
  include_once('database/users.php');      // loads the functions responsible for the users table
  include_once('script/login_script.js');

  if (!isset($_SESSION['csrf'])) {
  $_SESSION['csrf']) = generate_random_token();
}
  if (userExists($dbh, $_POST['username'])){
    if (checkPassword($dbh,$_POST['username'],$_POST['password']) == 0){
      $_SESSION['username'] = $_POST['username'];
      $_SESSION['is_logged'] = true;
    }else{
      die('-2'); //Incorrect Password
    }
  }else{
    die('-1'); //User does not exist

  }
  if ($_SESSION['csrf'] !== $_POST['csrf']) {
    die('-3');
  }

?>
