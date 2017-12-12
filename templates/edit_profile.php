<?php
if (!isset($_SESSION['username'])) die('No username');
$userId = getUserId($dbh,$_SESSION['username']);
$username =$_SESSION['username'];
$imageName= getImageFromUser($dbh,$userId);
?>
<div class="container">
			<div class="profile-sidebar">
				<div class="profile-userpic">
				<img src=<?="assets/users/originals/$imageName.jpg"?> class="img-responsive" alt="">
				</div>
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
