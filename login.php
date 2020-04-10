<?php
	include ('db_config.php');
/*
$cookie_name = "username";
$cookie_names = "member";
$cookie_na = "user";
$cookie_nam = "pass";
 if(isset($_COOKIE[$cookie_na])) {
$userss = $_COOKIE[$cookie_na];
$passss = $_COOKIE[$cookie_nam];
}
 if(isset($_COOKIE[$cookie_name])) {
$_SESSION['user'] = $_COOKIE[$cookie_name];
$_SESSION['mem'] = $_COOKIE[$cookie_names];
header("location: update.php");
}
*/
$user = $_REQUEST['email'];
$pass = md5($_REQUEST['password']); 
$sql = "select * from user where email='$user' and password='$pass'";
$new = $conn->query($sql);//run the query
if(mysqli_num_rows($new) > 0){
while($row = mysqli_fetch_assoc($new)){
$_SESSION['role'] = $row['access_level'];
$cookie_name = "username";
$cookie_value = $row['company_email'];
$_SESSION[$cookie_name] = $cookie_value;
if($row['first'] == '0'){
$_SESSION['first'] = 'yes';
$sql = "update user set first = '1' where email='$user'";
$conn->query($sql);
}
//$mem = $row['membership'];
//setcookie($cookie_name, $cookie_value, time() + ( 10 * 365 * 24 * 60 * 60));
//setcookie("member", $mem, time() + ( 10 * 365 * 24 * 60 * 60));
//$_SESSION['user'] = $user;
echo "success";
}
}else{
echo "failed.";
}
?>