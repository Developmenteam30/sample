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


/*********************************************************************************************/
/*********************************************************************************************
										create vat return
*********************************************************************************************/
/*********************************************************************************************/
$start_date = $_POST['start_date'];
$transaction_start_date = $_POST['transaction_start_date'];
$authority = $_POST['authority'];
$end_date = $_POST['end_date'];
$payment = $_POST['payment'];
$account = $_POST['account'];
$vat_note = $_POST['vat_note'];
$total = $_POST['total'];

$discription = json_decode($_POST['discription']);
$s_date = json_decode($_POST['s_date']);
$e_date = json_decode($_POST['e_date']);
$filling_due_date = json_decode($_POST['filling_due_date']);
$payment_due_date = json_decode($_POST['payment_due_date']);
$amount = json_decode($_POST['amount']);



$sql="INSERT INTO `vat_return` ( `start_date`, `transaction_start_date`, `authority`, `end_date`, `payment`, `account`, `vat_note`, `total`, `company_email`) VALUES ( '$start_date', '$transaction_start_date', '$authority', '$end_date', '$payment', '$account', '$vat_note', '$total', '$company_email')";


if (mysqli_query($conn, $sql)) {
$last_id = mysqli_insert_id($conn);



//////////////////////////////////////////////////////////////////////////////////////////
$condition = basename($_FILES["file"]["name"]);
if(isset($condition)){
$target_dir = "emoji/".$name.'/';
$target_file = $target_dir.$last_id. basename($_FILES["file"]["name"]);
if (!file_exists('/'.$target_dir)) {
mkdir('./'.$target_dir, 0777, true);
move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
} else {
move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
}
$fname = $target_file;
$sqlz="UPDATE `vat_return` SET `file_url` = '$fname' WHERE `id` = '$last_id'";
$conn->query($sqlz);
}
//////////////////////////////////////////////////////////////////////////////////////////

echo $check_size = sizeof($discription);
for($i = 0; $i < $check_size; $i++ ){
if ($discription[$i] != '') {
echo $discriptions = $discription[$i];
$s_dates = $s_date[$i];
$e_dates = $e_date[$i];
$filling_due_dates = $filling_due_date[$i];
$payment_due_dates = $payment_due_date[$i];
$amounts = $amount[$i];

$sqli="INSERT INTO `vat_return_items` (`account`, `discription`, `s_date`, `e_date`, `filling_due_date`, `payment_due_date`, `amount`, `vat_return_id`, `company_email`) VALUES ('$account', '$discriptions', '$s_dates', '$e_dates', '$filling_due_dates', '$payment_due_dates', '$amounts', '$last_id', '$company_email')";

$conn->query($sqli) ;
//echo "done";
}
}

} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

