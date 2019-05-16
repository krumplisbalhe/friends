<?php

require_once __DIR__.'/connect.php';

session_start();

if( !isset ($_SESSION['userID'])){
  sendResponse(0, __LINE__, 'You must login to use this api.');
}

$userID = $_SESSION['userID'];

$friendID = $_POST['friendID'];
if( empty($friendID) ){
  sendResponse(0, __LINE__, 'Friend ID is missing, we couldnt update the data.');
}

//VALIDATE FIRST NAME
$firstName = $_POST['firstName'] ?? '';
if( strlen($firstName) > 20 ){
  sendResponse(0, __LINE__, 'Name has to be max 20 characters');
}

//VALIDATE LAST NAME
$lastName = $_POST['lastName'] ?? '';
if( strlen($lastName) > 50 ){
  sendResponse(0, __LINE__, 'Last name has to be max 50 characters');
}

//VALIDATE EMAIL
$email = $_POST['email'] ?? '';

//BIRTHDAY
$birthday = $_POST['birthday'] ?? '';

//ADDRESS
$address = $_POST['address'] ?? '';

//PHONE NUMBER/S
$phoneNumber = $_POST['phoneNumber'] ?? '';
if( strlen($phoneNumber) > 15 ){
  sendResponse(0, __LINE__, 'Phone number has to be max 15 characters');
}

//WORKPLACE
$workplace = $_POST['workplace'] ?? '';
if( strlen($phoneNumber) > 50 ){
  sendResponse(0, __LINE__, 'Workplace has to be max 50 characters');
}

//CATEGORY
$category = $_POST['category'] ?? 1;


  $stmt = $db->prepare('SELECT * FROM friends WHERE id = :friendID');
  $stmt->bindValue(':friendID', $friendID);

try{
  $stmt = $db->prepare('UPDATE friends SET category_fk = :category, first_name = :firstName, last_name = :lastName, birthdate = :birthday, phone_number = :phoneNumber, workplace = :workplace, email = :email, address=:friendAddress WHERE id = :friendID');
  $stmt->bindValue(':friendID', $friendID);
  $stmt->bindValue(':category', $category);
  $stmt->bindValue(':firstName', $firstName);
  $stmt->bindValue(':lastName', $lastName);
  $stmt->bindValue(':birthday', $birthday);
  $stmt->bindValue(':phoneNumber', $phoneNumber);
  $stmt->bindValue(':workplace', $workplace);
  $stmt->bindValue(':email', $email);
  $stmt->bindValue(':friendAddress', $address);

  $stmt->execute();

  sendResponse(1, __LINE__, 'Successfully updated the friends data in the database');

}catch(PDOException $ex){
  echo $ex;
}

//**************************************************
function sendResponse($bStatus, $iLineNumber, $message, $data='{}'){
  echo '{"status": '.$bStatus.', "code": '.$iLineNumber.', "message":"'.$message.'", "data":'.$data.'}';
  exit;
}
