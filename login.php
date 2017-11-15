<!DOCTYPE html>
<html lang="en-US">
  <head>
    <title>LTo-Do-List</title>
  </head>
  <body>
    <header>
      <h1><a href="login.php">LTo-Do-List</a></h1>
      <h2>More than a To-Do-List</h2>
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
      <div id="register">
        <a href="register.php">Register</a>
      </div>
    </header>
  </body>
</html>
