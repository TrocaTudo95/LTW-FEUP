<?php
    session_start();  
    if (!isset($_SESSION['username'])) die('No username');
    if (!isset($_GET['title'])) die('No title');
    if (!isset($_GET['category'])) die('No category');
    if (!isset($_GET['color'])) die('No color');
    if (!isset($_GET['items'])) die('No items - can not create empty todo list');
    include_once('database/connection.php'); // connects to the database
    include_once('database/users.php');
    include_once('database/lists.php');
    print_r($_GET['items']);
    $userId = getUserId($dbh,$_SESSION['username']);
    $categoryId = addCategory($dbh,$_GET['category'],$userId);
    $todo_list_Id = addToDoList($dbh,$_GET['title'],$_GET['color'],$userId,$categoryId);
    $items = explode(',',$_GET['items']);
    addListItems($dbh,$items,$todo_list_Id);
?>