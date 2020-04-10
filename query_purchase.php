<?php
include("db.php");
$email =  $company_email;
$i = '0';
error_reporting(1);
$result = '';

	$id = $_GET['id'];
$sql = "SELECT * FROM `purchase_item` WHERE `purchase_id` = '$id' ORDER BY `id` ASC";

$new = $conn->query($sql);
while($row = $new->fetch_assoc()){

$result[$i] = "<td class='JKSCOO-md-a JKSCOO-md-c JKSCOO-md-d' ><div style='outline-style:none;' data-row='0' data-column='0' __gwt_cell='cell-gwt-uid-1010'><select class='form-control table_input JKSCOO-qg-d' data-toggle='dropdown'  style='width: 100%;' ng-model='item_name[".$i."]'><option value='".$row['item_name']."'>".$row['item_name']."</option><option value='raghu'>Items</option>    </select>  </div>  </td> <td class='JKSCOO-md-a JKSCOO-md-c'>  <div style='outline-style:none;' data-row='0' data-column='2' __gwt_cell='cell-gwt-uid-1012'>    <textarea class='form-control table_input' ng-model='item_description[".$i."]' style='border-bottom:1px solid #ccc;height:33px' ng-init='item_description[".$i."]=".$row['item_description']."'>".$row['item_description']."</textarea> </div> </td> <td class='JKSCOO-md-a JKSCOO-md-c'><div style='outline-style:none;' data-row='0' data-column='3' __gwt_cell='cell-gwt-uid-1013'> <input type='text'  class='form-control table_input' ng-model='price_rate[".$i."]' style='border-bottom:1px solid #ccc' value='".$row['price_rate']."'> </td> <td class='JKSCOO-md-a JKSCOO-md-c'> <div style='outline-style:none;' data-row='0' data-column='5' __gwt_cell='cell-gwt-uid-1015'><input type='text' class='form-control table_input' ng-model='item_quantity[".$i."]' value='".$row['item_quantity']."'></div></td><td class='JKSCOO-md-a JKSCOO-md-c'><div style='outline-style:none;' data-row='0' data-column='6' __gwt_cell='cell-gwt-uid-1016'><input type='text'  class='form-control table_input' ng-model='discount_rate[".$i."]' value='".$row['discount_rate']."'></td> <td class='JKSCOO-md-a JKSCOO-md-c JKSCOO-md-A'> <input type='text' class='form-control table_input' readonly='' ng-model='amount[".$i."]' value='".$row['amount']."'></td><td class='JKSCOO-md-a JKSCOO-md-c JKSCOO-md-n'><div style='outline-style:none;' data-row='0' data-column='8' __gwt_cell='cell-gwt-uid-1018'><div class='dropdown'><select class='form-control table_input JKSCOO-Jh-b hamar-chatitis' ng-model='vat[".$i."]'><option value='".$row['vat']."'>".$row['vat']."</option><option value='0'>0.0% Exempt (Collected)</option><option value='0'>0.0% Zero-rated (Collected)</option><option value='20'>20.0% Standard rate (Collected)</option><option value='5'>5.0% Lower rate (Collected)</option><option value='0'>None</option> </select></div>  </td>";



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
