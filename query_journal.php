<?php
include("db.php");
$i = '0';
error_reporting(1);
$result = array();
if(isset($_GET['id'])){
	$id = $_GET['id'];
	$sql = "SELECT * FROM `transaction` WHERE `id` =  '$id' AND  `company_email` = '$company_email'";
	$new = $conn->query($sql);
	while($row = $new->fetch_assoc()){
		$result = $row;
	}
	$sql = "SELECT * FROM `journal` WHERE `transaction_id` =  '$id' AND  `company_email` = '$company_email' ORDER BY `id` DESC";
}else{
	$sql = "SELECT * FROM `journal` WHERE  `company_email` = '$company_email' ORDER BY `id` DESC";
}
$result['journal'] = array();
$new = $conn->query($sql);
while($row = $new->fetch_assoc()){
$row['date'] = date('d-m-Y' , strtotime($row['date']));
$result['journal'][$i] = $row;
$a_id = $row['account'];
$sqls = "SELECT * FROM `coa_list` WHERE `id` = '$a_id'";
$news = $conn->query($sqls);
while($rows = $news->fetch_assoc()){
$result['journal'][$i]['account_name'] = $rows['code'].' '.$rows['accounts_name'];
}
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
