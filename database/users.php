<?php
  include_once('debug.php');
  function userExists($dbh,$username){
    $stmt = $dbh->prepare('SELECT * FROM User WHERE Username = ?');
    $stmt->execute(array($username));
    $result = $stmt->fetchAll();
    if ($result){
      return true;
    }
    return false;

  }
  function register($dbh, $username, $password, $email) {
    $stmt = $dbh->prepare('INSERT INTO User (Username, Password, Email) VALUES (?,?,?)');
    $stmt->execute(array($username, hash('sha256',$password),$email));
    return true;
  }
  function checkPassword($dbh, $username, $password){
    $hashedPassword = hash('sha256',$password);
    $stmt = $dbh->prepare('SELECT Username,Password FROM User WHERE Username = ? AND Password = ?');
    $stmt->execute(array($username,$hashedPassword));
    $user = $stmt->fetchAll();
    if ($user == false){
      return false;
    }
    return true;
  }
  function getUserId($dbh,$username){
    $stmt = $dbh->prepare('SELECT * FROM User WHERE Username = ?');
    $stmt->execute(array($username));
    $result = $stmt->fetch();
    return $result['ID'];
  }

 ?>
