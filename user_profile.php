<?php
session_start();
include_once('database/connection.php');
include_once('database/users.php');
include_once('templates/header.php');
if(!isset($_GET['username'])) die('username not set');
if (isset($_SESSION['username']) && !isset($_GET['username'])){
  include_once('templates/edit_profile.php');
}
else if (isset($_GET['username'])){
  include_once("templates/display_profile.php");
}
include_once('templates/footer.php');
?>
