<?php
include("db.php");
$i = '0';
error_reporting(1);
$result = '';

	$id = $_GET['id'];
$end = $_REQUEST['end'];
$start = $_REQUEST['start'];

$sql = "SELECT * FROM `items` WHERE `company_email` = '$company_email' AND `id` = '$id'";

$new = $conn->query($sql);
while($row = $new->fetch_assoc()){
$result = $row;
}

if(isset($_GET['end'])){
$date_to = date('Y-m-d', strtotime($_GET['end']));
$item =  $_REQUEST['item'];
}else{
$date_to = date('Y-m-d');
}
$sql = "SELECT *, (SELECT SUM( purchase_item.item_quantity ) FROM purchase_item WHERE purchase_item.date<='$date_to' AND purchase_item.item_id = items.id AND purchase_item.company_email = '$company_email') AS purchase_item_quantity, (SELECT SUM( sales_item.item_quantity ) FROM sales_item WHERE sales_item.date<='$date_to' AND sales_item.item_id = items.id AND sales_item.company_email = '$company_email') AS sales_item_quantity, (SELECT SUM( purchase_item.item_quantity ) FROM purchase_item WHERE purchase_item.date<='$date_to' AND purchase_item.type='create purchase return' AND purchase_item.item_id = items.id AND purchase_item.company_email = '$company_email') AS po_return_quantity, (SELECT SUM( sales_item.item_quantity ) FROM sales_item WHERE sales_item.date<='$date_to' AND sales_item.type='create sales return' AND sales_item.item_id = items.id AND sales_item.company_email = '$company_email') AS so_return_quantity, (SELECT SUM( purchase_item.item_quantity ) FROM purchase_item WHERE purchase_item.date<='$date_to' AND purchase_item.type='create purchase order' AND purchase_item.item_id = items.id AND purchase_item.company_email = '$company_email') AS po_quantity, (SELECT SUM( sales_item.item_quantity ) FROM sales_item WHERE sales_item.date<='$date_to' AND sales_item.type='Create sales order' AND sales_item.item_id = items.id AND sales_item.company_email = '$company_email') AS so_quantity, (SELECT SUM( inventory_goods.item_quantity ) FROM inventory_goods WHERE  inventory_goods.date_time<='$date_to' AND inventory_goods.type='create Goods receipt note' AND inventory_goods.item_id = items.id AND inventory_goods.company_email = '$company_email') AS reciept_quantity, (SELECT SUM( inventory_goods.item_quantity ) FROM inventory_goods WHERE  inventory_goods.date_time<='$date_to' AND inventory_goods.type='create Goods issue notes' AND inventory_goods.item_id = items.id AND inventory_goods.company_email = '$company_email') AS issue_quantity FROM items WHERE items.id = '$id' AND items.name LIKE '%$item%' AND items.company_email = '$company_email'";




  $stock = '0';
  $sale_qty = '0';
  $purchs_qty = '0';
$Available = '';
 $i = '1';

$new = $conn->query($sql);
while($row = $new->fetch_assoc()){
  $num_rows = mysqli_num_rows($new);


$Available += $row['purchase_item_quantity']-$row['sales_item_quantity'];
$sale_qty += $row['so_quantity'];
$purchs_qty += $row['po_quantity'];
$stock += (($row['purchase_item_quantity']-($row['po_quantity']+$row['po_return_quantity']*2)) + $row['reciept_quantity'])-(( $row['sales_item_quantity']-($row['so_quantity']+$row['so_return_quantity']*2))+ $row['issue_quantity']);

$result['report_on_hand'] = $row['open_qty']+(($row['purchase_item_quantity']-($row['po_quantity']+$row['po_return_quantity']*2)) + $row['reciept_quantity'])-(( $row['sales_item_quantity']-($row['so_quantity']+$row['so_return_quantity']*2))+ $row['issue_quantity']);
$result['report_available'] = $row['open_qty']+($row['purchase_item_quantity']-($row['po_return_quantity']*2))-($row['sales_item_quantity']-$row['so_return_quantity']*2); 

}
$result['stock_valuation'] = file_get_contents("http://more-acc.com//account//upload//report_stock_valuation.php?start=".urlencode($start)."&end=".urlencode($end)."&id=".$id."&userid=".$company_email);
$result['Item_Puchase'] = file_get_contents("http://more-acc.com//account//upload//report_purchase_summery.php?start=".urlencode($start)."&end=".urlencode($end)."&id=".$id."&userid=".$company_email."&name=".urlencode($name));
$result['Item_Sales'] = file_get_contents("http://more-acc.com//account//upload//report_sales_summery.php?start=".urlencode($start)."&end=".urlencode($end)."&id=".$id."&userid=".$company_email."&name=".urlencode($name));

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
