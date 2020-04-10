<?php
include('db.php');
function arraytoarray($item_name){
$a = array();
foreach($item_name as $cur)
{
 array_push($a,$cur);
}
return $a;
}



/*********************************************************************************************/
/********************************************************************************************
										company profile
/*********************************************************************************************/
/*********************************************************************************************/
if(isset($_POST['entry_type']) && $_POST['entry_type'] =='company profile'){

$company_name = $_POST['company_name'];
$address = $_POST['address'];
$city = $_POST['city'];
$state = $_POST['state'];
$country = $_POST['country'];
$phone = $_POST['phone'];
$mobile = $_POST['mobile'];
$fax = $_POST['fax'];
$email = $_POST['email'];
$website = $_POST['website'];
$tax_number = $_POST['tax_number'];
$document_formate = $_POST['document_formate'];
$account_currenccy = $_POST['account_currenccy'];
$default_location = $_POST['default_location'];
$auto_nmbering = $_POST['auto_nmbering'];



$result="UPDATE  `company` SET  `company_name` =  '$company_name',`address` =  '$address',`city` =  '$city',`state` =  '$state',`country` =  '$country',`phone` =  '$phone',`mobile` =  '$mobile',`fax` =  '$fax',`email` =  '$email',`website` =  '$website',`tax_number` =  '$tax_number',`document_formate` =  '$document_formate',`account_currenccy` =  '$account_currenccy',`default_location` =  '$default_location',`auto_nmbering` =  '$auto_nmbering' WHERE  `email` = '$company_email'";

$new = $conn->query($result) or die (mysqli_error());	



//////////////////////////////////////////////////////////////////////////////////////////
if(isset($_FILES["file"]["name"])){
$target_dir = "emoji".$name.'/';
echo $target_file = $target_dir.basename($_FILES["file"]["name"]);
if (!file_exists('/'.$target_dir)) {
mkdir('./'.$target_dir, 0777, true);
move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
} else {
move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
}
$fname = $target_file;
echo $sqlz="UPDATE `company` SET `img_url` = '$fname' WHERE `email` = '$company_email'";
$conn->query($sqlz);
}
//////////////////////////////////////////////////////////////////////////////////////////
} 

/*********************************************************************************************/
/*********************************************************************************************
										create user
/*********************************************************************************************/
/*********************************************************************************************/
if(isset($_POST['entry_type']) && $_POST['entry_type'] =='create user'){

$user_name = $_POST['user_name'];
$email = $_POST['email'];
$password = $_POST['password'];
$active = $_POST['active'];
$access_level = $_POST['access_level'];

$date_time = time();
$result="INSERT INTO `user` (`user_name`, `email`, `password`, `active`, `access_level`, `company_email`) VALUES ('$user_name', '$email', '$password', '$active', '$access_level', '$company_email')";
echo "<script>alert(".$email.");</script>";

$new = $conn->query($result) or die (mysqli_error());	

}


/*********************************************************************************************/

?>
