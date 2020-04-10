  <?php
include("db.php");

$i = '0';

$item_id = $_GET['id'];
$sa = "SELECT * FROM `items` WHERE `id`='$item_id' AND `company_email`='$company_email'";
$sq = $conn->query($sa);
$ra = $sq->fetch_assoc();
if(isset($_GET['end'])){

$date_to = date('Y-m-d', strtotime($_GET['end']));
$item =  $_REQUEST['item'];
}else{
$date_to = date('Y-m-d');
$date_from  = date('Y-m-d', strtotime($date_to. ' -180 days'));
}
$name = '';
$i = 0;
$j = 1;
$bhau = array();
$s = "CALL `PROC_INVENTORY`('$company_email', '$date_to', '$item', '0')";
$sql = $conn->query($s);
$count = $sql->num_rows;
$asset = 0; $qty = 0;
  $grand_qty = 0;
  $grand_asset_value = 0;
  $grand_retail_value = 0;
while($row = $sql->fetch_assoc()){ 
  $id = $row['id'];
  if($name != $row['name']){
    $raw[$i] = $row;
  }
  if(($name != $row['name'] && $name != '')){
    $grand_retail_value += $qty*$bhau['sale_price_h'];
    $retail_value = $qty*$bhau['sale_price_h'];
    $raw[$i] = $bhau;
    $raw[$i]['qty_data'] = $qty;
    $raw[$i]['asset_data'] = $qty*$bhau['AvgCost'];
    $raw[$i]['retail_data'] = $retail_value;
    $grand_qty += $bhau['Qty'];
    $grand_asset_value += $qty*$bhau['AvgCost'];
    $asset = 0; $qty = 0;
    $i++;
  }
    $name = $row['name'];
    $qty += $row['Qty'];
    $asset += $qty*$row['AvgCost'];
  $bhau = $row;
  $j++;
}
if (!isset($raw[$i]['qty_data'])) {
      $grand_retail_value += $qty*$bhau['sale_price_h'];
      $retail_value = $qty*$bhau['sale_price_h'];
      $raw[$i] = $bhau;
      $raw[$i]['qty_data'] = $qty;
      $raw[$i]['asset_data'] = $qty*$bhau['AvgCost'];
      $raw[$i]['retail_data'] = $retail_value;
      $grand_qty += $bhau['Qty'];
      $grand_asset_value += $qty*$bhau['AvgCost'];
      $asset = 0; $qty = 0;
}
?>


                      <table __gwtcellbasedwidgetimpldispatchingfocus="true" __gwtcellbasedwidgetimpldispatchingblur="true" class="JKSCOO-k-y table-fixed-layout page-panel" cellspacing="0" style="width: 100%;padding:0px 10px 0px 10px">

                  <tbody>

<?php
$precent_Tot_Asset = 0;
$percent_Tot_Retail = 0;
foreach ($raw as $row) {
  if ($row['name'] == $ra['name']) {
    $on_hand = $row['qty_data'];
    $avg_cost = $row['AvgCost'];
    if ($grand_asset_value == 0) {
      $precent_Tot_Asset += 0;
      $asset_percent = 0;
    }else{
      $precent_Tot_Asset += (($row['asset_data'])/$grand_asset_value)*100;
      $asset_percent = ($row['asset_data']/$grand_asset_value)*100;  
    }
    if ($grand_retail_value == 0) {
      $percent_Tot_Retail += 0;
    }else{
      $percent_Tot_Retail += ($row['retail_data']/$grand_retail_value)*100;
    }
?>

                    <tr class="JKSCOO-k-b table-row link">
                      <td class="JKSCOO-k-a JKSCOO-k-c"><strong>On Hand</strong></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c"><?php echo $on_hand; ?></td>  
                    </tr>
                    <tr class="JKSCOO-k-b table-row link">
                      <td class="JKSCOO-k-a JKSCOO-k-c"><strong>Avg Cost</strong></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c"><?php echo number_format($avg_cost, 2); ?></td> 
                    </tr>
                    <tr class="JKSCOO-k-b table-row link">
                      <td class="JKSCOO-k-a JKSCOO-k-c"><strong>Asset Value</strong></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c"><?php echo number_format($row['asset_data'], 2); ?></td>  
                    </tr>
                    <tr class="JKSCOO-k-b table-row link">
                      <td class="JKSCOO-k-a JKSCOO-k-c"><strong>%age of Total Asset</strong></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c"><?php echo number_format($asset_percent, 2); ?></td>  
                    </tr>
                    <tr class="JKSCOO-k-b table-row link">
                      <td class="JKSCOO-k-a JKSCOO-k-c"><strong>Sales Price</strong></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c"><?php echo $row['sale_price_h']; ?></td>  
                    </tr>
                    <tr class="JKSCOO-k-b table-row link">
                      <td class="JKSCOO-k-a JKSCOO-k-c"><strong>Retail Value</strong></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c"><?php echo number_format($row['retail_data'], 2); ?></td>  
                    </tr>
                    <tr class="JKSCOO-k-b table-row link">
                      <td class="JKSCOO-k-a JKSCOO-k-c"><strong>%age of Total Retail</strong></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c"><?php if($grand_retail_value == 0){ echo '0.00'; }else{ echo number_format(($row['retail_data']/$grand_retail_value)*100, 2); } ?></td>  
                    </tr>

<?php
  }
}
?>
                  </tbody>
                </table>