<?php
session_start();
if(!isset($_SESSION['username'])) die('Login required');
if(!isset($_GET['project_title'])) die('Project title undefined');
if(!isset($_GET['project_category'])) die('Project category undefined');
include_once("database/connection.php");
include_once("database/users.php");
include_once("database/projects.php");

$title = $_GET['project_title'];
$category = $_GET['project_category'];
$title_length = strlen($title);
$category_length = strlen($category);
if ($title_length == 0 || $title_length > 140){
    die('Incorrect title');
}
if ($category_length == 0 || $category_length > 140){
    die('Incorrect category');
}
$default_color = "#333";
$user_id = getUserId($dbh,$_SESSION['username']);
$category_id = addCategory($dbh,$_GET['project_category']);
$project_id = addProject($dbh,$title,$default_color,$user_id,$category_id);
echo json_encode($project_id);
?>
