<?php
include_once("database/connection.php");
include_once("database/projects.php");
include_once("database/users.php");

if(isset($_SESSION['is_logged']) && isset($_SESSION['username'])){
  if($_SESSION['is_logged'] == true){
    $user_id = getUserId($dbh,$_SESSION['username']);
    $projects = getAllProjectsForUser($dbh,$user_id);
  }
}
?>


<section id="projects">
<!--Se tiver feito login -->
<?php
  if (isset($projects)){
    foreach($projects as $project){
      $tasks = getProjectTasks($dbh,$project['id']);
      $num_tasks = count($tasks);
      $creator_id = getProjectCreator($dbh,$project['id']);
      $creator_username = $project['creator'];
      $category = $project['category'];
      echo '<article class="projects round_corners" id=' . $project['id'] .' style=background-color:'. $project['color'] .';>';
      echo '<header id="project">';
      echo '<h3>' . $project['name'] . '</h3></header>';
      echo '<span id="project_creator">Created by: ' . $creator_username . '</span>';
      echo '<span id="project_category">Category: ' . $category . '</span>';
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
  }
?>

</section>
