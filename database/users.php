<?php
  function userExists($dbh,$username){
    $stmt = $dbh->prepare('SELECT id FROM users WHERE username = ?');
    $stmt->execute(array($username));
    $result = $stmt->fetchAll();
    if ($result){
      return true;
    }
    return false;

  }
  /**
   * Returns -1 if username is already registered.
   * Returns -2 if email is already registered.
   * Returns 0 in case of success
   */
  function register($dbh, $username, $password, $email) {
    //Check if username is already registered.
    $stmt = $dbh->prepare('SELECT id FROM users WHERE username = ?');
    $stmt->execute(array($username));
    if ($stmt->fetch()){
      return -1;
    }
    //Check if email is already registered
    $stmt = $dbh->prepare('SELECT id from users WHERE email = ?');
    $stmt->execute(array($email));
    if ($stmt->fetch()){
      return -2;
    }
    //Insert user into database
    $apiKey = hash('sha256',strval(time()));
    $stmt = $dbh->prepare('INSERT INTO users (username, password, email,apiKey) VALUES (?,?,?,?)');
    $stmt->execute(array($username, hash('sha256',$password),$email,$apiKey));
    return 0;
  }

  /**
   * Returns 0 if password is correct
   * Returns -1 if password is incorrect
   */
  
  function checkPassword($dbh, $username, $password){
    $hashedPassword = hash('sha256',$password);
    $stmt = $dbh->prepare('SELECT username,password FROM users WHERE username = ? AND password = ?');
    $stmt->execute(array($username,$hashedPassword));
    if ($stmt->fetch()){
      return 0;
    }
    return -1;
  }

function getUserByUsername($dbh,$username){
  $stmt = $dbh->prepare('SELECT * FROM users WHERE username = ?');
  $stmt->execute(array($username));
  $result = $stmt->fetch();
  if ($result){
    return $result;
  }
  return -1;
}
function getUsernameById($dbh,$user_id){
  $stmt = $dbh->prepare('SELECT username FROM users WHERE id = ?');
  $stmt->execute(array($user_id));
  return $stmt->fetch()['username'];
}

  function getUserId($dbh,$username){
    $stmt = $dbh->prepare('SELECT id FROM users WHERE username = ?');
    $stmt->execute(array($username));
    $result = $stmt->fetch();
    if($result){
      return $result['id'];
    }
    return -1;
  }

  /**
   * Returns the api key in case of success;
   * Returns -1 in case of incorrect credentials.
   */
  function getApiKey($dbh,$username,$password){
    $stmt = $dbh->prepare('SELECT apiKey from users WHERE username = ? AND password = ?');
    $stmt->execute(array($username,hash('sha256',$password)));
    $result = $stmt->fetch();
    if ($result){
      return $result['apiKey'];
    }
    return -1;
  }

  /**
   * Returns 0 if api key is correct, -1 otherwise.
   */
  function checkApiKey($dbh,$userId,$apiKey){
    $stmt = $dbh->prepare('SELECT * from users WHERE id = ? AND apiKey = ?');
    $stmt->execute(array($userId,$apiKey));
    $result = $stmt->fetch();
    if ($result){
      return 0;
    }
    return -1;
  }

  function updatePassword($dbh,$user,$newPassword){
    $stmt = $dbh->prepare('UPDATE users SET password = ? WHERE id = ?');
    $stmt->execute(array($newPassword,$user));
    return 0;
  }
  function getAllUsers($dbh){
    $stmt = $dbh->prepare('SELECT id,username FROM users');
    $stmt->execute();
    return $stmt->fetchAll();
  }

 ?>
