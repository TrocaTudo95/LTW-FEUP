<?php
session_start();
if(!isset($_SESSION['username'])) die('user is not set');
if(!isset($_GET['projectid'])) die('project not defined');
include_once('database/connection.php');
include_once('database/projects.php');
include_once('database/users.php');

$userid = getUserId($dbh,$_SESSION['username']);
if ($userid != -1){
    if (is_numeric($_GET['projectid'])){
        $return = deleteProject($dbh,$_GET['projectid'],$userid);
        echo $return;
    }else{
        die('task parse error');
    }
} else{
    die('user not registered');
}

?>