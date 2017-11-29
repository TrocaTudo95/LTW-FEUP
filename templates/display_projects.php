<?php
include_once("database/connection.php");
include_once("database/projects.php");

$projects = getAllProjects($dbh);
?>


<div id="Projects">
<!--Se tiver feito login -->
<?php
  foreach($projects as $project){
    echo '<section id=' . $project['id'] . '>';
    echo '<article>';
    echo '<header>';
    echo '<h3>' . $project['name'] . '</h3>';
    $tasks = getProjectTasks($dbh,$project['id']);
       foreach ($tasks as $task) {
        echo'<div id=' . $task['id'] . '>';
        echo '<span>'. $task['information']. '</span>';
        echo '<i class="fa fa-trash" aria-hidden="true"></i>';
        echo '</div>';
       }
   echo '</header>';
   echo '</article>';
   echo '</section>';
  }
?>

</div>
