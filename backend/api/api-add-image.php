<?php

$target_dir = "../uploads/";
$file_name = uniqid().'.png';
$target_file = $target_dir.$file_name;

$friendID = $_POST['friendID'];

$errorChecker = 1;

$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if ($check !== false) {
      echo "File is an image - " . $check["mime"] . ".";
      $errorChecker = 1;
  } else {
      echo "File is not an image.";
      $errorChecker = 0;
  }
}
// Check if file already exists
if (file_exists($target_file)) {
  echo "Sorry, file already exists.";
  $errorChecker = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 5000000) {
  echo "Sorry, your file is too large.";
  $errorChecker = 0;
}
// Allow certain file formats
if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
  && $imageFileType != "gif") {
  echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
  $errorChecker = 0;
}
// Check if $errorChecker is set to 0 by an error
if ($errorChecker == 0) {
  echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    require_once __DIR__.'/connect.php';
    $stmt = $db->prepare('UPDATE friends SET image_url=:imgUrl WHERE id=:friendID');
    $stmt->bindValue(':friendID', $friendID);
    $stmt->bindValue(':imgUrl', $file_name);
    $stmt->execute();
    sendResponse(1, __LINE__, "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.", json_encode($file_name));
  } else {
    sendResponse(0, __LINE__, "Sorry, there was an error while uploading your file.");
  }
}

//**************************************************
function sendResponse($bStatus, $iLineNumber, $message, $data='{}'){
  echo '{"status": '.$bStatus.', "code": '.$iLineNumber.', "message":"'.$message.'", "data":'.$data.'}';
  exit;
}

?>
