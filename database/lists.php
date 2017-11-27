<?php
  function addListItem($dbh,$todoref,$information,$priority,$datedue,$ischecked){
    $stmt = $dbh->prepare('SELECT ID FROM ToDoItem WHERE ToDoRef = ? AND Information = ?');
    $stmt->execute(array($todoref,$information));
    $result = $stmt->fetch();
    if ($result){
      echo('Item duplicated');
      return;
    }
    $stmt = $dbh->prepare('INSERT INTO ToDoItem VALUES (?,?,?,?,?,?)');
    $stmt->execute(array(NULL,$todoref,$information,$priority,$datedue,$ischecked));
  }

  function addListItems($dbh,$items,$todo_id){
    foreach($items as $item){
      addListItem($dbh,$todo_id,$item['text'],$item['priority'],$item['datedue'],0);
    }
  }

  function addCategory($dbh,$title,$userref){
    $stmt = $dbh->prepare('SELECT ID FROM Category WHERE Title = ? AND UserRef = ?');
    $stmt->execute(array($title,$userref));
    $result = $stmt->fetch();
    if ($result){
      // Category already exists for the user
      return $result['ID'];
    }else{
      $stmt = $dbh->prepare('INSERT INTO Category VALUES (?,?,?)');
      $stmt->execute(array(NULL,$title,$userref));
      return $dbh->lastInsertId();
      
    }
  }
/**
 * Add a todo list to the database and check if it already exists.
 */
  function addToDoList($dbh,$name, $color, $userref,$categoryref){
    $stmt = $dbh->prepare('SELECT ID from ToDoList WHERE Name = ? AND UserRef = ? AND CategoryRef = ?');
    $stmt->execute(array($name,$userref,$categoryref));
    $result = $stmt->fetch();
    if ($result){
      return $result['ID'];
    }else{
      $stmt = $dbh->prepare('INSERT INTO ToDoList VALUES (?,?,?,?,?)');
      $stmt->execute(array(NULL,$name,$color,$userref,$categoryref));
      return $dbh->lastInsertId();
    }
  }
  function getListsForUserId($dbh,$userid){
    $stmt = $dbh->prepare('SELECT * from ToDoList WHERE UserRef = ?');
    $stmt->execute(array($userid));
    $user_lists = $stmt->fetchAll();
  }
?>
