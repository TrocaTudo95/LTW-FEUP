<?php
  try {
     $dbh = new PDO('sqlite:C:\xampp\htdocs\LTW-FEUP\webtask.db');
     $dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
     $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch (PDOException $e) {
     die($e->getMessage());
  }
?>
