<?php
session_start();
if(!isset($_SESSION['username'])) die('Login required');
if ($_SESSION['csrf'] !== $_POST['csrf']) {
  die('-3');
}
if(!isset($_GET['pass'])) die('pass not set');
include_once("database/connection.php");
include_once("database/users.php");

  $user_id = getUserId($dbh,$_SESSION['username']);
  $pass =$_GET['pass'];
  $stmt = $dbh->prepare("UPDATE users SET password=? WHERE id=?");
  $stmt->execute(array(hash('sha256',$pass),$user_id));
  header('Location: user_profile.php');
?>
