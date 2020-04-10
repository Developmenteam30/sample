<?php
include("db.php");
$id = $_GET['id'];

$i = '0';
include("header.php");
?>
<?php
$sqli = "SELECT * FROM `coa_list` WHERE `id` = '$id' AND `company_email` = '$company_email'";
$news = $conn->query($sqli);
$rs = $news->fetch_assoc();
$account = $rs['accounts_name'];
if(isset($_GET['start']) && isset($_GET['end'])){
$date_from = date('Y-m-d', strtotime($_GET['start']));
$date_to = date('Y-m-d', strtotime($_GET['end']));
$account_type =  $_REQUEST['account_type'];
$account_name =  $_REQUEST['account'];
$type = $_REQUEST['type'];
if($_REQUEST['amount_filter'] == 'equal'){
$amount_filter = '=';
}elseif($_REQUEST['amount_filter'] == 'greater'){
$amount_filter = '>=';
}elseif($_REQUEST['amount_filter'] == 'less'){
$amount_filter = '<=';
}else{
$amount_filter = 'LIKE';
}
}else{
$amount_filter = 'LIKE';
$date_to = date('Y-m-d');
$date_from  = date('Y-m-d', strtotime($date_to. ' -180 days'));
}


?>
                      <table   __gwtcellbasedwidgetimpldispatchingfocus="true" __gwtcellbasedwidgetimpldispatchingblur="true" class="JKSCOO-k-y table-fixed-layout page-panel" cellspacing="0">
        
                   <thead>
                     <tr class="JKSCOO-k-b table-row link">
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="width: 12%;border-bottom: 1px solid #000"><strong>Type</strong></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: center;width: 8%;border-bottom: 1px solid #000"><strong>Date</strong></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: center;width: 4%;border-bottom: 1px solid #000"><strong>Num</strong></td>
                      
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: center;width: 16%;border-bottom: 1px solid #000"><strong>Name</strong></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: center;width: 1%;"><strong></strong></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: center;width: 8%;border-bottom: 1px solid #000"><strong>Debit</strong></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: center;width: 8%;border-bottom: 1px solid #000"><strong>Credit</strong></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: center;width: 9%;border-bottom: 1px solid #000"><strong>Balance</strong></td>
                    </tr>



                  </thead>

                  <?php
                  $account = ''; $accounts_name = '0'; $grand_balance = '0'; $finel_balance='0';
                  $account_dabit = '';
                  $account_credit = '';
                  $fil_account_dabit = '';
                  $fil_account_credit = '';
$s = " CALL  PROC_FINANCIAL_GENLEDGER('$company_email', '$date_from', '$date_to', '$amount', '$type', '$account_type', '$account')";
$sql = $conn->query($s);
$new = array();
$total = 0;
$sub_total = 0;
while($rows = $sql->fetch_assoc()){
  if($rows['group'] == "Long Term Liability" || $rows['group'] == "Income" || $rows['group'] == "Equity" || $rows['group'] == "Current Liability" || $rows['group'] == "Credit Card" || $rows['group'] == "Bank/Loan Facility" || $rows['group'] == "Accounts payable"){
  $start_balance = $rows['Credit']-$rows['Debit'];
  }else{
  $start_balance = $rows['Debit']-$rows['Credit'];
  }
  $fil_account_dabit += $rows['Debit'];
  $fil_account_credit += $rows['Credit'];
  $sub_total += $start_balance;
  $account_dabit += $rows['Debit'];
  $account_credit += $rows['Credit'];
  $finel_balance += $start_balance;
  if($rows['id'] == '0'){
    if(isset($start_data)){
?>
<tr class="JKSCOO-k-b table-row link">
                      <td class="JKSCOO-k-a JKSCOO-k-c"  colspan="5"><p><b>Total <?php echo $start_data['accounts_name']; ?></b></p></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: right;border-top:1px solid #000"><b><?php echo number_format($fil_account_dabit, 2); ?></b></td> 

                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: right;border-top:1px solid #000"><b><?php echo number_format($fil_account_credit, 2); ?></b></td> 
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: right;border-top:1px solid #000"><b><?php echo number_format($sub_total, 2); ?></b></td> 
</tr>

<?php
      $fil_account_dabit = 0;
      $fil_account_credit = 0;
      $sub_total = 0;
    }
      $start_data = $rows;
?>
                    <tr class="JKSCOO-k-b table-row link">
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="padding: 10px 0px 0px 12px " colspan="7"><B><?php echo $rows['accounts_name']; ?></B></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="padding: 10px 0px 0px 12px; text-align:right "><B><?php echo $start_balance; ?></B></td>             
                    </tr>

<?php
   goto end;
  }
?>
                  <tr class="JKSCOO-k-b table-row link">
                      <td class="JKSCOO-k-a JKSCOO-k-c" onclick="parent.goto_next_transaction('<?php echo $rows['id']; ?>', '<?php echo $rows['cat_type']; ?>');"><p><?php echo ucwords(str_ireplace("create","",$rows['cat_type'])); ?></p></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c"><p style="display: inline-block;width: 75px;white-space: nowrap;overflow: hidden !important;text-overflow: ellipsis;"><?php echo date("d-m-Y", strtotime($rows['voucherDate'])); ?></p></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c"><p><?php echo $rows['transaction_number']; ?></p></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c"  style="display:inline-block; width:120px; white-space: nowrap; overflow:hidden !important; text-overflow: ellipsis;"><p><?php echo $rows['name']; ?></p></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c"><p></p></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: right;"><p><?php  if($rows['Debit']=="0"){ echo ""; }  else { echo number_format($rows['Debit'], 2); } ?></p></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: right;"><p><?php  if($rows['Credit']=="0"){ echo ""; }  else { echo number_format($rows['Credit'], 2); } ?></p></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: right;"><p><?php  echo number_format($sub_total, 2); ?></p></td>
                  </tr>

<?php
end:

}
?>
<tr class="JKSCOO-k-b table-row link">
                      <td class="JKSCOO-k-a JKSCOO-k-c"  colspan="5"><p><b>Total <?php echo $accounts_name; ?></b></p></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: right;border-top:1px solid #000"><b><?php echo number_format($fil_account_dabit, 2); ?></b></td> 

                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: right;border-top:1px solid #000"><b><?php echo number_format($fil_account_credit, 2); ?></b></td> 
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: right;border-top:1px solid #000"><b><?php echo number_format($sub_total, 2); ?></b></td> 
</tr>

<tr class="JKSCOO-k-b table-row link">
                      <td class="JKSCOO-k-a JKSCOO-k-c"  colspan="5"><h3>TOTAL</h3></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: right;border-bottom: 4px double #000;border-top:1px solid #000"><h4><b><?php echo number_format($account_dabit, 2); ?></h4></b></td> 

                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: right;border-bottom: 4px double #000;border-top:1px solid #000"><h4><b><?php echo number_format($account_credit, 2); ?></h4></b></td> 
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: right;border-bottom: 4px double #000;border-top:1px solid #000;"><h4><b><?php echo number_format($finel_balance, 2); ?></h4></b></td> 
</tr>

                  </tbody>
                    


                </table>