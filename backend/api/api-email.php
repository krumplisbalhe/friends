<?php
require_once __DIR__.'/connect.php';

$stmt = $db->prepare('SELECT friends.id, friends.first_name, friends.last_name, users.id, users.first_name AS "userName", users.email, friends_stay_in_touch.frequency_fk, friends_stay_in_touch.timestamp FROM friends JOIN users ON friends.user_fk = users.id JOIN friends_stay_in_touch ON friends.id=friends_stay_in_touch.friend_fk');
$stmt->execute();
$friends = $stmt->fetchAll();

foreach($friends as $friend){
  $email=$friend['email'];
  $friendName=$friend['first_name'];
  $userName=$friend['userName'];
  $friendLastName=$friend['last_name'];
  $date=$friend['timestamp'];

  if( $friend['frequency_fk'] == 1){
  mail( $email, "FriendTimacy: Contact $friendName", "Hi $userName, This is just a friendly reminder to reach out to $friendName $friendLastName. You contact this friend on a daily basis, what an amazing bond you have! Have a great day!");
  }
  if( $friend['frequency_fk'] == 2 && date('N') == 2 ){
    mail( $email, "FriendTimacy: Contact $friendName", "Hi $userName, This is just a friendly reminder to reach out to $friendName $friendLastName. You contact this friend on a weekly basis, keep it healthy and happy! Have a great day!");
  }
  if( $friend['frequency_fk'] == 3 && date('Y-m-d') == date('Y-m-05') ){
    mail( $email, "FriendTimacy: Contact $friendName", "Hi $userName, This is just a friendly reminder to reach out to $friendName $friendLastName. You contact this friend on a monthly basis, it will be exciting to meet! Have a great day!");
  }
  if( $friend['frequency_fk'] == 4 && date('Y-m-d') == date('Y-06-01') ){
    mail( $email, "FriendTimacy: Contact $friendName", "Hi $userName, This is just a friendly reminder to reach out to $friendName $friendLastName. You contact this friend on a yearly basis, there must be a lot to catch up on! Have a great day!");
  }
}
