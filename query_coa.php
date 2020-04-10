<?php
include("db.php");
$i = '0';
error_reporting(1);
$result = '';

$sql = "SELECT * FROM `coa`";
$new = $conn->query($sql);
while($row = $new->fetch_assoc()){
$result[$i] = $row;
$group = $row['group'];
$j = '0';

if(isset($_GET['filter'])){
	$filter = $_GET['filter'];
$sqli = "SELECT * FROM `coa_list` WHERE `group` = '$group' AND `company_email` = '$company_email' ORDER BY `$filter` ASC";

}else{
$sqli = "SELECT * FROM `coa_list` WHERE `group` = '$group' AND `company_email` = '$company_email' ORDER BY `code` ASC";
}
$news = $conn->query($sqli);
while($rows = $news->fetch_assoc()){
$result[$i]['data'][$j] = $rows;
$j++;
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
