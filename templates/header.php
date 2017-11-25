<!DOCTYPE html>
<html>
  <head>
    <title>QuickBuddy</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/layout.css">
    <script src="script.js" defer></script>
  </head>
  <body>
    <header>
      <h1><a href="index.php">Quick Buddy</a></h1>
      <?php
      if(isset($_SESSION['is_logged']) && $_SESSION['is_logged'] == true){
        echo($_SESSION['username']);?>
        <a href="action_logout.php">Logout</a>
      <?php }else{
        ?>
        <div id="login">
        <form action="action_login.php" method="post">

          <input type="text" name="username" required="required" placeholder="Username">
          <input type="password" name="password" required="required" placeholder="Password">
          <input type="submit" value="Login">
        </form>
        </div>
        <a href="templates/register_form.php">Register</a>
      <?php } ?>
      
    </header>
