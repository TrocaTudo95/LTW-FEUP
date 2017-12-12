<?php
include_once('database/connection.php');
include_once('database/users.php');
include_once('templates/header.php');
session_start();
if (!isset($_SESSION['username'])) die('No username');
$userId = getUserId($dbh,$_SESSION['username']);
$username =$_SESSION['username'];
$imageName= getImageFromUser($dbh,$userId);
?>
<link rel="stylesheet" href="css/profile_style.css">
<div class="container">
			<div class="profile-sidebar">
				<!-- SIDEBAR USERPIC -->
				<div class="profile-userpic">
				<img src=<?="assets/users/originals/$imageName.jpg"?> class="img-responsive" alt="">
				</div>

				<!-- END SIDEBAR USERPIC -->
				<!-- SIDEBAR USER TITLE -->
				<div class="profile-usertitle">
            <?php echo $username;?>
				</div>

        <form class="centered_form"  action="action_change_password.php">
        Change Password:
        <input type="password" name="pass" value="">
        <input type="submit" class="profile_button" value="Change">
        </form>
        <nav>
      <form class="centered_form" action="upload_image.php" method="post" enctype="multipart/form-data">
        <label >Change profile picture:
        <input type="text" name="username" style="display: none" value=<?=$username?>>
      </label>
        <input type="file" name="image" required>
        <input type="submit" class="profile_button" value="Upload">
      </form>
    </nav>


				<!-- END SIDEBAR BUTTONS -->
				<!-- SIDEBAR MENU -->

				<!-- END MENU -->
			</div>

</div>

<?php include_once ('templates/footer.php'); ?>
