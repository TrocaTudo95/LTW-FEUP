<?php
if(isset($_SESSION['is_logged']) && isset($_SESSION['username'])){
  echo '<section id="next_tasks_display"></section>';
}
?>
