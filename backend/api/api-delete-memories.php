<?php

require_once __DIR__.'/connect.php';

session_start();

if( !isset ($_SESSION['userID']) ){
  sendResponse(0, __LINE__, 'You must login to use this api.');
}

$id = $_POST['memoryID'];
if( empty($id ) ){
  sendResponse(0, __LINE__, 'Friend ID is missing, we couldnt delete the memory.');
}

try{
  $stmt = $db->prepare('DELETE FROM friends_memories WHERE id=:memoryID');
  $stmt->bindValue(':memoryID', $id);

  $stmt->execute();

  if( $stmt->rowCount() == 0 ){
    sendResponse(1, __LINE__, 'Sorry the memories couldnt be deleted');
  }

  sendResponse(1, __LINE__, 'Successfully deleted memory from the database');

}catch(PDOException $ex){
  echo $ex;
}

//**************************************************
function sendResponse($bStatus, $iLineNumber, $message, $data='{}'){
  echo '{"status": '.$bStatus.', "code": '.$iLineNumber.', "message":"'.$message.'", "data":'.$data.'}';
  exit;
}
