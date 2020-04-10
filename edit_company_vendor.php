<?php
include('db.php');
//if(isset($_POST['submit'])){
function arraytoarray($item_name){
$a = array();
foreach($item_name as $cur)
{
 array_push($a,$cur);
}
return $a;
}



 $id = $_POST['id'];
 $company_name = $_POST['company_name'];
 $email = $_POST['email'];
echo  $address = mysqli_real_escape_string($conn, $_POST['address']);
 $city = $_POST['city'];
 $state = $_POST['state'];
 $country = $_POST['country'];
 $contact_name = $_POST['contact_name'];
 $phone = $_POST['phone'];
 $mobile = $_POST['mobile'];
 $tax_number = $_POST['tax_number'];
 $payment_term = $_POST['payment_term'];
 $vat = $_POST['vat'];
 $vat_number = $_POST['vat_number'];
 $vendor_code = $_POST['vendor_code'];
 $payable_account = $_POST['payable_account'];
 $delivery_address = $_POST['delivery_address'];
 $notes = $_POST['notes']; 
$opening_balance = $_POST['opening_balance'];
$opening_date = date('Y-m-d', $_POST['opening_date']);


 $sql="UPDATE  `vendor` SET  `company_name` =  '$company_name', `opening_balance` = '$opening_balance', `opening_date` = '$opening_date',`email` =  '$email',`address` =  '$address',`city` =  '$city',`state` =  '$state',`country` =  '$country',`contact_name` =  '$contact_name',`phone` =  '$phone',`mobile` =  '$mobile',`tax_number` =  '$tax_number',`payment_term` =  '$payment_term',`vat` =  '$vat',`vat_number` =  '$vat_number',`vendor_code` =  '$vendor_code',`payable_account` =  '$payable_account',`delivery_address` =  '$delivery_address',`notes` =  '$notes' WHERE  `id` = '$id';";
$conn->query($sql) or die(mysqli_error()) ;
$conn->query("DELETE FROM `transaction` WHERE `entry_type` = 'Journal' AND `cat_type` =  'Journal' AND `name_id` = '$id' AND `name` =  'vendor' AND `company_email` = '$company_email'");
$vendor_opening_balance = $_POST['vendor_opening_balance'];
$date = $opening_date;
  $sqls="INSERT INTO `transaction` (`entry_type`, `cat_type`, `name_id`, `name`, `total`, `date`, `company_email`, `transaction_number`) VALUES ('Journal', 'Journal', '$id', 'vendor', '$opening_balance', '$date', '$company_email', '')";

  if (mysqli_query($conn, $sqls)) {
    echo  $last_ids = mysqli_insert_id($conn);
    ///////////////////BANK////////////////////
    $sqlsa = $conn->query("SELECT * FROM `coa_list` WHERE `accounts_name` = 'Opening Balance Equity' AND `company_email` = '$company_email' LIMIT 1");
    $r = $sqlsa->fetch_assoc();
    $ias = $r['id'];
    if($opening_balance >= 0){
      $sqli2="INSERT INTO `journal` (`date`, `number`, `account`, `credit`, `transaction_id`, `type`, `company_email`) VALUES ('$date', '', '$payable_account', '$opening_balance', '$last_ids', 'Payment', '$company_email')";
      $conn->query($sqli2) ;
      $sqli2="INSERT INTO `journal` (`date`, `number`, `account`, `debit`, `transaction_id`, `type`, `company_email`) VALUES ('$date', '', '$ias', '$opening_balance', '$last_ids', 'Payment', '$company_email')";
      $conn->query($sqli2) ;
    }else{
      $sqli2="INSERT INTO `journal` (`date`, `number`, `account`, `debit`, `transaction_id`, `type`, `company_email`) VALUES ('$date', '', '$payable_account', '$opening_balance', '$last_ids', 'Payment', '$company_email')";
      $conn->query($sqli2) ;
      $sqli2="INSERT INTO `journal` (`date`, `number`, `account`, `credit`, `transaction_id`, `type`, `company_email`) VALUES ('$date', '', '$ias', '$opening_balance', '$last_ids', 'Payment', '$company_email')";
      $conn->query($sqli2) ;
    }
    ///////////////////BANK////////////////////
  }




?>