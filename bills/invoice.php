<?php include('../../db.php'); 
$id = $_REQUEST['id'];
?>

<!DOCTYPE html>
<html><head>

<style type="text/css">
.name{
position: absolute;
margin-top: -12px;
margin-left: 200px;
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


}
.paid_head{
  background-color:rgba(255, 216, 198, 0.7);
    position: absolute;
        opacity: 0.5;
width: 95%; height: 40vh;
  }
  th{
    text-align: left;
  }
  .order-lines-outer{
    min-height: 400px!important;
  }
  .value{
    min-width: 200px;
  }
  .label-subtotal{
   font-weight: bold; 
   text-align: left;
   float: left;
  }
  .bottom-document-item .subtotal{
    float: right;
    width: 50% !important;
  }
  tr{
    border: solid 1px black;
  }
</style>

  </head>


<?php
$sql = "SELECT * FROM `transaction` WHERE `id` = '$id' AND `company_email` = '$company_email'";
$new = $conn->query($sql);
$row = $new->fetch_assoc();
$name_id = $row['name_id'];

$sqli = "SELECT * FROM `vendor` WHERE `id` = '$name_id'";
$newi = $conn->query($sqli);
$rowi= $newi->fetch_assoc();
  ?>


    <div class="content" ng-style="fontStyle()" style="font-family: Arial, Arial, Helvetica, sans-serif; font-size: 14px; line-height: 18px; color: rgb(0, 0, 0); width: 97%;  height:500px; overflow-y:scroll;" >
<div class="document clearfix" id="yahi_print" style="border:none;  background-color: #cacdd1; margin-top: 55px;margin-top:0px;">
   <?php if($row['status'] == "paid" ){ ?>
<div  class="paid_head">
<h2 class="paid">PAID</h2>
</div><?php } ?>
	    <div class="wrap"  id="content" style="padding:20px; padding-top:30px;   background-color: white;">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="view.css">

<style type="text/css">
  tr:nth-child(even) {background: #fff;border-left:none !important;border-bottom:1px solid #ccc !important;  }
tr:nth-child(odd) {background: #fff; }
.document-type{text-transform:capitalize;}
</style>


<style type="text/css">
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
.paid_head{
  background-color:rgba(255, 216, 198, 0.7);
    position: absolute;
        opacity: 0.5;
width: 95%; height: 40vh;
  }
  th{
    text-align: left;
  }
  .order-lines-outer{
    min-height: 400px!important;
  }
  .value{
    min-width: 200px;
  }
  .label-subtotal{
   font-weight: bold; 
   text-align: left;
   float: left;
  }
  .bottom-document-item .subtotal{
    float: right;
    width: 50% !important;
  }
  tr{
    border: solid 1px black;
  }

@media only screen and (min-width: 600px) and (max-width: 4000px){
.headdd{
font-size: 25px; margin-top: 2px; margin-bottom: 2px;margin-left: -250px; text-transform: upset; font-weight: bold;  
}
.image_logo{
  max-width: 200px;
}
}
@media only screen and (min-width: 300px) and (max-width: 599px){
.headdd{
font-size: 15px; margin-top: 2px; margin-bottom: 2px;margin-left: -150px; text-transform: upset; font-weight: bold;  
}
}
</style>

        <div class="document-top clearfix" style="">
            <div class="info document-info-outer pull-right">
                    <p class="document-type headdd" ng-hide="document_setting.label.purchase_order.length">
                        <?php echo $row['cat_type']; ?>

                    </p>

                    <h5 id="document-type" class="document-ref">
                    No:&nbsp;  	<?php echo $row['transaction_number']; ?><br>
                      <label>Date: <?php echo $row['date']; ?></label>

                    </h5>
                    

                </div>

                <div class="document-info date-document">
  	
                </div>

            







            <div class="company-information clearfix">
<!--                <img class="logo" src="https://app.oneup.com/customization-proxy?document_type=purchase_order&amp;template_id=1">
-->
                <div class="info company-info">
                    <div class="col-sm-12">
                    
                      <div class="col-sm-8">
                            <img src="https://www.selectaccount.com/wp-content/themes/selectaccount/img/select-account-logo-text.png" alt="" class="image_logo">
                          <p  class="name">
                             <span> <?php echo $rowi['company_name']; ?> </span>
                          </p>
                      </div>
                      
                      <div class="col-sm-4" align="right">
                        <h3 class="name"  ><?php echo $row['cat_type']; ?></h3>
                      </div>

                    </div>
<hr>
   <br>
                    <?php echo $rowi['country']; ?>

                </div>
            </div>

            <div id="third-party-info" data-third-party-id="" style="display: none;"></div>

            <div class="info address-company-customer">
                <div class="info-customer">
                <br>
                <div class="info-customer shipping-info-customer" style="float: right;">
                    <div >
                        <label class="address-type-text" >
                            Shipping address
                        </label>
                        <label class="address-type-text" ></label>
                        <div class="bloc-address">
                            
                         <?php echo $rowi['company_name']; ?>




                         <?php echo $rowi['delivery_address']; ?>,
<br>
                         <?php echo $rowi['city']; ?>,
<br>
                         <?php echo $rowi['country']; ?>,



                        </div>
                    </div>
                    &nbsp;
                </div>

                    <div class="more-info"  >
                        Phone
                        : <?php echo $rowi['phone']; ?>
                    </div>
                    <label class="address-type-text"> Address</label>

                    <div class="bloc-address" style="max-width: 150px;">

                    <?php echo $rowi['country']; ?>
                    <br>

                   <?php echo $rowi['address']; ?>

                    </div>
                   
                </div>

                
            </div>
        </div>

        <div class="order-lines-outer"><br><br>

              <table class="order-lines" style="width: 100%;">
  <thead  style="background-color: rgb(240, 240, 240);">
    <tr>
      <th class="column description-column text-left" >Item name &amp; description</th>
      <th class="column description-column text-left"></th>


      <th class="column quantity-column text-center">Qty.</th>

    <th class="column unit-price-column text-right" >price</th>
    <th class="column unit-price-column text-right" >Vat (%)</th>

          <th class="column total-column text-right" id="total_header">Amount</th>
    </tr>
  </thead>

    <tbody >
<?php
$sll = "SELECT * FROM `purchase_item` WHERE `purchase_id` = '$id' ORDER BY `id` ASC";
$nww = $conn->query($sll);
while($rww = $nww->fetch_assoc()){
?>
<tr ng-repeat="x in purchase_item">
   <td class="column description-column text-left">
        <div class="item-name">
    <span ></span>&nbsp;
                    <?php echo $rww['item_name']; ?>,
  <span style="font-weight:normal;"><br>    
<?php echo $rww['item_description']; ?>&nbsp;   
    </span>
</div>
   </td>
<td></td>
      <td class="column quantity-column text-center" >
                   <?php echo $rww['item_quantity']; ?>

            </td>
    <td class="column unit-price-column text-right" >
<span >
                   <?php echo $rww['price_rate']; ?>
</span>
        <div>
        </div>
      </td>
    <td class="column unit-price-column text-right" >
<span >
                   <?php echo $rww['vat']; ?>%
</span>
        <div>
        </div>
      </td>      <td class="column total-column text-right" id="total_header">
                   <?php echo $rww['amount']; ?>
      </td>
    </tr>
<?php } ?>
    
</tbody></table>

        </div>
        <div style="text-align: right;">
              <div class="document-bottom">

  <div class="bottom-document-item subtotal">
      <label class="label-subtotal">
  Subtotal
</label>
<label class="value">
<?php echo $row['subtotal']; ?>
 	 </label>

  </div>

  <div class="bottom-document-item subtotal">
      <label class="label-subtotal">
  Discount
</label>
<label class="value">
<?php echo $row['disc_amount']; ?>
   </label>

  </div>
  <div class="bottom-document-item subtotal">
      <label class="label-subtotal">
  VAT
</label>
<label class="value">
<?php echo $row['vat']; ?>
   </label>

  </div>

  <div class="bottom-document-item total" style="background-color: rgb(240, 240, 240);">
  <label class="label-subtotal">
  Total
</label>
<label class="value">
                   <?php echo $row['total']; ?>
</label>

  </div>
</div>


        </div>

 <img src="" id="img">

      </div>
    </div>
  </div>
</div>

<!----------------------model box for add custumer ------------- -->


  <script type="text/javascript">
    function saveCustomization(callback) {
        angular.element(document.getElementsByTagName("body")).).$apply(function ( {
            save(callback);
        });
    }

    <!-- IE11 focus issue -->
    $(document).ready(function () {
        var firstInput = $("input[type=text]").first();
        firstInput.focus();
        setTimeout(function () {
            firstInput.blur();
            $(".colorpicker").hide();
        }, 1);
    });

    $('.panel-group').on('show.bs.collapse', function (e) {
        $(e.target).prev('.panel-heading').addClass('selected');
    });

    $('.panel-group').on('hide.bs.collapse', function (e) {
        $(e.target).prev('.panel-heading').removeClass('selected');
    });*/

</body></html>