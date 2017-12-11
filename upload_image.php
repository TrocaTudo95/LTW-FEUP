<?php
  include_once("database/connection.php");
  include_once("database/users.php");

  // Insert image data into database
    if (!isset($_POST['username'])) die('No username');
    session_start();

  $userId = getUserId($dbh,$_SESSION['username']);
  $stmt = $dbh->prepare("UPDATE users SET imageRef=? WHERE id=?");
  $stmt->execute(array($userId,$userId));
  $prev_image = getImageFromUser($dbh,$userId);
  if($prev_image!=0)
      unlink("assets/users/originals/$prev_image.jpg");

  // Get image ID

  // Generate filenames for original, small and medium files
  $originalFileName = "assets/users/originals/$userId.jpg";
  $smallFileName = "assets/users/thumbs_small/$userId.jpg";
  $mediumFileName = "assets/users/thumbs_medium/$userId.jpg";

  // Move the uploaded file to its final destination
  move_uploaded_file($_FILES['image']['tmp_name'], $originalFileName);

  // Crete an image representation of the original image
  $original = imagecreatefromjpeg($originalFileName);

  $width = imagesx($original);     // width of the original image
  $height = imagesy($original);    // height of the original image
  $square = min($width, $height);  // size length of the maximum square

  // Create and save a small square thumbnail
  $small = imagecreatetruecolor(200, 200);
  imagecopyresized($small, $original, 0, 0, ($width>$square)?($width-$square)/2:0, ($height>$square)?($height-$square)/2:0, 200, 200, $square, $square);
  imagejpeg($small, $smallFileName);

  // Calculate width and height of medium sized image (max width: 400)
  $mediumwidth = $width;
  $mediumheight = $height;
  if ($mediumwidth > 400) {
    $mediumwidth = 400;
    $mediumheight = $mediumheight * ( $mediumwidth / $width );
  }

  // Create and save a medium image
  $medium = imagecreatetruecolor($mediumwidth, $mediumheight);
  imagecopyresized($medium, $original, 0, 0, 0, 0, $mediumwidth, $mediumheight, $width, $height);
  imagejpeg($medium, $mediumFileName);

  header("Location: index.php");
?>
