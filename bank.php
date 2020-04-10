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
                    Create payment Voucher
*********************************************************************************************/
/*********************************************************************************************/
if(isset($_POST['entry_type']) && $_POST['entry_type'] =='Create payment Voucher'){
$bank_id = $_POST['bank_id'];
$disc_amount = $_POST['disc_amount'];
$notes = $_POST['notes'];
$date = $_POST['date'];
$date = date('Y-m-d', strtotime($date));
$transaction_number = $_POST['transaction_number'];
$due_date = $_POST['due_date'];
$due_date = date('Y-m-d', strtotime($due_date));
$cheque_no = $_POST['cheque_no'];
$bank_account = json_decode($_POST['bank_account']);
$bank_accounts =  arraytoarray($bank_account);
$sqli = "SELECT * FROM `bank` WHERE `id`='$bank_id'";
$new = $conn->query($sqli);
while ($row  = $new->fetch_assoc()) {
	$name = $row['name'];
}
$check_size = sizeof($bank_account);
$total_vat_amount = '0';
for($i = 0; $i < $check_size; $i++ ){
	$item_row = (array)$bank_accounts[$i];
	if ($item_row['id'] != '') {
		$vat = $item_row['vat'];
		$amount = $item_row['amount'];
		$vat_amount = ($amount*$vat)/100;
		$total_vat_amount += $vat_amount;
	}
}
$newing = $conn->query("SELECT COUNT(*) AS `count` FROM `transaction` WHERE `transaction_number` = '$transaction_number' AND `entry_type` = 'Create payment Voucher' AND `company_email` = '$company_email'");
$rowing = $newing->fetch_assoc();
if($rowing['count'] == '0'){
$sql="INSERT INTO `transaction` (`entry_type`, `cat_type`, `name`, `bank_id`, `vat`, `total`, `notes`, `date`, `transaction_number`, `due_date`, `cheque_no`, `company_email`) VALUES ('Create payment Voucher', 'payment Voucher', '$name', '$bank_id', '$total_vat_amount', '$disc_amount', '$notes', '$date', '$transaction_number', '$due_date', '$cheque_no', '$company_email')";

if (mysqli_query($conn, $sql)) {
	  echo  $last_id = mysqli_insert_id($conn);

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
	$sqlz="UPDATE `transaction` SET `file_url` = '$fname' WHERE `id` = '$last_id'";
	$conn->query($sqlz);
	}
	//////////////////////////////////////////////////////////////////////////////////////////

	for($i = 0; $i < $check_size; $i++ ){
		$item_row = (array)$bank_accounts[$i];
		if ($item_row['id'] != '') {
			$bank_account = $item_row['id'];
			$vat = $item_row['vat'];
			$vat_id = $item_row['vat_id'];
			$amount = $item_row['amount'];
			$memo = $item_row['memo'];
			$vat_amount = ($amount*$vat)/100;
			$sql10="SELECT * FROM `vat` WHERE `id` = '$vat_id' AND `company_email` = '$company_email' AND `category` = 'purchase' LIMIT 1";
			$new10=$conn->query($sql10);
			$row10 = $new10->fetch_assoc();
			$vat_account = $row10['account'];
			$sqli="INSERT INTO `bank_payment` (`bank_account`, `vat`, `vat_id`, `vat_account`, `vat_amount`, `amount`, `memo`, `transaction_id`, `company_email`) VALUES ('$bank_account', '$vat', '$vat_id', '$vat_account', '$vat_amount', '$amount', '$memo', '$last_id', '$company_email')";
			$conn->query($sqli) or die(mysql_error()) ;
		}
	}
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
}
}

/*********************************************************************************************/
/*********************************************************************************************
                    create receipt voucher
*********************************************************************************************/
/*********************************************************************************************/
if(isset($_POST['entry_type']) && $_POST['entry_type'] =='create receipt voucher'){

$bank_id = $_POST['bank_id'];
$disc_amount = $_POST['disc_amount'];
$notes = $_POST['notes'];
$date = $_POST['date'];
$date = date('Y-m-d', strtotime($date));

$transaction_number = $_POST['transaction_number'];
$due_date = $_POST['due_date'];
$due_date = date('Y-m-d', strtotime($due_date));
$cheque_no = $_POST['cheque_no'];

$bank_account = json_decode($_POST['bank_account']);
$bank_accounts =  arraytoarray($bank_account);


$sqli = "SELECT * FROM `bank` WHERE `id`='$bank_id'";
$new = $conn->query($sqli);
while ($row  = $new->fetch_assoc()) {
	$name = $row['name'];
}

 $check_size = sizeof($bank_account);
$total_vat_amount = '0';
for($i = 0; $i < $check_size; $i++ ){
$item_row = (array)$bank_accounts[$i];
if ($item_row['id'] != '') {
$vat = $item_row['vat'];
$amount = $item_row['amount'];
$vat_amount = ($amount*$vat)/100;
$total_vat_amount += $vat_amount;
}
}
$newing = $conn->query("SELECT COUNT(*) AS `count` FROM `transaction` WHERE `transaction_number` = '$transaction_number' AND `entry_type` = 'create receipt voucher' AND `company_email` = '$company_email'");
$rowing = $newing->fetch_assoc();
if($rowing['count'] == '0'){
$sql="INSERT INTO `transaction` (`entry_type`, `cat_type`, `name`, `bank_id`, `vat`, `total`, `notes`, `date`, `transaction_number`, `due_date`, `cheque_no`, `company_email`) VALUES ('create receipt voucher', 'receipt voucher', '$name', '$bank_id', '$total_vat_amount', '$disc_amount', '$notes', '$date', '$transaction_number', '$due_date', '$cheque_no', '$company_email')";
if (mysqli_query($conn, $sql)) {
	echo  $last_id = mysqli_insert_id($conn);
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
	$sqlz="UPDATE `transaction` SET `file_url` = '$fname' WHERE `id` = '$last_id'";
	$conn->query($sqlz);
	}
	//////////////////////////////////////////////////////////////////////////////////////////

	$check_size = sizeof($bank_account);
	for($i = 0; $i < $check_size; $i++ ){
		$item_row = (array)$bank_accounts[$i];
		if ($item_row['id'] != '') {
			$bank_account = $item_row['id'];
			$vat = $item_row['vat'];
			$vat_id = $item_row['vat_id'];
			$amount = $item_row['amount'];
			$memo = $item_row['memo'];
			$vat_amount = ($amount*$vat)/100;
			$sql10="SELECT * FROM `vat` WHERE `id` = '$vat_id' AND `company_email` = '$company_email' AND `category` = 'sales' LIMIT 1";
			$new10=$conn->query($sql10);
			$row10 = $new10->fetch_assoc();
			$vat_account = $row10['account'];
			$sqli="INSERT INTO `bank_payment` (`bank_account`, `vat`, `vat_id`, `vat_account`, `vat_amount`, `amount`, `memo`, `transaction_id`, `company_email`) VALUES ('$bank_account', '$vat', '$vat_id', '$vat_account', '$vat_amount', '$amount', '$memo', '$last_id', '$company_email')";
			$conn->query($sqli) ;
		}
	}
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
}
}


/*********************************************************************************************/

?>