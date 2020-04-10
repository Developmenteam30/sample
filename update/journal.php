<?php
include('../db.php');
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
$journal = json_decode($_POST['journal']);
$journal = (array) $journal;
$dabit_total = $_POST['dabit_total'];
$credit_total = $_POST['credit_total'];
$data = (array) $journal['0'];
$date = $data['date'];
$date = date('Y-m-d', strtotime($date));
$number = $data['number'];
$trans_id = $_POST['trans_id'];
	$sqls="UPDATE `transaction` SET `total` = '$dabit_total', `date` = '$date', `transaction_number` = '$number' WHERE '$company_email' = `company_email` AND `id` = '$trans_id' AND `name_id` = '0' AND `name` = ''";

	if (mysqli_query($conn, $sqls)) {
		foreach ($journal as $key) {
		$item_row = (array)$key;
		$id = $item_row['id'];
		$account = $item_row['account'];
		$credit = $item_row['credit'];
		$debit = $item_row['debit'];
		$notes = $item_row['notes'];
		$sql="UPDATE  `journal` SET `date`='$date', `number`='$number', `account`='$account', `debit`='$debit', `credit`='$credit', `notes`='$notes', `dabit_total`='$dabit_total', `credit_total`='$credit_total' WHERE  `id` = '$id'";

		if (mysqli_query($conn, $sql)) {
		  echo  $last_id = $id;
		} else {
		    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}

		//////////////////////////////////////////////////////////////////////////////////////////
		$condition = basename($_FILES["file"]["name"]);
		if(isset($condition)){
		$target_dir = "emoji/".$last_id.'/';
		$target_file = $target_dir.$last_id. basename($_FILES["file"]["name"]);
		if (!file_exists('/'.$target_dir)) {
		mkdir('./'.$target_dir, 0777, true);
		move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
		} else {
		move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
		}
		$fname = $target_file;
		$sqlz="UPDATE `journal` SET `file` = '$fname' WHERE `id` = '$last_id'";
		$conn->query($sqlz);
 		}
		//////////////////////////////////////////////////////////////////////////////////////////

}

