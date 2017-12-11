<?php
if (!isset($_GET['taskid'])) die('task id not defined');
include_once('database/connection.php');
include_once('database/projects.php');

try{
    $result = taskChangeIsChecked($dbh,$_GET['taskid']);
    echo(json_encode($result));
}catch(PDOException $e){
    echo($e);
}
?>