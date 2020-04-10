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
if(isset($_POST['entry_type']) && $_POST['entry_type'] =='journal'){

$number = $_POST['number'];
$date = $_POST['date'];
$date = date('Y-m-d', strtotime($date));

$dabit_total = $_POST['dabit_total'];
$credit_total = $_POST['credit_total'];
  if($dabit_total == $credit_total){
	$sqls="INSERT INTO `transaction` (`entry_type`, `cat_type`, `total`, `date`, `company_email`, `transaction_number`) VALUES ('Journal', 'Journal', '$dabit_total', '$date', '$company_email', '$number')";

	if (mysqli_query($conn, $sqls)) {
	  echo  $last_ids = mysqli_insert_id($conn);
	  $data = json_decode($_POST['data']);
	  $datas =  arraytoarray($data);
	  foreach ($datas as $key) {
		$item_row = (array)$key;
		$account = $item_row['id'];
		$credit = $item_row['credit'];
		$debit = $item_row['debit'];
		$notes = $item_row['notes'];
		$sql="INSERT INTO `journal` (`date`, `number`, `account`, `debit`, `credit`, `notes`, `dabit_total`, `credit_total`, `type`, `company_email`, `transaction_id`) VALUES ('$date', '$number', '$account', '$debit', '$credit', '$notes', '$dabit_total', '$credit_total', 'Journal', '$company_email', '$last_ids')";

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
				$sqlz="UPDATE `journal` SET `file` = '$fname' WHERE `id` = '$last_id'";
				$conn->query($sqlz);
			}
			//////////////////////////////////////////////////////////////////////////////////////////

		} else {
		    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
	  }
	}
  }
}
