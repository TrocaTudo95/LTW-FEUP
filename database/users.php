<?php
  include_once("database/connection.php");

  function userExists(){
    global $db;
    $stmt = $db->prepare('SELECT * FROM User WHERE UserName = ?');
    $stmt->execute(array($_POST['username']));
    $result = $stmt->fetchArray();
    if ($result){
      return true;
    }
    return false;

  }

 ?>
