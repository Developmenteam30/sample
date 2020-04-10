<?php
include("../db.php");
$i = '0';
error_reporting(1);
$id = $_GET['id'];
$result = '';
$sql = "DELETE FROM `emojis` WHERE `id`='$id'";
$new = $conn->query($sql);
if($new){
$response = "Content deleted successfully";
}else{
$response = "Cannot delete please try again later";
}


// Collect what you need in the $data variable.
// headers for not caching the results
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');

// headers to tell that result is JSON
header('Content-type: application/json');

// send the result now
echo json_encode($response);

?>