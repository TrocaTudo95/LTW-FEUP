<?php
  $db = new PDO('sqlite:to_do_list.db');
  $stmt = $db->prepare('SELECT * FROM Category');
?>
