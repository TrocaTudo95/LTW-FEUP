<?php
  function userExists($dbh,$username){
    $stmt = $dbh->prepare('SELECT * FROM users WHERE username = ?');
    $stmt->execute(array($username));
    $result = $stmt->fetchAll();
    if ($result){
      return true;
    }
    return false;

  }
  function register($dbh, $username, $password, $email) {
    $stmt = $dbh->prepare('INSERT INTO users (username, password, email) VALUES (?,?,?)');
    $stmt->execute(array($username, hash('sha256',$password),$email));
    return true;
  }
  function checkPassword($dbh, $username, $password){
    $hashedPassword = hash('sha256',$password);
    $stmt = $dbh->prepare('SELECT username,password FROM users WHERE username = ? AND password = ?');
    $stmt->execute(array($username,$hashedPassword));
    $user = $stmt->fetchAll();
    if ($user == false){
      return false;
    }
    return true;
  }
  function getusersId($dbh,$username){
    $stmt = $dbh->prepare('SELECT * FROM users WHERE username = ?');
    $stmt->execute(array($username));
    $result = $stmt->fetch();
    return $result['ID'];
  }

 ?>
