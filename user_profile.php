<?php
include_once('database/connection.php');
include_once('database/users.php');
session_start();
if (!isset($_SESSION['username'])) die('No username');
$userId = getUserId($dbh,$_SESSION['username']);
$username =$_SESSION['username'];
$imageName= getImageFromUser($dbh,$userId);
?>
<html>
<link rel="stylesheet" href="css/profile_style.css">
<div class="container">
    <div class="row profile">
		<div class="col-md-3">
			<div class="profile-sidebar">
				<!-- SIDEBAR USERPIC -->
				<div class="profile-userpic">
				<img src=<?="assets/users/originals/$imageName.jpg"?> class="img-responsive" alt="">
				</div>

				<!-- END SIDEBAR USERPIC -->
				<!-- SIDEBAR USER TITLE -->
				<div class="profile-usertitle">
            <?php echo $username;?>
					<div class="profile-usertitle-name">
					</div>
				</div>

        <nav>
      <form action="upload_image.php" method="post" enctype="multipart/form-data">
        <label>Choose a file to upload:
        <input type="text" name="username" style="display: none" value=<?=$username?>>
      </label>
        <input type="file" name="image" required>
        <input type="submit" value="Upload">
      </form>
    </nav>
				<!-- END SIDEBAR BUTTONS -->
				<!-- SIDEBAR MENU -->
				<div class="profile-usermenu">
					<ul class="nav">
						<li class="active">
							<a href="#">
							<i class="glyphicon glyphicon-home"></i>
							Overview </a>
						</li>
						<li>
							<a href="#">
							<i class="glyphicon glyphicon-user"></i>
							Account Settings </a>
						</li>
						<li>
							<a href="#" target="_blank">
							<i class="glyphicon glyphicon-ok"></i>
							Tasks </a>
						</li>
						<li>
							<a href="#">
							<i class="glyphicon glyphicon-flag"></i>
							Help </a>
						</li>
					</ul>
				</div>
				<!-- END MENU -->
			</div>
		</div>
		<div class="col-md-9">
            <div class="profile-content">
			   Some user related content goes here...
            </div>
		</div>
	</div>
</div>
</html>
