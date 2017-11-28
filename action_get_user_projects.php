<?php

session_start();
include_once('database/connection.php');
include_once('database/projects.php');

if ($_SESSION['is_logged'] == true){
    $projects = getAllProjectsForUser($dbh,$_SESSION['username']);
    foreach($projects as $project_id){
        $tasks = getProjectTasks($project_id);
    }
}else{
    // get projects from session;
}

?>