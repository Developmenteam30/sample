<?php
include("db.php");
$id = $_GET['id'];
error_reporting(1);
$result = '';
$end = $_REQUEST['end'];
$start = $_REQUEST['start'];

$sqli = "SELECT * FROM `coa_list` WHERE `id` = '$id' AND `company_email` = '$company_email'";
$news = $conn->query($sqli);
while($rows = $news->fetch_assoc()){
$result = $rows;
}
$result['trial_balance'] = file_get_contents("http://more-acc.com//account//upload//vaersion_two_trial_balance.php?id=".$id."&userid=".$company_email);
$result['ledger'] = file_get_contents("http://more-acc.com//account//upload//vaersion_two_ledger.php?start=".urlencode($start)."&end=".urlencode($end)."&id=".$id."&userid=".$company_email);
$result['journal'] = file_get_contents("http://more-acc.com//account//upload//vaersion_two_journal.php?start=".urlencode($start)."&end=".urlencode($end)."&id=".$id."&userid=".$company_email);

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
