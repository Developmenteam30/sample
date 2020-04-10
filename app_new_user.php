<?php
/************************FUNCTION FOR MASTER ACCOUNT *********************/
function cust_ins($primary_name,$msname,$company_name,$company_email,$second_company_name,$second_company_email,$third_company_name,$third_company_email,$address,$mobile,$password,$promo_code){
include('../../account_master/db.php');
if($promo_code!=''){
$s_ad = "SELECT * FROM `admin` WHERE `affiliate_code` = $promo_code";
$r_ad = $con->query($s_ad);
$row_ad = $r_ad->fetch_assoc();
$sales_person = $row_ad['email'];
}else{
$sales_person = '';
}
$date = date('Y-m-d');


if (isset($_SESSION['plan_name'])) {
$plan_name = $_SESSION['plan_name'];
}else{
  $plan_name = 'Demo';
}
if (isset($_SESSION['stripeEmail'])) {
$stripeEmail = $_SESSION['stripeEmail'];
}else{
  $stripeEmail = $company_email;
}
if (isset($_SESSION['payment'])) {
$payment = $_SESSION['payment']; 
}else{
$payment = '00'; 
}
if (isset($_SESSION['plan_expire']) && $_SESSION['plan_expire'] == 'yearly') {
$e_date1 = date('Y-m-d', strtotime($date. ' + 1 year'));
$plan_expire == 'yearly';
}else{
$e_date1 = date('Y-m-d', strtotime($date. ' + 1 month'));
$plan_expire == 'monthly';
}


$i_c = "INSERT INTO `customers` (`date`, `primary_name`, `name`, `email`, `password`, `sales_person`, `payment_term`, `address`, `company_name`, `mobile`, `company_email`, `second_company_name`, `second_company_email`, `third_company_name`, `third_company_email`, `status`) VALUES('$date', '$primary_name', '$msname', '$company_email', '$password', '$sales_person', 'Monthly', '$address', '$company_name', '$mobile', '$company_email', '$second_company_name', '$second_company_email', '$third_company_name', '$third_company_email', 'active')";
$con->query($i_c);
$customer_last_id = $con->insert_id;


$s_p = "SELECT * FROM `plan` WHERE `name` = '$plan_name'";
$r_p = $con->query($s_p);
$row_p = $r_p->fetch_assoc();
$p_id = $row_p['id'];
$amount = $row_p['price_monthly'];


 $sql = "INSERT INTO `subscriptions` (`date`, `customer_id`, `plan_id`, `amount`, `activated_on`, `affiliate_code`, `nest_bill`, `expiry_date`, `trial_days`, `time_peiod`, `status`, `company_email`) VALUES('$date', '".$customer_last_id."', '$p_id', '$amount', '$date', '$promo_code', '$e_date1', '$e_date1', '30', '$plan_expire', '$plan_name', '$company_email')";
$r_sql = $con->query($sql);
$subscription_last_id = $con->insert_id;


 $iinv1 = "INSERT INTO `invoice` (`date`,`s_id`,`c_id`,`amount`,`nest_bill`,`expiry_date`,`time_peiod`,`status`,`payer_email`) VALUES('$date','".$subscription_last_id."','".$customer_last_id."','".$amount."','".$e_date1."','".$e_date1."','$plan_expire','$plan_name','$stripeEmail')";
 $con->query($iinv1);
//echo '<script>alert("'.$iinv1.'");</script>';

if($sales_person != ''){ 
$body = "http://more-acc.com/email_cust.php?name=".urlencode($msname);
?>
<script>
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                alert(this.responseText);
            }
        };
        xmlhttp.open("GET", "http://vatguru.info/mail/PHP/examples/url_mail.php?email_to=<?php echo $sales_person; ?>&email_subject=New Account created on More Accounts&email_body=<?php echo urlencode($body); ?>", true);
        xmlhttp.send();
</script>
<?php }
$body = "http://more-acc.com/email_admin.php?name=".urlencode($msname);
?>
<script>
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                alert(this.responseText);
            }
        };
        xmlhttp.open("GET", "http://vatguru.info/mail/PHP/examples/url_mail.php?email_to=accountantdubai@gmail.com &email_subject=New Account created on More Accounts&email_body=<?php echo urlencode($body); ?>", true);
        xmlhttp.send();
</script>
<?php
}

/************************FUNCTION FOR MASTER ACCOUNT *********************/

include('db.php');
if(isset($_POST['submit'])){
$secret="6LeBNjsUAAAAAH48auuEgOJEdyWjD9kJp9N2q5vU";
$response=$_POST["g-recaptcha-response"];
$ip = $_SERVER['REMOTE_ADDR'];
$verify=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secret."&response=".$response."&remoteip=".$ip);
$captcha_success=json_decode($verify);
//print_r($captcha_success);
if ($captcha_success->success==false && !isset($_POST['force_register'])) {
echo "<script>window.location.href = '../registration.php?error=Robots not allowed to register.';</script>";
}else if ($captcha_success->success==true || isset($_POST['force_register'])) {

  $primary_name = $_POST['primary_name'];
  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $name = $primary_name.' '.$first_name.' '.$last_name;
  $company_name = $_POST['company_name'];
  $company_email = $_POST['company_email'];
  $address = $_POST['address'];
  $mobile = $_POST['mobile'];
  $password = $_POST['password'];
  $confirm_password = $_POST['confirm_password'];
  $promo_code = $_POST['promo_code'];
  $msname = $first_name.' '.$last_name;
$date = date('Y-m-d');
if (isset($_SESSION['plan_expire']) && $_SESSION['plan_expire'] == 'yearly') {
$e_date1 = date('Y-m-d', strtotime($date. ' + 1 year'));
$plan_expire == 'yearly';
}else{
$e_date1 = date('Y-m-d', strtotime($date. ' + 1 month'));
$plan_expire == 'monthly';
}

  if($password == $confirm_password){
  $new = $conn->query("SELECT * FROM `user` WHERE `company_email`='$company_email'");
  $count = $new->num_rows;
if($count > '0'){
  $not = "not";
echo "<script>window.location.href = '../registration.php?error=User already exist.';</script>";
}else{
$email = $company_email;
$newas = $conn->query("SELECT * FROM `company` WHERE `email` = '$email'");
echo $count = $newas->num_rows;
if($count == ''){
$body = "http://more-acc.com/email/user_email.php?name=".urlencode($name)."&username=".urlencode($company_email);
?>
<script> 
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                alert(this.responseText);
            }
        };
        xmlhttp.open("GET", "http://vatguru.info/mail/PHP/examples/url_mail.php?email_to=<?php echo $company_email; ?>&email_subject=Welcome To More Accounts&email_body=<?php echo urlencode($body); ?>", true);
        xmlhttp.send();
</script>
<?php
if(isset($_SESSION['plan_name'])){
  $account_plan_name = $_SESSION['plan_name'];
}
if(isset($account_plan_name) && $account_plan_name == 'prime3'){
  $second_company_name = $_POST['second_company_name'];
  $second_company_email = $_POST['second_company_email'];
  $third_company_name = $_POST['third_company_name'];
  $third_company_email = $_POST['third_company_email'];  
echo cust_ins($primary_name,$msname,$company_name,$company_email,$second_company_name,$second_company_email,$third_company_name,$third_company_email,$address,$mobile,$password,$promo_code);
}elseif(isset($account_plan_name) && $account_plan_name == 'prime2'){
  $second_company_name = $_POST['second_company_name'];
  $second_company_email = $_POST['second_company_email'];
echo cust_ins($primary_name,$msname,$company_name,$company_email,$second_company_name,$second_company_email,'','',$address,$mobile,$password,$promo_code);
}else{
echo cust_ins($primary_name,$msname,$company_name,$company_email,'','','','',$address,$mobile,$password,$promo_code);
}
/////////////////////////////////////////////////////////////////////////////////////////
                                     //first company
/////////////////////////////////////////////////////////////////////////////////////////
$conn->query("INSERT INTO `user`(`user_name`, `email`, `password`, `address`, `phone1`, `access_level`,`promo_code` , `active`, `status`, `company_email`) VALUES ('$name','$company_email','$password','$address','$mobile','admin', '$promo_code','active','active','$company_email')");
$sql = "INSERT INTO `company` (`img_url` , `company_name` , `address` ,`city` , `state` , `country` , `phone` ,`mobile` , `fax` , `email` , `website` , `tax_number` , `document_formate` , `account_currenccy` , `default_location` , `auto_nmbering` , `reset_account` , `delete_account` , `company_email`,`expiry_date`)VALUES ('emoji/46451d222301bdaa4e6711a96831482d.jpg',  '$company_name',  '',  '',  '', '',  '',  '',  '',  '$email',  '',  '',  '',  'AED', '',  '',  '',  '',  '$email','$e_date1') ";
$conn->query($sql);


/////////////////////////////////////////////////////////////////////////////////////////
                                     //first company
/////////////////////////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////////////////////////
                                     //Second company
/////////////////////////////////////////////////////////////////////////////////////////
if(isset($account_plan_name) && $account_plan_name == 'prime2'){
  $company_name = $_POST['second_company_name'];
  $company_email = $_POST['second_company_email'];
$email = $company_email;
$conn->query("INSERT INTO `user`(`user_name`, `email`, `password`, `address`, `phone1`, `access_level`,`promo_code` , `active`, `status`, `company_email`) VALUES ('$name','$company_email','$password','$address','$mobile','admin', '$promo_code','active','active','$company_email')");
$sql = "INSERT INTO `company` (`img_url` , `company_name` , `address` ,`city` , `state` , `country` , `phone` ,`mobile` , `fax` , `email` , `website` , `tax_number` , `document_formate` , `account_currenccy` , `default_location` , `auto_nmbering` , `reset_account` , `delete_account` , `company_email`,`expiry_date`)VALUES ('emoji/46451d222301bdaa4e6711a96831482d.jpg',  '$company_name',  '',  '',  '', '',  '',  '',  '',  '$email',  '',  '',  '',  'AED', '',  '',  '',  '',  '$email','$e_date1') ";
$conn->query($sql);
}
/////////////////////////////////////////////////////////////////////////////////////////
                                     //Second company
/////////////////////////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////////////////////////
                                     //Third company
/////////////////////////////////////////////////////////////////////////////////////////
if(isset($account_plan_name) && $account_plan_name == 'prime3'){
  $company_name = $_POST['third_company_name'];
  $company_email = $_POST['third_company_email'];
$email = $company_email;
$conn->query("INSERT INTO `user`(`user_name`, `email`, `password`, `address`, `phone1`, `access_level`,`promo_code` , `active`, `status`, `company_email`) VALUES ('$name','$company_email','$password','$address','$mobile','admin', '$promo_code','active','active','$company_email')");
$sql = "INSERT INTO `company` (`img_url` , `company_name` , `address` ,`city` , `state` , `country` , `phone` ,`mobile` , `fax` , `email` , `website` , `tax_number` , `document_formate` , `account_currenccy` , `default_location` , `auto_nmbering` , `reset_account` , `delete_account` , `company_email`,`expiry_date`)VALUES ('emoji/46451d222301bdaa4e6711a96831482d.jpg',  '$company_name',  '',  '',  '', '',  '',  '',  '',  '$email',  '',  '',  '',  'AED', '',  '',  '',  '',  '$email','$e_date1') ";
$conn->query($sql);

}
/////////////////////////////////////////////////////////////////////////////////////////
                                     //Third company
/////////////////////////////////////////////////////////////////////////////////////////

echo "user created successfully....... Thanks for choosing More Accounts.";
session_unset();
session_destroy();
echo "<script>window.location.href = '../registration.php?done=done';</script>";
}
}//checking user already register
}else{
echo "<script>window.location.href = '../registration.php?error=Password doesn't match.';</script>";
}
}
}
?>