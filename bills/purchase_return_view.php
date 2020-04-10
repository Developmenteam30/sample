<?php include('../db.php'); 
$id = $_REQUEST['id'];
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" >

<!-- Latest compiled and minified JavaScript -->
<link rel="stylesheet" type="text/css" href="style.css">

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" ></script>

<style type="text/css">
  
/*----------------------------------------------------------------------*/



</style>

<style type="text/css">
    .com_sligan
    {
        vertical-align: bottom;
    }
    .print_tablle td{
        padding: 4px;
    }
    .print_tablle td,tr
    {
      border: none;
      background-color: white;
    }
    .print_tablle
    {
        border: 1px solid black;
        width: 100%;
        overflow-x: scroll !important;

    }
    .print_tablle .head 
    {
            border-bottom: 1px solid black;
    }
    .print_tablle th 
    {
            padding: 5px !important;
    }

    .print_tablle .foot 
    {
            border-top: 1px solid black !important;
    }

    .print_tablle tr:nth-child(even) {
        border-left: none !important;
        border-bottom: none !important;
    }
    .bot_col{
        font-weight: bold;
            border-top: 1px solid black;
    }
      .paid {
    -ms-transform: rotate(-8deg); /* IE 9 */
    -webkit-transform: rotate(-8deg); /* Chrome, Safari, Opera */
    transform: rotate(-8deg);
    font-weight: bolder;
    color: #d34b0c;
    border: solid 4px red;
    padding: 30px;
    font-size: 50px;
    text-align: center; 
    left: 35%;
    position: absolute;


}
.paid_head p{
    font-size: 15px;
  }

@media print
{    
    @page {
  size: auto !important;
  margin: 0 !important;
       }
   .print_tablle *
   { 
    width: 100% !important;
    height: 700px !important;
   }
   .tab_div{
    margin-right:  140px;
   }
}

/******************************MINION CSS ********************************/
.btn{
  padding: 1px 1px !important;
}
</style>
</head>
<div style="padding: 0px; background: white;"  id="yahi_print">
<?php
$sql = "SELECT * FROM `transaction` WHERE `id` = '$id' AND `company_email` = '$company_email'";
$new = $conn->query($sql);
$row = $new->fetch_assoc();
$name_id = $row['name_id'];
$bank_id = $row['bank_id'];


$sqlj = "SELECT * FROM `company` WHERE `email` = '$company_email'";
$newj = $conn->query($sqlj);
$rowj= $newj->fetch_assoc();

$sqli = "SELECT * FROM `vendor` WHERE `id` = '$name_id'";
$newi = $conn->query($sqli);
$rowi= $newi->fetch_assoc();

$sqlb = "SELECT * FROM `coa_list` WHERE `id` = '$bank_id'";
$newb = $conn->query($sqlb);
$rowb= $newb->fetch_assoc();

  ?>
<!--/////////header//////////-->
    <div class="container paid_head" style="max-width: 700px; min-height: 100px; margin-right: 0px; margin-left: 0px; <?php if($row['status'] == "paid" ){ echo "background:rgba(255, 216, 198, 0.7); "; } ?> ">
  
        <div class="row" >
    <?php if($row['status'] == "paid" ){ ?>

            <div class="col-md-4 col-sm-4 col-xs-4" style="padding-top: 30px;">
                <img src="<?php echo $rowj['img_url']; ?>" style="width: 70 px!important; max-height: 70px;" onerror="this.src='http://curveinfotech.com/assets/images/logo1.png'"> 
                <!--<span class="com_sligan">Company Slogan</span>-->
            </div>
            <div class="col-md-8 col-sm-8 col-xs-8">
                <h1 class="paid" style="opacity: 0;">PAID</h1>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-4" style="padding-top: 45px;">
                <h2  style="text-transform: uppercase;text-align: center;"><?php echo $row['cat_type']; ?></h2>
            </div>
    <?php } else {?>
            <div class="col-md-6 col-sm-6 col-xs-6" style="padding-top: 50px;">
                <img src="<?php echo $rowj['img_url']; ?>" style="max-width: 70px; max-height: 70px;"  onerror="this.src='http://curveinfotech.com/assets/images/logo1.png'">
                <span  style="font-weight: bold; font-size: 45px;"><?php echo $rowj['company_name']; ?></span>
                <!--<span class="com_sligan">Company Slogan</span>-->
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6" style="padding-top: 50px;">
                <h2  style="text-transform: uppercase;text-align: center;"><?php echo $row['cat_type']; ?></h2>

                <table style="width: 100%">
                  <tr style="font-weight: bold;border:1px solid #ccc;text-align: center;">
                    <td style="padding: 12px 33px 12px 33px;border:1px solid #ccc ">Date</td>
                    <td style="padding: 12px 33px 12px 33px "><?php echo date('d-m-Y',strtotime($row['date'])); ?></td>
                  </tr>
                  <tr style="font-weight: bold;border:1px solid #ccc;text-align: center;background-color: transparent !important;">
                    <td style="padding: 12px 33px 12px 33px;border:1px solid #ccc "><?php echo ucwords($row['cat_type']); ?></td>
                    <td style="padding: 12px 33px 12px 33px "><?php echo $row['transaction_number']; ?></td>
                  </tr>
                </table>


            </div>
    <?php } ?>
<br>
        </div>

    <div class="row" style="padding: 1px 1px 1px 20px;">
<br>
     <div class="col-md-5 col-sm-5 col-xs-5"  style="border:1px solid #000;padding: 0px 0px 0px 0px; margin-left: 5px;min-height: 190px;">
         <p align="left" style="font-weight: bold; padding-right: 20px;border-bottom: 1px solid#000; padding-left: 10px">Vendor</p>
         <div class="com_info">
             <p style="padding-left: 10px"><?php echo $rowi['contact_name']; ?>,<br>
             <?php echo $rowi['company_name']; ?>,<br>
             <?php echo $rowi['delivery_address']; ?>,<br>
             <?php echo $rowi['city']; ?>,<br>
             <?php echo $rowi['country']; ?></p>
             
         </div>
     </div>
<?php  if($row['cat_type'] == 'purchase Receipt' || ($row['cat_type'] == 'purchase return' && $row['return_type'] == 'Bank Payment')){  ?>
     <div class="col-md-5 col-sm-5 col-xs-5" style="border:1px solid #000; margin-left: 15%;;padding: 0px 0px 0px 0px;min-height: 190px">
         <p align="left" style="font-weight: bold; padding-right: 20px;border-bottom: 1px solid#000;padding-left: 10px">Bank Details</p>
         <div class="indate" >
             <p style="padding-left: 10px;padding-top: 6px;"><div class="col-md-6 col-sm-6 col-xs-6"><b>Bank Name:</b></div> 
             <div class="col-md-6 col-sm-6 col-xs-6">(<?php echo $rowb['code']; ?>)</div>
             <div class="col-md-4 col-sm-4 col-xs-4"></div>
             <div class="col-md-8 col-sm-8 col-xs-8"><?php echo $rowb['accounts_name']; ?>,<br></div>
             <div class="col-md-6 col-sm-6 col-xs-6" style="padding-top: 5px"><b>Check No:</b></div> 
             <div class="col-md-6 col-sm-6 col-xs-6" style="padding-top: 5px"><?php echo $row['cheque_no']; ?><br><br></div> 
             <div class="col-md-6 col-sm-6 col-xs-6"><b>Check Date:</b></div> 
             <div class="col-md-6 col-sm-6 col-xs-6"><?php echo date('d-m-Y',strtotime($row['date'])); ?></div> 
             </p>
         </div>
     </div>
    </div>
<?php } ?>
<!--
  <table class="print_tablle" style="width: 100% !important;  border:solid 1px black;">
    <thead>
      <tr class="head" style="border-bottom: solid 1px black;">
        <th style=" border:1px solid #000;">Sales Rep</th>
        <th style=" border:1px solid #000;">P.o number</th>
        <th style=" border:1px solid #000;">Due Date</th>
        <th style=" border:1px solid #000;">Ship Date</th>
        <th style=" border:1px solid #000;">Ship Via</th>
        <th style=" border:1px solid #000;">Terms</th>
        <th style=" border:1px solid #000;">F.O.B.</th>
      </tr>

      <rowgroup>
    <col style="width: 14.33%">
    <col style="width: 14.33%">
    <col style="width: 14.33%">
    <col style="width: 14.33%">
    <col style="width: 14.33%">
    <col style="width: 14.33%">
    <col style="width: 14.33%">
   </rowgroup>
    </thead>

    <tbody>
      <tr class="head" style="border: solid 1px black;">
        <td style=" border:1px solid #000;"><?php echo $row['cat_type']; ?></td>
        <td style=" border:1px solid #000;"><?php echo $row['transaction_number']; ?></td>
        <td style=" border:1px solid #000;"><?php echo $row['due_date']; ?></td>
        <td style=" border:1px solid #000;"><?php echo $row['date']; ?></td>
        <td style=" border:1px solid #000;"><?php echo $row['transaction_number']; ?></td>
        <td style=" border:1px solid #000;"><?php echo $row['transaction_number']; ?></td>
        <td style=" border:1px solid #000;"><?php echo $row['transaction_number']; ?></td>
      </tr>
    </tbody>
  </table>                                          
 --> 
 <br><br><br>
<div class="col-sm-12 hatjabeayame" style="max-width: 710px; margin-bottom: 40px; margin-top: 20px;padding: 150px 5px 0px 5px;">

  <table class="print_tablle" style="width: 100% !important;  border:none !important; border-top: 1px solid #000 !important; border-bottom:  1px solid #000 !important;">
    <thead>
      <tr class="head" style="border:none;border-bottom: solid 1px black !important; border-top: solid 1px black !important;">
        <th style=" border:none;">ITEM NAME &amp; DESCRIPTION</th>
        <th style=" border:none;text-align: right;">Qty. &nbsp;</th>
        <th style=" border:none;text-align: right;">PRICE &nbsp;</th>
        <th style=" border:none;text-align: right;">VAT(%)</th>
        <th style=" border:none;text-align: right;">TOTAL &nbsp;&nbsp;</th>
      </tr>

      <rowgroup>
    <col style="width: 40%">
    <col style="width: 10%">
    <col style="width: 16%">
    <col style="width: 15%">
    <col style="width: 19%">
    </rowgroup>
    </thead>
<style type="text/css" media="print">
@page {
    size: auto;   /* auto is the initial value */
    margin: 0;  /* this affects the margin in the printer settings */
    align-items: center;
}
.paid_head{
  max-width: 800px !important; 
}
.hatjabeayame{
  max-width: 800px !important; 

}
.footer{
  width: 100% !important;
  text-align: center !important; 
  position: fixed !important;
  bottom: 10px !important;
}
</style>
    <tbody>
<?php
$i=0;
$sll = "SELECT * FROM `purchase_item` WHERE `purchase_id` = '$id' AND `company_email` = '$company_email' ORDER BY `id` ASC";
$nww = $conn->query($sll);
while($rww = $nww->fetch_assoc()){
?>

      <tr class="active" style="height: 40px; border:none !important;">
        <td style=" border: none">
          <div class="item-name">
            <span style="font-weight: bold;">&nbsp;
            <?php echo $rww['item_name']; ?>,</span>
            <span style="font-weight:normal;"><br>    
            <?php echo substr($rww['item_description'], 0, 50); ?>&nbsp;   
            </span>
          </div>
        </td>
        <td style=" border:none;text-align: right;"><?php echo number_format($rww['item_quantity'], 2, '.', ','); ?></td>
        <td style=" border:none;text-align: right;"><?php echo  number_format($rww['price_rate'], 2, '.', ','); ?></td>
        <td style=" border:none;text-align: right;"><?php echo $rww['vat']; ?>%</td>
        <td style=" border:none;text-align: right;"><?php echo number_format($rww['amount'], 2, '.', ','); ?> &nbsp;</td>
      </tr>
<?php $i++; } ?>
<?php if($i < '12'){ 
        for($i = $i; $i<13; $i++){ ?>
      <tr class="active" style="height: 30px; color: white !important; border:none !important;>
        <td><span style="opacity: 0;color:white !important"></span></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
<?php   } } 
$fdf = number_format($row['vat'], 2, '.', ',');
?>      
      <tr class="foot" style="border-top:solid 1px black; border-bottom:1px solid black !important; border:none !important;">
        <td colspan="3"   class="bot_col" style="border: none;border-top:solid 1px black !important;text-align: center;"></td>
        <td  class="" style="border: none;border-top:solid 1px black !important;text-align: left;">VAT:</td>
        <td class=""  style="border: none;border-top:solid 1px black !important;text-align: right;"><?php echo number_format($row['vat'], 2, '.', ','); ?></td>
      </tr>

<?php if($row['disc_amount'] != '0') { ?>
      <tr class="foot" style="border-top:solid 1px black; border-bottom:1px solid #ccc !important; border:none !important;">
        <td colspan="3"   class="" style="border: none;"></td>
        <td  class="" style="border: none;border-top:solid 1px #ccc !important;text-align: left;">DISCOUNT:</td>
        <td class=""  style="border: none;border-top:solid 1px #ccc !important;text-align: right;"><?php echo number_format($row['disc_amount'], 2, '.', ','); ?></td>
      </tr>
<?php } ?>
      <tr class="foot" style="border-top:solid 1px #ccc; border-bottom:1px solid black !important; border:none !important;">
        <td colspan="3"   class="bot_col" style="border: none"></td>
        <td  class="bot_col" style="border: none;border-top:solid 1px #ccc !important;text-align: left;">TOTAL:</td>
        <td class="bot_col"  style="border: none;border-top:solid 1px #ccc !important;text-align: right;"><?php echo money_format("%i",$row['total']); ?></td>
      </tr>

    </tbody>
  </table>
  <center>
  <div class="footer" style="margin-top: 90px;  border-top:1px solid #ccc !important;"><?php echo $rowj['adderss'].",".$rowj['city'].",".$rowj['state'].",".$rowj['country'].",".$rowj['phone'].",".$rowj['mobile']; ?></div></center>
</div>

<!--/////////content//////////-->

<!--//////////////footer//////////////-->

<!--//////////////footer//////////////-->



</div>
</div>
</html>