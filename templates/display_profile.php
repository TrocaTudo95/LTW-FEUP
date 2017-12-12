<?php
include_once('database/connection.php');
include_once('database/users.php');
include_once('templates/header.php');
$userId = getUserId($dbh,$_GET['username']);
$username =$_GET['username'];
$imageName= getImageFromUser($dbh,$userId);
?>
<link rel="stylesheet" href="css/profile_style.css">
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

<?php include_once ('templates/footer.php'); ?>
