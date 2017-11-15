<?php
  include_once('debug.php');
  function userExists($dbh,$username){
    echo('Checking if user exists in db <br>');
    $stmt = $dbh->prepare('SELECT * FROM User WHERE Username = ?');
    $stmt->execute(array($username));
    $result = $stmt->fetchAll();
    if ($result){
      echo('user exists in db <br>');
      return true;
    }
    echo('user does not exists in db <br>');
    return false;

  }
  function register($dbh, $username, $password) {
    $stmt = $dbh->prepare('INSERT INTO User (Username, Password) VALUES (?,?)');
    $stmt->execute(array($username, hash('sha256',$password)));
    echo "insert user into db";
    return true;
  }
  function checkPassword($dbh, $username, $password){
    $hashedPassword = hash('sha256',$password);
    $stmt = $dbh->prepare('SELECT Username,Password FROM User WHERE Username = ? AND Password = ?');
    $stmt->execute(array($username,$hashedPassword));
    $user = $stmt->fetchAll();
    if ($user == false){
      echo('incorrect password<br>');
      return false;
    }
    return true;
  }

 ?>
