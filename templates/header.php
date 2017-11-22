<!DOCTYPE html>
<html>
  <head>
    <title>QuickBuddy</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
  </head>
  <body>
    <header>
      <h1><a href="index.php">Quick Buddy</a></h1>

      <div id="login">
        <form action="action_login.php" method="post">
        <fieldset>
          <legend>Login</legend>
          <p>Username</p>
          <input type="text" name="username" required="required">
          <p>Password</p>
          <input type="password" name="password" required="required">
        </fieldset>
        <input type="submit" value="Login">
      </form>
      </div>
      <a href="templates/register_form.php">Register</a>
    </header>
