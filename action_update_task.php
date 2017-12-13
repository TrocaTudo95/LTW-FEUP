<?php
    //session_set_cookie_params(0, '/', "none", true, true);
    session_start();
    if (!isset($_SESSION['username'])) die('No username');
    if (!isset($_GET['taskid'])) die('No task defined');
    if (!isset($_GET['projectid'])) die('No task defined');
    include_once('database/connection.php');
    include_once('database/users.php');
    include_once('database/projects.php');
    try{
        $userid = getUserId($dbh,$_SESSION['username']);
        if ($userid != -1){
            //check task belong to the project
            $taskid_parsed = $_GET['taskid'];
            if (checkTaskBelongsToProject($dbh,$taskid_parsed,$_GET['projectid']) == 0){
                if (isset($_GET['information'])){
                    $info_parsed = $_GET['information'];
                    updateTask($dbh,$taskid_parsed,$info_parsed,'information');
                }
                else if (isset($_GET['dateDue'])){
                    $date_parsed = strtotime($_GET['dateDue']);
                    if (is_numeric($date_parsed)){
                        updateTask($dbh,$taskid_parsed,$date_parsed,'dateDue');
                    }else{
                        die('not numeric');
                    }
                }
                else if (isset($_GET['priority'])){
                    $priority_parsed = $_GET['priority'];
                    if (is_numeric($priority_parsed)){
                        updateTask($dbh,$taskid_parsed,$priority_parsed,'priority');
                    }else{
                        die('not numeric');
                    }
                }else{
                    echo(-2);
                }
            }else{
                echo(-1);
            }
        }
    }catch(PDOException $e){
        die('Nice try');
    }

?>