<?php
  session_start();                         // starts the session
  include_once('database/connection.php'); // connects to the database
  include_once('database/users.php');      // loads the functions responsible for the users table
  include_once('database/projects.php');
  include_once('database/projectUsers.php');

  if(isset($_SESSION['is_logged']) && isset($_SESSION['username'])){
    if($_SESSION['is_logged'] == true){
      try{
        $user_id = getUserId($dbh,$_SESSION['username']);
        $projects = getAllProjectIdsForUser($dbh,$user_id);
        $tasks = array();
        foreach($projects as $project){
          $project_id = $project['projectRef'];
          array_push($tasks,getProjectTasks($dbh,$project_id)); 
        }
        echo(json_encode($tasks));
      }catch(PDOException $e){
        die($e);
      }
    }
      
  }


?>
