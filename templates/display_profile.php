<?php
$userId = getUserId($dbh,$_GET['username']);
$username = $_GET['username'];
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
			</div>

</div>
