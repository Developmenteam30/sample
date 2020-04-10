<?php
include("db.php");
$i = '0';
error_reporting(1);
$result = '';

if(isset($_GET['id'])){
	$id = $_GET['id'];
	$type = $_GET['type'];
	if ($type == 'number') {
		$sql = "SELECT * FROM `transaction` WHERE `transaction_number` like '%$id%' AND `company_email` = '$company_email'";
	}elseif($type == 'date'){
		$sql = "SELECT * FROM `transaction` WHERE `date` like '%$id%' AND `company_email` = '$company_email'";
	}elseif($type == 'name'){
		$sql = "SELECT * FROM `transaction` WHERE `name` like '%$id%' AND `company_email` = '$company_email'";
	}elseif($type == 'amount'){
		$sql = "SELECT * FROM `transaction` WHERE `total` like '%$id%' AND `company_email` = '$company_email'";
	}

}
$new = $conn->query($sql);
while($row = $new->fetch_assoc()){
$result[$i] = $row;
$i++;
}
$response = $result;
//	print_r($row); 


// Collect what you need in the $data variable.
// headers for not caching the results
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');

// headers to tell that result is JSON
header('Content-type: application/json');

// send the result now
echo json_encode($response);

?>
