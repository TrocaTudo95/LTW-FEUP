<?php
session_start();
include_once('database/connection.php');
include_once('database/users.php');
include_once('templates/header.php');
if(!isset($_SESSION['username'])) die('username not set');
if ($_SESSION['csrf'] !== $_POST['csrf']) {
  die('-3');
}
if (isset($_SESSION['username']) && !isset($_GET['username'])){
  include_once('templates/edit_profile.php');
}
else if (isset($_GET['username'])){
  include_once("templates/display_profile.php");
}
include_once('templates/footer.php');
?>
