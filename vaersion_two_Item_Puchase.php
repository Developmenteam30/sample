<?php
include("db.php");
$name_id = $_GET['id'];
$i = '0';
include("header.php");

?>

<?php
if(isset($_GET['start']) && isset($_GET['end'])){
$date_from = date('Y-m-d', strtotime($_GET['start']));
$date_to = date('Y-m-d', strtotime($_GET['end']));
}else{
$date_to = date('Y-m-d');
$date_from  = date('Y-m-d', strtotime($date_to. ' -180 days'));
}
?>

<center>


                 

                      <table  __gwtcellbasedwidgetimpldispatchingfocus="true" __gwtcellbasedwidgetimpldispatchingblur="true" class="JKSCOO-k-y table-fixed-layout page-panel" cellspacing="0">
                  <thead>
                  <tr  class="JKSCOO-k-b table-row link">
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="width: 50%"><strong>Item/Service Name </strong></td><td class="JKSCOO-k-a JKSCOO-k-c"></td><td class="JKSCOO-k-a JKSCOO-k-c"></td><td class="JKSCOO-k-a JKSCOO-k-c"></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="width: 25%; text-align:right;"><strong style=" border-bottom:solid 1px black;"> Qty</strong></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="width: 25%;text-align: right;" colspan="2"><strong style=" border-bottom:solid 1px black;"> Amount </strong></td>
                    </tr>
                  </thead>
                  <tbody>
<?php

$inventory_quantity = '0';
$inventory_total = '0';

  $grand_total = '0';
  $grand_return = '0';

$sql = "SELECT SUM(amount) AS `total` FROM `purchase_item` WHERE (`type` = 'create purchase invoice' OR `type` = 'create purchase Receipt') AND company_email = '$company_email' AND `date` BETWEEN '$date_from' AND '$date_to'";
$new = $conn->query($sql);
while($row = $new->fetch_assoc()){
$sqli = "SELECT SUM(amount) AS `total` FROM `purchase_item` WHERE `type` = 'create purchase return' AND company_email = '$company_email' GROUP BY  `item_name` AND `date` BETWEEN '$date_from' AND '$date_to'";
$news = $conn->query($sqli);
while ($rows = $news->fetch_assoc()) {
 $grand_return = $rows['total'];
}
$grand_total = $row['total'] - $grand_return;
}

 
$sql = "SELECT * , SUM( item_quantity ) AS  `quantity` , SUM( amount ) AS  `total` , SUM( cogs ) AS cogsa, COUNT( * ) AS  `count` FROM purchase_item INNER JOIN transaction ON transaction.id = purchase_item.purchase_id WHERE `item_category` = 'Inventory' AND (`type` = 'create purchase invoice' OR `type` = 'Create purchase Receipt' OR `type` = 'create purchase return') AND purchase_item.company_email = '$company_email' AND transaction.name_id = '$name_id' AND purchase_item.date BETWEEN '$date_from' AND '$date_to' GROUP BY  `item_id`  ORDER BY  `item_name`";
$new = $conn->query($sql);
while($row = $new->fetch_assoc()){
$id = $row['item_id'];
$quantity = $row['quantity'];
$total = $row['total'];
$cogsa = $row['cogsa'];
$sales_item = $row['purchase_item'];
$sqli = "SELECT *, SUM(item_quantity) AS `quantity`, SUM(amount) AS `total`, SUM(cogs) AS cogsa, COUNT(*) AS `count` FROM purchase_item INNER JOIN transaction ON transaction.id = purchase_item.purchase_id WHERE `type` = 'create purchase return' AND purchase_item.company_email = '$company_email' AND `item_id` = '$id' AND transaction.name_id = '$name_id' AND purchase_item.date BETWEEN '$date_from' AND '$date_to' GROUP BY  `item_id`";
$news = $conn->query($sqli);
while ($rows = $news->fetch_assoc()) {

$quantity = $row['quantity'] - $rows['quantity']*2; 
$total = $row['total'] - $rows['total']*2;
$cogsa = $row['cogsa'] - $rows['cogsa']*2;
$sales_item = $row['sales_item'] - $rows['sales_item']*2;

}
$inventory_quantity += $quantity;
$inventory_total += $total;
$inventory_sales_item += $sales_item;
?>
                     <tr class="JKSCOO-k-b table-row link">
                     <td class="JKSCOO-k-a JKSCOO-k-c" style="padding: 0px 0px 0px 30px;display:inline-block; width:270px; white-space: nowrap; overflow:hidden !important; text-overflow: ellipsis; "><span style="font-size: medium;"><?php echo $row['item_name']; ?></span></td><td class="JKSCOO-k-a JKSCOO-k-c"></td><td class="JKSCOO-k-a JKSCOO-k-c"></td><td class="JKSCOO-k-a JKSCOO-k-c"></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: right;"><?php echo $quantity; ?></td>  
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: right;" colspan="2"><?php echo number_format($total, 2); ?></td>  
                    </tr>
<?php
}
?>



                  <tr class="JKSCOO-k-b table-row link">
                    <td class="JKSCOO-k-a JKSCOO-k-c" style="padding: 0px 0px 0px 0px "> <b> Total Stock</b></td><td class="JKSCOO-k-a JKSCOO-k-c"></td><td class="JKSCOO-k-a JKSCOO-k-c"></td><td class="JKSCOO-k-a JKSCOO-k-c"></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: right;"><p style="font-weight: bold;border-top:1px solid #000;border-bottom: 1px solid #000;padding: 3px 0px 3px 0px "><?php echo $inventory_quantity; ?></p></td>  
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: right;" colspan="2"><p style="font-weight: bold;border-top:1px solid #000;padding: 3px 0px 3px 0px ;border-bottom: 1px solid #000" colspan="2"><?php echo number_format($inventory_total, 2); ?></p></td>  
                    </tr>
<?php
$sql = "SELECT * , SUM( item_quantity ) AS  `quantity` , SUM( amount ) AS  `total` , SUM( cogs ) AS cogsa, COUNT( * ) AS  `count` FROM purchase_item INNER JOIN transaction ON transaction.id = purchase_item.purchase_id WHERE `item_category` != 'Inventory' AND (`type` = 'create purchase invoice' OR `type` = 'Create purchase Receipt' OR `type` = 'create purchase return') AND purchase_item.company_email = '$company_email' AND transaction.name_id = '$name_id' AND purchase_item.date BETWEEN '$date_from' AND '$date_to' GROUP BY  `item_id`  ORDER BY  `item_name` ";
$new = $conn->query($sql);
while($row = $new->fetch_assoc()){
$id = $row['item_id'];
$quantity = $row['quantity']; 
$total = $row['total'];
$sqli = "SELECT *, SUM(item_quantity) AS `quantity`, SUM(amount) AS `total`, SUM(cogs) AS cogsa, COUNT(*) AS `count` FROM purchase_item INNER JOIN transaction ON transaction.id = purchase_item.purchase_id WHERE `type` = 'create purchase return' AND purchase_item.company_email = '$company_email' AND `item_id` = '$id' AND transaction.name_id = '$name_id' AND purchase_item.date BETWEEN '$date_from' AND '$date_to' GROUP BY  `item_id`";
$news = $conn->query($sqli);
while ($rows = $news->fetch_assoc()) {

$quantity = $row['quantity'] - $rows['quantity']; 
$total = $row['total'] - $rows['total'];
}
$sales_percent = ($total*100)/$grand_total;
$non_inventory_quantity += $quantity;
$non_inventory_total += $total;
?>

                     <tr class="JKSCOO-k-b table-row link">
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="padding: 0px 0px 0px 30px;display:inline-block; width:270px; white-space: nowrap; overflow:hidden !important; text-overflow: ellipsis; "><B><?php echo $row['item_name']; ?></B></td><td class="JKSCOO-k-a JKSCOO-k-c"></td><td class="JKSCOO-k-a JKSCOO-k-c"></td><td class="JKSCOO-k-a JKSCOO-k-c"></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: right;"><?php echo $quantity; ?></td>  
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: right;" colspan="2"><?php echo number_format($total, 2); ?></td>  
                    </tr>
<?php
}
?>



                  <tr class="JKSCOO-k-b table-row link">
                    <td class="JKSCOO-k-a JKSCOO-k-c" style="padding: 0px 0px 0px 0px "> <b> Total Services / Non Inventory</b></td><td class="JKSCOO-k-a JKSCOO-k-c"></td><td class="JKSCOO-k-a JKSCOO-k-c"></td><td class="JKSCOO-k-a JKSCOO-k-c"></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: right;"><p style="font-weight: bold;"><?php echo $non_inventory_quantity; ?></p></td>  
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align:right;" colspan="2"><p style="font-weight: bold;" colspan="2"><?php echo number_format($non_inventory_total, 2); ?></p></td>  
                    </tr>


                  <tr class="JKSCOO-k-b table-row link">
                    <td class="JKSCOO-k-a JKSCOO-k-c" style="padding: 0px 0px 0px 0px "> <b> Total</b></td><td class="JKSCOO-k-a JKSCOO-k-c"></td><td class="JKSCOO-k-a JKSCOO-k-c"></td><td class="JKSCOO-k-a JKSCOO-k-c"></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="border-top:1px solid #000;border-bottom: 4px double #000; text-align:right;;padding: 3px 0px 3px 0px"><p><b><?php echo $non_inventory_quantity+$inventory_quantity; ?></b></p></td>  
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: right;border-top:1px solid #000;border-bottom: 4px double #000;;padding: 3px 0px 3px 0px" colspan="2"><p><b><?php echo number_format($non_inventory_total+$inventory_total, 2); ?></b></p></td>  
                    </tr>


                  </tbody>
                  

                </table>