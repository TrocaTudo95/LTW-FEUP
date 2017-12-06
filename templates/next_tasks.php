<?php
include_once("database/connection.php");
include_once("database/projects.php");
include_once("database/users.php");

if(isset($_SESSION['is_logged']) && isset($_SESSION['username'])){
  if($_SESSION['is_logged'] == true){
    $user_id = getUserId($dbh,$_SESSION['username']);
    $tasks = getAllTasks($dbh,$user_id);

  }
}
?>

<section id="next_tasks_display">
<?php
  if (isset($tasks)){
         foreach ($tasks as $task) {
          echo '<div class="task" id='. $task['id'] .'>';
          echo '<span>'. $task['information']. '</span>';
          echo '<span>'. $task['dateDue']. '</span>';
          echo '</div>';
         }
    }
    else{
      die("user is not set");
    }
?>
</section>
