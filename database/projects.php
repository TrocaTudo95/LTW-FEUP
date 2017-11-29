<?php
  include_once('database/projectUsers.php');

  function addTask($dbh,$projectref,$information,$priority,$datedue,$ischecked, $assignedTo){
    $stmt = $dbh->prepare('SELECT id FROM tasks WHERE projectRef = ? AND information = ?');
    $stmt->execute(array($projectref,$information));
    $result = $stmt->fetch();
    if ($result){
      echo('Task duplicated');
      return;
    }
    $stmt = $dbh->prepare('INSERT INTO tasks VALUES (?,?,?,?,?,?,?)');
    $stmt->execute(array(NULL,$projectref,$information,$priority,$datedue,$ischecked,$assignedTo));
  }

  function addTasks($dbh,$items,$project_id){
    foreach($items as $item){
      addTask($dbh,$project_id,$item['text'],$item['priority'],$item['datedue'],0);
    }
  }

  function addCategories($dbh,$title,$userref){
    $stmt = $dbh->prepare('SELECT id FROM categories WHERE title = ? AND userRef = ?');
    $stmt->execute(array($title,$userref));
    $result = $stmt->fetch();
    if ($result){
      // category already exists for the user
      return $result['id'];
    }else{
      $stmt = $dbh->prepare('INSERT INTO categories VALUES (?,?,?)');
      $stmt->execute(array(NULL,$title,$userref));
      return $dbh->lastInsertId();
      
    }
  }
/**
 * Add a project list to the database and check if it already exists.
 */
  function addProjects($dbh,$name, $color, $userref,$categoryref){
    $stmt = $dbh->prepare('SELECT id from projects WHERE Name = ? AND userRef = ? AND categoryRef = ?');
    $stmt->execute(array($name,$userref,$categoryref));
    $result = $stmt->fetch();
    if ($result){
      return $result['id'];
    }else{
      $stmt = $dbh->prepare('INSERT INTO projects VALUES (?,?,?,?,?)');
      $stmt->execute(array(NULL,$name,$color,$userref,$categoryref));
      return $dbh->lastInsertId();
    }
  }
  function getProjectsForCreatorId($dbh,$userid){
    $stmt = $dbh->prepare('SELECT * from projects WHERE creator = ?');
    $stmt->execute(array($userid));
    $user_lists = $stmt->fetchAll();
  }

  
  function getProjectTasks($dbh,$project_id){
    $stmt = $dbh->prepare('SELECT * from tasks WHERE projectRef = ?');
    $stmt->execute(array($project_id));
    return $stmt->fetchAll();
  }

  function getProjectCreator($dbh, $project_id){
    $stmt = $dbh->prepare('SELECT creator from projects WHERE id = ?');
    $stmt->execute(array($project_id));
    return $stmt->fetch();
  }
  

  /**
   * Returns 0 if project deleted with success, -1 if creator id is incorrect or project does not exist.
   */
  function deleteProject($dbh,$project_id,$creator_id){
    $stmt = $dbh->prepare('SELECT * FROM projects WHERE id = ? AND creator = ?');
    $stmt->execute(array($project_id,$creator_id));
    $result = $stmt->fetch();
    if ($result){
      removeAllProjectUsers($dbh,$project_id);
      $stmt = $dbh->prepare('DELETE FROM projects WHERE id = ?');
      $stmt->execute(array($project_id));
      return 0;
    }
    return -1;
  }
?>
