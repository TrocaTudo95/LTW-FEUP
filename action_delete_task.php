<?php
session_start();
if(!isset($_SESSION['username'])) die('user is not set');
if ($_SESSION['csrf'] !== $_POST['csrf']) {
  die('-3');
}
if(!isset($_GET['taskid'])) die('task not defined');
include_once('database/connection.php');
include_once('database/projects.php');
include_once('database/users.php');

$userid = getUserId($dbh,$_SESSION['username']);
if ($userid != -1){
    if (is_numeric($_GET['taskid'])){
        $return = deleteTask($dbh,$_GET['taskid']);
        echo $return;
    }else{
        die('task parse error');
    }
}else{
    die('user not registered');
}

?>
