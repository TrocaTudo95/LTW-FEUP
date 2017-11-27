<!DOCTYPE html>
<html>
  <head>
    <title>QuickBuddy</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/layout.css">
    <script src="scripts/script.js" defer></script>
  </head>
  <body>
    <header>
      <a href="index.php"><img src="assets/logo.png" width="177px" height="106px"></a>
      <?php
      if(isset($_SESSION['is_logged']) && $_SESSION['is_logged'] == true){
        echo($_SESSION['username']);?>
        <a href="action_logout.php">Logout</a>
      <?php }else{
        ?>
        <section id="login_or_sign_in">
          <a href="templates/login.php">Login / Sign In<img src="assets/30_30_login.png" width="30px" height="30px"></a>
        </section>
      <?php } ?>
      
    </header>
