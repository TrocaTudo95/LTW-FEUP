<?php
session_start();
include_once('database/connection.php');
include_once('database/projects.php');
include_once('database/users.php');

if(isset($_SESSION['is_logged']) && isset($_SESSION['username'])){
  if($_SESSION['is_logged'] == true){
    $user_id = getUserId($dbh,$_SESSION['username']);
    $projects = getAllProjectsForUser($dbh,$user_id);
    foreach($projects as &$project){
      try{
        $tasks = getProjectTasks($dbh,$project['id']);
      }catch(PDOException $e){
        die('Error Getting tasks');
      }
      
      $project['tasks'] = $tasks;
    }
    echo json_encode($projects);
  }
}

?>
