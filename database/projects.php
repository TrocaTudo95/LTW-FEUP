<?php
  function addTask($dbh,$todoref,$information,$priority,$datedue,$ischecked, $assignedTo){
    $stmt = $dbh->prepare('SELECT id FROM tasks WHERE projectRef = ? AND information = ?');
    $stmt->execute(array($todoref,$information));
    $result = $stmt->fetch();
    if ($result){
      echo('Task duplicated');
      return;
    }
    $stmt = $dbh->prepare('INSERT INTO tasks VALUES (?,?,?,?,?,?,?)');
    $stmt->execute(array(NULL,$todoref,$information,$priority,$datedue,$ischecked,$assignedTo));
  }

  function addTasks($dbh,$items,$todo_id){
    foreach($items as $item){
      addTask($dbh,$todo_id,$item['text'],$item['priority'],$item['datedue'],0);
    }
  }

  function addcategories($dbh,$title,$userref){
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
 * Add a todo list to the database and check if it already exists.
 */
  function addprojects($dbh,$name, $color, $userref,$categoryref){
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
  function getListsForUserId($dbh,$userid){
    $stmt = $dbh->prepare('SELECT * from projects WHERE userRef = ?');
    $stmt->execute(array($userid));
    $user_lists = $stmt->fetchAll();
  }

  function getAllprojectss($dbh){
    $stmt = $dbh->prepare('SELECT * from projects');
    $stmt->execute();
    return $stmt->fetchAll();
  }
  function getprojectsItems($dbh,$todo_id){

  }

  function insertUserIntoProject($dbh, $userid, $projectid, $permissions){
    $stmt = $dbh->prepare('INSERT INTO projectUsers (projectRef, userRef, permissions) VALUES (?,?,?)');
    $stmt->execute(array($projectid,$userid,$permissions));
  }

  function setUserPermissions($dbh, $userid, $projectid, $permissions){
    $stmt = $dbh->prepare('UPDATE projectUsers SET permissions = ? WHERE userRef = ? AND projectRef = ?');
    $stmt->execute(array($permissions,$userid,$projectid));
  }
?>
