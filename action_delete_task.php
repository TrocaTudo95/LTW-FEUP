<?php
session_start();
if(!isset($_SESSION['username'])) die('user is not set');
if(!isset($_GET['taskid'])) die('task not defined');
include_once('database/connection.php');
include_once('database/projects.php');
include_once('database/users.php');

$userid = getUserId($_SESSION['username']);
if ($userid != -1){
    if (is_numeric($_GET['taskid'])){
        deleteTask($_GET['taskid']);
    }else{
        die('task parse error');
    }
}else{
    die('user not registered');
}

?>