<?php
  $db = new PDO('sqlite:to_do_list.db');
  $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

 ?>
