<!DOCTYPE html>
<html>
    <head>
        <title>QuickBuddy</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/reset.css">
        <link rel="stylesheet" href="../css/login_style.css">
        <link rel="stylesheet" href="../css/login_layout.css">
        <script src="../scripts/login_script.js" defer></script>
    </head>
    <body>
        <header>
            <a href="../index.php"><img src="../assets/logo.png" width="177px" height="106px"></a>
        </header>
        <section id="login_box">
            <nav id="login_nav">
                <ul id="tabs">
                    <li id="login_tab">Login</li>
                    <li id="sign_in_tab">Sign In</li>
                </ul>
            </nav>
            <form id="login_form" action="../action_login.php" method="post">
                <input type="text" name="username" required="required" placeholder="Username *">
                <input type="password" name="password" required="required" placeholder="Password *">
                <input type="submit" value="Login">
            </form>
            <form id="register_form" action="../action_register.php" method="post">
                <input type="text" name="username" required="required" placeholder="Username *">
                <input type="email" name="email" required="required" placeholder="Email *">
                <input type="password" name="password" required="required" placeholder="Password *">
                <input type="submit" value="Sign In">
            </form>
        </section>
    </body>