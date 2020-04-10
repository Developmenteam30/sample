<?php
include("db.php");
$i = '0';
error_reporting(1);
$result = '';

if(isset($_GET['filter'])){
	$filter = $_GET['filter'];
$sql = "SELECT * FROM `journal` WHERE  `company_email` = '$company_email' AND  `transaction_id` =  '0' ORDER BY `$filter` ASC";

}else{
$sql = "SELECT * FROM `journal` WHERE `company_email` = '$company_email' AND  `transaction_id` =  '0' ORDER BY `id` DESC";
}

$new = $conn->query($sql);
while($row = $new->fetch_assoc()){
$row['date'] = date('d-m-Y' , strtotime($row['date']));
$result[$i] = $row;
$a_id = $row['account'];
$sqls = "SELECT * FROM `coa_list` WHERE `id` = '$a_id'";
$news = $conn->query($sqls);
while($rows = $news->fetch_assoc()){
$result[$i]['account_name'] = $rows['code'].' '.$rows['accounts_name'];
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
