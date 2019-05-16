<?php

require_once __DIR__.'/connect.php';

session_start();

if( !isset ($_SESSION['userID']) ){
  sendResponse(0, __LINE__, 'You must login to use this api.');
}
$userID = $_SESSION['userID'];

//VALIDATE FIRST NAME
$firstName = $_POST['firstName'] ?? '';
if( strlen($firstName) > 20){
  sendResponse(0, __LINE__, 'First name has to be max 20 characters');
}

//VALIDATE LAST NAME
$lastName = $_POST['lastName'] ?? '';
if( strlen($lastName) > 50){
  sendResponse(0, __LINE__, 'Last name has to be max 50 characters');
}

//VALIDATE EMAIL
$email = $_POST['email'] ?? '';
if( strlen($email) > 50){
  sendResponse(0, __LINE__, 'Email has to be max 50 characters');
}

//BIRTHDAY
$birthday = $_POST['birthday'] ?? '';

//ADDRESS
$address = $_POST['address'] ?? '';
if( strlen($address) > 50 ){
  sendResponse(0, __LINE__, 'Address has to be max 50 characters');
}

//PHONE NUMBER
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
$category = $_POST['category'];

  $db->beginTransaction();
  $stmt = $db->prepare('INSERT INTO friends VALUES(null, :userID, :category, :firstName, :lastName, :birthday, :imageURL, :phoneNumber, :workplace, :email, :friendAddress, "" )');
  $stmt->bindValue(':userID', $userID);
  $stmt->bindValue(':category', $category);
  $stmt->bindValue(':firstName', $firstName);
  $stmt->bindValue(':lastName', $lastName);
  $stmt->bindValue(':birthday', $birthday);
  $stmt->bindValue(':imageURL', "");
  $stmt->bindValue(':phoneNumber', $phoneNumber);
  $stmt->bindValue(':workplace', $workplace);
  $stmt->bindValue(':email', $email);
  $stmt->bindValue(':friendAddress', $address);

  if( !$stmt->execute() ){
    sendResponse(0, __LINE__, 'Couldnt add user to the database');
    $db->rollBack();
    exit;
  }

  $friendID = $db->lastInsertId();
  $stmt = $db->prepare('INSERT INTO friends_stay_in_touch VALUES(:friendID, 5, null)');
  $stmt->bindValue(':friendID', $friendID);
  if( !$stmt->execute() ){
    sendResponse(0, __LINE__, 'Couldnt add user to the database, issue with stay-in-touch');
    $db->rollBack();
    exit;
  }

  $db->commit();

  sendResponse(1, __LINE__, 'Successfully added the friend to the database');

//**************************************************
function sendResponse($bStatus, $iLineNumber, $message, $data='{}'){
  echo '{"status": '.$bStatus.', "code": '.$iLineNumber.', "message":"'.$message.'", "data":'.$data.'}';
  exit;
}
