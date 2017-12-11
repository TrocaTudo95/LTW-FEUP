<?php
  session_start();
  if (!isset($_POST['username'])) die('username not set');
  if (!isset($_POST['password'])) die('password not set');
  if (!isset($_POST['email'])) die('email not set');

  include_once('database/connection.php'); // connects to the database
  include_once('database/users.php');      // loads the functions responsible for the users table

  if (!userExists($dbh,$_POST['username'])){  // test if user exists
    try{
      register($dbh,$_POST['username'], $_POST['password'], $_POST['email']);
      sendMail();
    }catch (PDOException $e) {
      die('-1'); //email repeated
    }
  }else{
    die("-2"); //user does not exist
  }
  $_SESSION['username'] = $_POST['username'];
  $_SESSION['is_logged'] = true;

  function sendMail(){
    document.location="mailto:renatoineeve@gmail.com?"+
    "subject=This%20is%20the%20subject&body=User%20registered";
  }
?>
