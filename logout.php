<?php
include("db_config.php");
$cookie_name = "username";
$company_email = $_COOKIE[$cookie_name];
setcookie("username", "", time() - 3600);
$result = 'not';
$response = $result;
session_destroy();



// Collect what you need in the $data variable.
// headers for not caching the results
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');

// headers to tell that result is JSON
header('Content-type: application/json');

// send the result now
echo json_encode($response);

?>
