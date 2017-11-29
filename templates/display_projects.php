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
    echo '<hi>' . $project['name'] . '</h1>';
    $tasks = getAllProjectTasks($dbh,$project['id']);
       foreach ($tasks as $task) {
        echo'<div id=' . $task['id'] . '>';
        echo '<p>'. $task['information']. '<p>';
        echo '<i class="fa fa-trash" aria-hidden="true"></i>';
        echo '</div>'
       }
   echo '</header>';
   echo '</article>';
   echo '</section>';
  }
?>

</div>
