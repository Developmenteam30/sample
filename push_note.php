<?php
include('db.php');
$sql = $conn->query("SELECT * FROM `push_note` ORDER BY `id` DESC LIMIT 1");
$row = $sql->fetch_assoc();
$auth = $row['auth'];
define('API_ACCESS_KEY', 'AAAAK3NrYXM:APA91bF0okxIMbjeFmwYzFUX5iRTxzrB-WmVGOtBgSHnJeFJyvqYmnGAEQY5ldEONrimFd2z6JQDopPivAoDhZ0ykzbXpm3sGxlWUiVPYeCFYOgimgN6UAHktXIsn1RVZcmNpgp_lTD0');
$registrationids = array($auth);
$msg = array(
'massage' => 'here is a massage',
'title'   => 'this is title. title',
'subtitle'=> 'subtitle',
'tickerText'=> 'ti8cker text',
'vibrate' => 1,
'sound'   => 1 );
$fields = array(
'registration_ids' => $registrationids,
'data' => $msg );
$headers = array(
'Authorization: key='.API_ACCESS_KEY,
'Content-Type: application/json' );
$ch = curl_init();
curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
curl_setopt( $ch,CURLOPT_POST, true );
curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
curl_setopt( $ch,CURLTOPT_RETURNTRANSFER, true );
curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ));
$result = curl_exec( $ch );
echo $result;
?>