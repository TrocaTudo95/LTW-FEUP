<!DOCTYPE html>
<html>
  <head>
    <title>WebTask</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/font-awesome.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/layout.css">
    <link rel="stylesheet" href="css/profile_style.css">
    <script src="scripts/script.js" defer></script>
    <script src="scripts/next_tasks.js" defer></script>
  </head>
  <body>
    <header>
      <a id="logo_link" href="index.php"><img src="assets/logo.png" width="177px" height="106px"></a>
      

      <?php
      if(isset($_SESSION['is_logged']) && $_SESSION['is_logged'] == true){
        echo("<section class= 'dropdown' id='login'>");
        echo("<button class='dropbtn'>" . $_SESSION['username'] . "</button>");
        ?>
          <div class="dropdown-content">
            <a href="user_profile.php">Account</a>
            <a href="action_logout.php">Logout</a>
          </div>
        </section>
      <?php }else{
        ?>
        <section id="login">
          <a href="templates/login.php">Login / Register<i class="fa fa-sign-in" aria-hidden="true"></i></a>
        </section>
      <?php } ?>

    </header>
