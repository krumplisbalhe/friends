<?php

require_once __DIR__.'/connect.php';

session_start();

if( !isset ($_SESSION['userID']) ){
  sendResponse(0, __LINE__, 'You must login to use this api.');
}

$date = $_POST['date'] ?? '';
$name = $_POST['name'] ?? '';
if( strlen($name) > 50 ){
  sendResponse(0, __LINE__, 'Title of the memory has to be max 50 characters, the data has not been saved, please try again.');
}

$friendID = $_POST['friendID'];
if( empty($friendID) ){
  sendResponse(0, __LINE__, 'Friend ID is missing, we couldnt add the memory.');
}

try{
  $stmt = $db->prepare('INSERT INTO friends_memories VALUES(null, :friendID, :memoryDate, :memoryName)');
  $stmt->bindValue(':memoryDate', $date);
  $stmt->bindValue(':memoryName', $name);
  $stmt->bindValue(':friendID', $friendID);

  $stmt->execute();

  if( $stmt->rowCount() == 0 ){
    sendResponse(0, __LINE__, 'Sorry, we couldnt add memory to the database');
  }

  sendResponse(1, __LINE__, 'Successfully added memory to the database');

}catch(PDOException $ex){
  echo $ex;
}

//**************************************************
function sendResponse($bStatus, $iLineNumber, $message, $data='{}'){
  echo '{"status": '.$bStatus.', "code": '.$iLineNumber.', "message":"'.$message.'", "data":'.$data.'}';
  exit;
}
