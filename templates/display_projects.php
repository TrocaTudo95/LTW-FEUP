<?php
include_once("database/connection.php");
include_once("database/projects.php");

$projects = getAllProjects($dbh);
?>


<section id="projects">
<!--Se tiver feito login -->
<?php
  foreach($projects as $project){
    $tasks = getProjectTasks($dbh,$project['id']);
    $num_tasks = count($tasks);
    echo '<article class="projects round_corners" id=' . $project['id'] .' style=background-color:'. $project['color'] .';>';
    echo '<header id="project">';
    echo '<h3>' . $project['name'] . '</h3></header>';
    echo '<span class="round_corners" id="num_tasks">' . $num_tasks . ' Tasks</span>';
    echo'<section class="tasks round_corners">';
       foreach ($tasks as $task) {
        echo '<div class="task" id='. $task['id'] .'>';
        echo '<span>'. $task['information']. '</span>';
        echo '<i class="fa fa-trash" aria-hidden="true"></i>';
        echo '</div>';
       }
   echo '</article>';
  }
?>

</section>
