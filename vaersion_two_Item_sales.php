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
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="width: 50%"><strong>Item/Service Name </strong></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="width: 25%; text-align:right;"><strong style=" border-bottom:solid 1px black;"> Qty</strong></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="width: 25%;text-align: right;" colspan="2"><strong style=" border-bottom:solid 1px black;"> Amount </strong></td>
                    </tr>
                  </thead>
                  <tbody>
<?php

$inventory_quantity = '0';
$inventory_total = '0';
$inventory_cogsa = '0';
$inventory_sales_item = '0';
$inventory_avg_cogs = '0';
$inventory_margin = '0';
$inventory_gross_margin = '0';
$inventory_sales_percent = '0';
$non_inventory_quantity = '0';
$non_inventory_total = '0';
$non_inventory_sales_percent = '0';

  $grand_total = '0';
  $grand_return = '0';

$sql = "SELECT SUM(amount) AS `total` FROM `sales_item` WHERE (`type` = 'create sales invoice' OR `type` = 'create sales Receipt') AND `company_email` = '$company_email' AND `date` BETWEEN '$date_from' AND '$date_to'";
$new = $conn->query($sql);
while($row = $new->fetch_assoc()){
$sqli = "SELECT SUM(amount) AS `total` FROM `sales_item` WHERE `type` = 'create sales return' AND `company_email` = '$company_email' AND `date` BETWEEN '$date_from' AND '$date_to' GROUP BY  `item_name`";
$news = $conn->query($sqli);
while ($rows = $news->fetch_assoc()) {
 $grand_return = $rows['total'];
}
$grand_total = $row['total'] - $grand_return;
}


$sqlw = "SELECT `item_id`, `item_name` FROM sales_item INNER JOIN transaction ON transaction.id = sales_item.sales_id WHERE `item_category` = 'Inventory' AND (`type` = 'create sales invoice' OR `type` = 'create sales Receipt' OR `type` = 'create sales return') AND sales_item.company_email = '$company_email' AND transaction.name_id = '$name_id' AND sales_item.date BETWEEN '$date_from' AND '$date_to' GROUP BY  `item_id` ORDER BY `item_name`";
$neww = $conn->query($sqlw);
while($roww = $neww->fetch_assoc()){
 $id = $roww['item_id'];
$quantity = '0';
$total = '0';
$cogsa = '0';
$sales_item = '0';

$sql = "SELECT *, SUM(item_quantity) AS `quantity`, SUM(amount) AS `total`, SUM(vat_amount) AS `vat_total`, SUM(cogs) AS `cogsa`, COUNT(*) AS `count` FROM sales_item INNER JOIN transaction ON transaction.id = sales_item.sales_id  WHERE `item_category` = 'Inventory' AND (`type` = 'create sales invoice' OR `type` = 'create sales Receipt') AND `item_id` = '$id'  AND sales_item.company_email = '$company_email' AND transaction.name_id = '$name_id' AND sales_item.date BETWEEN '$date_from' AND '$date_to' GROUP BY  `item_id` ORDER BY `item_name`";
$new = $conn->query($sql);
while($row = $new->fetch_assoc()){
$quantity = $row['quantity'];
$total = $row['total'];
$cogsa = $row['cogsa'];
$sales_item = $row['sales_item'];
}
$sqli = "SELECT *, SUM(item_quantity) AS `quantity`, SUM(amount) AS `total`, SUM(vat_amount) AS `vat_total`, SUM(cogs) AS `cogsa`, COUNT(*) AS `count` FROM sales_item INNER JOIN transaction ON transaction.id = sales_item.sales_id  WHERE `type` = 'create sales return' AND `item_id` = '$id'  AND sales_item.company_email = '$company_email' AND transaction.name_id = '$name_id' AND sales_item.date BETWEEN '$date_from' AND '$date_to' GROUP BY  `item_id`";
$news = $conn->query($sqli);
while ($rows = $news->fetch_assoc()) {
$quantity = $quantity - $rows['quantity']; 
$total = $total - $rows['total'];
$cogsa = $cogsa - $rows['cogsa'];
$sales_item = $sales_item - $rows['sales_item'];

}
$avg_cogs =  $cogsa/$sales_item;
$margin = $total - $cogsa;
$gross_margin = ($margin*100)/$total;
$sales_percent = ($total*100)/$grand_total;

$inventory_quantity += $quantity;
$inventory_total += $total;
$inventory_cogsa += $cogsa;
$inventory_sales_item += $sales_item;
$inventory_avg_cogs += $avg_cogs;
$inventory_margin += $margin;
$inventory_gross_margin =+ $gross_margin;
$inventory_sales_percent += $sales_percent;
?>
                     <tr  class="JKSCOO-k-b table-row link">
                      <td style="padding: 0px 0px 0px 65px"><span style="font-size:medium;display:inline-block; width:270px; white-space: nowrap; overflow:hidden !important; text-overflow: ellipsis;"><?php echo $roww['item_name']; ?></span></td>
                      <td style="text-align: right;"><?php echo $quantity; ?></td>  
                      <td style="text-align: right;"><?php echo number_format($total, 2); ?></td>  
                    </tr>
<?php
}
?>



                  <tr  class="JKSCOO-k-b table-row link">
                    <td class="JKSCOO-k-a JKSCOO-k-c"> <strong> Total Stock</strong></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: right;"><p  style="border-top:1px solid #000;border-bottom: 1px solid #000"><strong><?php echo $inventory_quantity; ?></strong></p></td>  
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: right;"><p  style="border-top:1px solid #000;border-bottom: 1px solid #000"><strong><?php echo number_format($inventory_total, 2); ?></strong></p></td>  
                    </tr>
<?php
$sqlw = "SELECT `item_id`, `item_name` FROM sales_item INNER JOIN transaction ON transaction.id = sales_item.sales_id  WHERE `item_category` != 'Inventory' AND (`type` = 'create sales invoice' OR `type` = 'create sales Receipt' OR `type` = 'create sales return')   AND sales_item.company_email = '$company_email' AND transaction.name_id = '$name_id' AND sales_item.date BETWEEN '$date_from' AND '$date_to' GROUP BY  `item_id` ORDER BY `item_name`";
$neww = $conn->query($sqlw);
while($roww = $neww->fetch_assoc()){
 $id = $roww['item_id'];
$quantity = '0';
$total = '0';

$sql = "SELECT *, SUM(item_quantity) AS `quantity`, SUM(amount) AS `total`, SUM(vat_amount) AS `vat_total`, SUM(cogs) AS cogsa, COUNT(*) AS `count` FROM sales_item INNER JOIN transaction ON transaction.id = sales_item.sales_id  WHERE `item_category` != 'Inventory' AND (`type` = 'create sales invoice' OR `type` = 'create sales Receipt' OR `type` = 'create sales return')   AND sales_item.company_email = '$company_email' AND transaction.name_id = '$name_id' AND sales_item.date BETWEEN '$date_from' AND '$date_to' GROUP BY  `item_id` ORDER BY  `item_name` ";
$new = $conn->query($sql);
while($row = $new->fetch_assoc()){
$quantity = $row['quantity']; 
$total = $row['total'];
}
$sqli = "SELECT *, SUM(item_quantity) AS `quantity`, SUM(amount) AS `total`, SUM(vat_amount) AS `vat_total`, SUM(cogs) AS cogsa, COUNT(*) AS `count` FROM sales_item INNER JOIN transaction ON transaction.id = sales_item.sales_id  WHERE `type` = 'create sales return' AND `item_id` = '$id'   AND sales_item.company_email = '$company_email' AND transaction.name_id = '$name_id' AND sales_item.date BETWEEN '$date_from' AND '$date_to'";
$news = $conn->query($sqli);
while ($rows = $news->fetch_assoc()) {

$quantity = $quantity - $rows['quantity']; 
$total = $total - $rows['total'];
}
$sales_percent = ($total*100)/$grand_total;
$non_inventory_quantity += $quantity;
$non_inventory_total += $total;
$non_inventory_sales_percent += $sales_percent;
?>

                     <tr  class="JKSCOO-k-b table-row link">
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="padding: 75px 0px 0px 65px"><B><?php echo $roww['item_name']; ?></B></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: right;"><?php echo $quantity; ?></td>  
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: right;"><?php echo number_format($total, 2); ?></td>  
                    </tr>
<?php
}
?>



                  <tr  class="JKSCOO-k-b table-row link">
                    <td class="JKSCOO-k-a JKSCOO-k-c"> <strong> Total Services / Non Inventory</strong></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: right;"><p style="text-align: right;border-top: 1px solid #000;border-bottom: 1px solid #000"><strong><?php echo $non_inventory_quantity; ?></strong></p></td>  
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: right;"><p style="text-align: right;border-top: 1px solid #000;border-bottom: 1px solid #000"><strong><?php echo number_format($non_inventory_total, 2); ?></strong></p></td>  
                    </tr>


                  <tr  class="JKSCOO-k-b table-row link">
                    <td class="JKSCOO-k-a JKSCOO-k-c"> <B> Total</B></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: right;border-top: 1px solid #000;border-bottom: 4px double #000"><p><B><?php echo $non_inventory_quantity+$inventory_quantity; ?></B></p></td>  
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: right;border-top: 1px solid #000;border-bottom: 4px double #000"><p><B><?php echo number_format($non_inventory_total+$inventory_total, 2); ?></B></td> </p> 
                    </tr>


                  </tbody>
                  

                </table>
</center>