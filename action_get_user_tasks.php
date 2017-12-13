<?php
  session_start();                         // starts the session
  include_once('database/connection.php'); // connects to the database
  include_once('database/users.php');      // loads the functions responsible for the users table
  include_once('database/projects.php');

  if(isset($_SESSION['is_logged']) && isset($_SESSION['username'])){
    if($_SESSION['is_logged'] == true){
      $user_id = getUserId($dbh,$_SESSION['username']);
      $tasks = getAllTasks($dbh,$user_id);
      echo(json_encode($tasks));
    }
  }


?>
