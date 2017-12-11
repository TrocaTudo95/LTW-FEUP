<?php
session_start();
if(!isset($_SESSION['username'])) die('Login required');
if(!isset($_GET['projectId'])) die('project id not set');
if(!isset($_GET['information'])) die('Task information undefined');
if(!isset($_GET['priority'])) die('Priority undefined');
if(!isset($_GET['date'])) die('Date undefined');
include_once("database/connection.php");
include_once("database/users.php");
include_once("database/projects.php");
try{
    $username = $_SESSION['username'];
    $information = $_GET['information'];
    $priority = $_GET['priority'];
    $projectref= $_GET['projectId'];
    $ischecked = 0;
    $user_id = getUserId($dbh,$_SESSION['username']);
    $assignedTo = $user_id;
    
    $date =  strtotime($_GET['date']);
    $taskid = addTask($dbh,$projectref,$information,$priority,$date,$ischecked, $assignedTo);
    $task = getTask($dbh,$taskid);
    echo json_encode($task);
}catch(PDOException $e){
    echo($e);
}

?>
