<?php
include('db.php');
//if(isset($_POST['submit'])){
function arraytoarray($item_name){
$a = array();
foreach($item_name as $cur)
{
 array_push($a,$cur);
}
return $a;
}




$user_name = $_POST['user_name'];
$email = $_POST['email'];
$address = $_POST['address'];
$pincode = $_POST['pincode'];
$city = $_POST['city'];
$state = $_POST['state'];
$country = $_POST['country'];
$phone1 = $_POST['phone1'];
$phone2 = $_POST['phone2'];
$active = $_POST['active'];
$access_level = $_POST['access_level'];

$date_time=time();
$sql="UPDATE  `user` SET  `user_name` =  '$user_name',`address` =  '$address',`pincode` =  '$pincode',`city` =  '$city',`state` =  '$state',`country` =  '$country',`phone1` =  '$phone1',`phone2` =  '$phone2',`active` =  '$active',`access_level` =  '$access_level'  WHERE  `email` = '$email'";
$conn->query($sql) or die(mysqli_error()) ;
echo "User edited successfully";




?>