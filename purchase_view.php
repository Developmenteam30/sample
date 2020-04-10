 <?php 
session_start();
include('db.php');
?>
<!DOCTYPE html>
<html><head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">


<div style="min-height: 500px">
    <link rel="stylesheet" href="./bootstrap.min.css">
    <style>
      @media screen,
      print {
        @charset "UTF-8";
.clearfix {
  *zoom: 1; }

.clearfix:before,
.clearfix:after {
  display: table;
  content: ""; }

.clearfix:after {
  clear: both; }

.nowrap {
  white-space: nowrap; }

.text-right {
  text-align: right; }

.text-center {
  text-align: center; }

.text-left {
  text-align: left; }

.pull-left {
  float: left; }

.pull-right {
  float: right; }

address {
  font-style: normal; }

h1, h2, h3, h4, h5, h6 {
  font-family: inherit; }

#footer {
  border-top: 1px solid #ddd;
  padding-top: 10px;
  margin-top: 10px; }
  #footer .footnote {
    margin-bottom: 5px; }
  #footer div, #footer pre {
    text-align: center;
    font-size: 11px;
    color: #888;
    word-break: normal; }
  #footer .company-id {
    display: inline; }
  #footer .company-id:after {
    content: '·'; }
  #footer .company-id:last-child:after {
    content: ''; }

body:before {
  content: "";
  float: left;
  width: 0;
  margin-top: -32767px; }

html {
  min-height: 100%;
  margin: 0; }

body {
  min-height: 100%; }

label {
  font-weight: normal; }

.content {
  font-family: Arial, Helvetica, sans-serif;
  height: 100%;
  font-size: 14px; }
  .content .document {
    background: #ffffff;
    min-height: 100%; }
    .content .document .wrap {
      overflow: auto;
      padding-bottom: 0px; }
      .content .document .wrap #footer {
        position: relative;
        clear: both; }

.document {
  padding: 20px;
  font-size: 1em; }
  .document a {
    text-decoration: none;
    color: inherit; }
  .document .document-top {
    margin-bottom: 20px; }
    .document .document-top img.logo {
      margin-left: 0;
      margin-right: 10px;
      max-width: 300px;
      max-height: 100px;
      vertical-align: top;
      margin-top: 5px; }
    .document .document-top .info label {
      display: block; }
    .document .document-top .info .name {
      font-weight: bold;
      font-size: 1.7em;
      margin: 0; }
    .document .document-top .company-information {
      min-height: 120px; }
      .document .document-top .company-information div.company-info {
        margin-left: 0;
        margin-top: 5px; }
        .document .document-top .company-information div.company-info .name {
          font-weight: bold;
          margin: 0; }
        .document .document-top .company-information div.company-info .more-info {
          font-size: 0.85em; }
    .document .document-top .document-info {
      text-align: right; }
    .document .document-top .document-info-outer {
      font-size: 1em;
      width: 35%; }
    .document .document-top .document-specific-info h1.document-type {
      font-size: 2em;
      line-height: 30px;
      text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);
      text-transform: uppercase;
      font-weight: bold;
      margin: 0;
      word-break: break-word; }
    .document .document-top .document-specific-info h2.document-ref {
      margin: 0;
      font-size: 1.2em;
      font-weight: normal;
      line-height: 19px; }
    .document .document-top .date-document {
      margin-top: 3px;
      margin-bottom: 5px; }
    .document .document-top .address-company-customer {
      margin-top: 10px;
      margin-left: 0; }
      .document .document-top .address-company-customer div.info-customer {
        display: inline-block;
        vertical-align: top;
        width: 45%; }
        .document .document-top .address-company-customer div.info-customer.shipping-info-customer {
          margin-left: 20px; }
          .document .document-top .address-company-customer div.info-customer.shipping-info-customer.push-left {
            margin-left: 0;
            margin-right: 20px;
            float: left; }
        .document .document-top .address-company-customer div.info-customer label.address-type-text {
          display: inline;
          font-size: 1em;
          text-decoration: underline;
          cursor: default; }
        .document .document-top .address-company-customer div.info-customer .bloc-address {
          margin-top: 5px; }
      .document .document-top .address-company-customer .name {
        font-size: 1em !important; }
  .document .bloc-addresses {
    width: 600px;
    margin: 0 auto; }
  .document .order-lines-outer {
    margin-top: 10px; }
    .document .order-lines-outer .order-line-top {
      font-size: 0.8em;
      text-align: right;
      font-weight: bold; }
      .document .order-lines-outer .order-line-top label {
        font-weight: normal; }
  .document .customer_code_block {
    margin-top: 15px; }
  .document thead tr {
    height: 32px;
    word-wrap: break-word; }
  .document table.order-lines {
    width: 100%;
    height: 150px;
    border-collapse: collapse; }
    .document table.order-lines td, .document table.order-lines thead {
      text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5); }
    .document table.order-lines thead {
      background: #F0F0F0;
      border-bottom: 1px solid #DDD;
      font-size: 1.1em; }
    .document table.order-lines tbody tr {
      border-bottom: 1px solid #efefef; }
    .document table.order-lines tbody tr:last-child {
      border-bottom: none; }
    .document table.order-lines td {
      font-size: 0.9em; }
    .document table.order-lines .column {
      padding: 5px 0 6px 10px;
      vertical-align: top; }
    .document table.order-lines .description-column {
      max-width: 375px; }
      .document table.order-lines .description-column p {
        max-width: 375px;
        white-space: pre-wrap;
        white-space: -moz-pre-wrap;
        white-space: -pre-wrap;
        white-space: -o-pre-wrap;
        word-wrap: break-word; }
    .document table.order-lines .small-description-column {
      width: 300px !important; }
      .document table.order-lines .small-description-column p {
        width: 300px !important; }
    .document table.order-lines .tax-column {
      width: 70px; }
    .document table.order-lines .quantity-column {
      width: 45px; }
    .document table.order-lines .date-column,
    .document table.order-lines .unit-price-column {
      width: 150px; }
    .document table.order-lines .total-column {
      width: 100px;
      padding-right: 5px !important; }
    .document table.order-lines .item-name {
      font-size: 1.1em;
      font-weight: bold; }
    .document table.order-lines .item-description {
      word-break: break-word;
      padding-left: 5px;
      color: #666; }
      .document table.order-lines .item-description p {
        margin: 0; }
  .document .document-bottom {
    display: inline-block;
    page-break-inside: avoid;
    border-top: 1px solid #DDD;
    padding-top: 5px;
    padding-bottom: 10px;
    clear: both;
    min-width: 350px; }
    .document .document-bottom div.bottom-document-item {
      padding: 0 0 0 7px;
      margin-bottom: 10px; }
      .document .document-bottom div.bottom-document-item span.tax-name {
        margin-right: 5px; }
      .document .document-bottom div.bottom-document-item span.tax-calculation {
        font-size: 1em;
        color: #888; }
      .document .document-bottom div.bottom-document-item:after {
        clear: both;
        content: "";
        display: block; }
    .document .document-bottom label {
      display: inline-block;
      text-align: left; }
    .document .document-bottom label.value {
      font-size: 1.1em;
      text-align: right;
      padding: 1px 5px 0 10px; }
    .document .document-bottom div.bottom-document-item.total {
      padding-top: 4px;
      padding-bottom: 2px;
      background: #EAEAEA;
      border-radius: 4px; }
    .document .document-bottom div.bottom-document-item.total label {
      font-size: 1.4em;
      font-weight: bold; }
      .document .document-bottom div.bottom-document-item.total label.label-subtotal {
        max-width: 180px; }
    .document .document-bottom div.bottom-document-item.subtotal label {
      font-weight: bold; }
    .document .document-bottom div.bottom-document-item label.label-subtotal {
      max-width: 230px;
      float: left; }
    .document .document-bottom div.bottom-document-item label.value {
      float: right; }
  .document .separator {
    clear: both; }

pre {
  font-family: inherit;
  font-size: 1em;
  margin: 0;
  white-space: pre-wrap;
  white-space: -moz-pre-wrap;
  white-space: -pre-wrap;
  white-space: -o-pre-wrap;
  word-wrap: break-word;
  background-color: #fff;
  border: none; }

#notes {
  display: inline-block;
  page-break-inside: avoid;
  font-size: 0.85em;
  width: 100%;
  background: #EAEAEA;
  border-radius: 4px; }
  #notes p {
    text-align: left;
    margin: 0;
    padding: 10px;
    white-space: pre-wrap;
    white-space: -moz-pre-wrap;
    white-space: -pre-wrap;
    white-space: -o-pre-wrap;
    word-wrap: break-word; }
  #notes .global {
    margin-bottom: 0; }

#bottom_left_data h2 {
  margin-top: 5px;
  font-size: 1.2em;
  font-weight: normal; }
#bottom_left_data > div {
  margin: 0 10px; }
#bottom_left_data #installments ul {
  margin: 0;
  padding-left: 10px; }
#bottom_left_data #payment_info_text {
  font-size: 0.9em;
  white-space: pre-line;
  white-space: -moz-pre-line;
  white-space: -pre-line;
  white-space: -o-pre-;
  word-wrap: break-word;
  margin-top: -15x; }
  #bottom_left_data #payment_info_text > p {
    margin: 0;
    display: inline; }

#bottom {
  display: inline-block;
  width: 100%; }
  #bottom #bottom-left {
    width: 366px;
    display: inline-block;
    float: right;
    margin-left: 5px; }
  #bottom #bottom-right {
    width: 100%; }

div.payment-info {
  margin-top: 0px;
  font-size: 1.1em;
  font-weight: bold; }

      }

      @media print {
        body {
  margin: 0 auto;
  background: transparent;
  font-family: Arial, Helvetica, sans-serif;
  height: 0;
  min-height: 0;
  width: 740px; }

* {
  border-color: #ddd !important; }

thead {
  border-color: #DDD !important; }

.content .document {
  padding: 0in 0.20in 0.20in 0.20in;
  min-height: 0;
  height: 0;
  position: static; }
  .content .document .wrap {
    overflow: hidden !important;
    padding-bottom: 0;
    min-height: 0;
    height: auto; }
  .content .document .company-info a {
    text-decoration: none;
    color: #333; }
  .content .document div.info-document h1.title {
    text-shadow: none; }
  .content .document div.info-document label.expiration-date {
    text-shadow: none; }
  .content .document table.order-lines {
    height: auto; }
    .content .document table.order-lines td, .content .document table.order-lines thead {
      text-shadow: none; }
    .content .document table.order-lines thead {
      background-color: #E0E0E0; }
    .content .document table.order-lines tr {
      page-break-inside: avoid; }
    .content .document table.order-lines .item-description {
      color: #444; }
  .content .document #footer {
    display: none; }
.content #footer {
  padding: 0 5px; }
  .content #footer div.footer-border {
    border-top-color: #bbb !important; }
.content .stamp, .content .stamp .text {
  border-color: #b61f24 !important; }
.content .stamp {
  margin-top: 45px; }

.editor, .colorpicker {
  display: none; }

#header-print {
  font-size: 10px;
  font-family: Arial;
  text-align: center;
  margin: 0px auto; }

      }
 .print{
color: blue !important;
font-size: 50px !important;
 }     
 .print:hover{
background-color:  blue !important;
color: white !important;
border-radius: 20% !important; 
 }   
  .print{
color: blue !important;
font-size: 50px !important;
 }     
 .print:hover{
background-color:  blue !important;
color: white !important;
border-radius: 20% !important; 
 }     
  
    </style>

<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


    <title>Purchase order </title>
  </head>

<center><a href=""><i class="fa fa-print print"  onClick="window.print();"></i></a>
</center>

<?php 
$purchase_id = $_REQUEST['purchase_id'];
$user_email= "amarjeet@gmail.com";
$sqll = "select * from `purchase_order` where `id` = '$purchase_id' and `company_email` = '$user_email'";
$news = $conn->query($sqll);
while($rows = $news->fetch_assoc()){
?>

    <div class="content" ng-style="fontStyle()" style="font-family: Arial, Arial, Helvetica, sans-serif; font-size: 14px; line-height: 18px; color: rgb(0, 0, 0);">
      <div id="printing-template-id" style="display:none;">1</div>
<div class="document clearfix">
    <div class="wrap">
        <div class="document-top clearfix">
            <div class="info document-info-outer pull-right">
                <div class="document-info document-specific-info">
                    <p class="document-type" ng-hide="document_setting.label.purchase_order.length" style="font-size: 30px">
                        Purchase Order

                    </p>

                    <h1 class="document-type ng-binding" ng-show="document_setting.label.purchase_order.length" style="display: none;">
                        
                    </h1>
                    <h2 id="document-number" class="document-ref">
                    no.&nbsp;<?php echo $rows['bill_number']; ?>
                    </h2>
                    
  <label ng-show="global_setting.display.project" ng-animate="&#39;fade&#39;">Date</label>

                </div>

                <div class="document-info date-document">
  	<?php echo date("d/m/y", $rows['date_time']); ?>
                </div>

            </div>

            







            <div class="company-information clearfix">
<!--                <img class="logo" src="https://app.oneup.com/customization-proxy?document_type=purchase_order&amp;template_id=1">
-->
                <div class="info company-info" ng-style="logoPlacement()">
<h3 class="name" ng-show="global_setting.display.company.name" ng-animate="&#39;fade&#39;">
                    <?php echo ucfirst($rows['vendor']); ?>
                     </h3>
                        <h3 class="name">
  
</h3>

,   <br>
                    <?php echo ucfirst($rows['vcountry']); ?>

                </div>
            </div>

            <div id="third-party-info" data-third-party-id="" style="display: none;"></div>

            <div class="info address-company-customer">
                <div class="info-customer">
                    <label class="address-type-text" ng-hide="global_setting.label.vendor_address.length">Vendor address</label>
                    <label class="address-type-text ng-binding" ng-show="global_setting.label.vendor_address.length" style="display: none;"></label>

                    <div class="bloc-address">
                        <div id="third-party-contact-info" data-third-party-contact-id="" style="display:none;"></div>

                        <h3 class="name">
                    <?php echo ucfirst($rows['vendor']); ?>
</h3>

                    <?php echo ucfirst($rows['vendor_address']); ?>

                    </div>
                    <div class="more-info" ng-show="global_setting.display.customer.phone" ng-animate="&#39;fade&#39;" >
                        Phone
                        :
                    <?php echo ucfirst($rows['vphone1']); ?>
                    </div>
                </div>

                <div class="info-customer shipping-info-customer" ng-class="(global_setting.display.billing.push_right===true) ? &#39;push-left&#39; : &#39;&#39;">
                    <div ng-show="global_setting.display.shipping.address" ng-animate="&#39;fade&#39;">
                        <label class="address-type-text" ng-hide="global_setting.label.shipping_address.length">
                            Shipping address
                        </label>
                        <label class="address-type-text ng-binding" ng-show="global_setting.label.shipping_address.length" style="display: none;"></label>
                        <div class="bloc-address">
                            
                    <?php echo ucfirst($rows['vendor']); ?>


<h3 class="name">
  
</h3>

                    <?php echo ucfirst($rows['vendor_address']); ?>,
<br>
                    <?php echo ucfirst($rows['vcity']); ?>,
<br>
                    <?php echo ucfirst($rows['vcountry']); ?>



                        </div>
                    </div>
                    &nbsp;
                </div>

            </div>
        </div>
        <div class="order-lines-outer">
            <div class="order-line-top">
                

            </div>
              <table class="order-lines">
  <thead ng-style="colorScheme()" style="background-color: rgb(240, 240, 240);">
    <tr>
      <th class="column description-column text-left" ng-hide="document_setting.label.description.length">Item name &amp; description</th>
      <th class="column description-column text-left ng-binding" ng-show="document_setting.label.description.length" style="display: none;"></th>

      <th class="column tax-column text-right">
      </th>

      <th class="column quantity-column text-center" ng-show="document_setting.display.product.quantity &amp;&amp; !document_setting.label.quantity.length">Qty.</th>
    <th class="column quantity-column text-center ng-binding" ng-show="document_setting.display.product.quantity &amp;&amp; document_setting.label.quantity.length" style="display: none;"></th>

    <th class="column unit-price-column text-right" ng-show="document_setting.display.product.price &amp;&amp; !document_setting.label.unit_price.length">Unit price</th>
    <th class="column unit-price-column text-right ng-binding" ng-show="document_setting.display.product.price &amp;&amp; document_setting.label.unit_price.length" style="display: none;"></th>

          <th class="column total-column text-right" id="total_header">Amount</th>
    </tr>
  </thead>

    <tbody>
<?php 
$sqll = "select * from `purchase_order_item` where `purchase_order_id` = '$purchase_id' and `company_email` = '$user_email'";
$news = $conn->query($sqll);
$sub_amount = '0';
while($rows = $news->fetch_assoc()){
$item_name = $rows['item_name'];
?>
<tr>
   <td class="column description-column text-left">
        <div class="item-name">
    <span ng-show="document_setting.display.product.number" ng-animate="&#39;fade&#39;"></span>&nbsp;
                    <?php echo ucfirst($rows['item_name']); ?>,
  <span style="font-weight:normal;">    
(<?php echo ucfirst($rows['discount_rate']); ?>
% off)  
    </span>
</div>
   </td>
<td></td>
      <td class="column quantity-column text-center" ng-show="document_setting.display.product.quantity">
                    <?php echo ucfirst($rows['item_quantity']); ?>,

            </td>
    <td class="column unit-price-column text-right" ng-show="document_setting.display.product.price">
                    <?php echo ucfirst($rows['price_rate']); ?>
<span ng-show="document_setting.display.product.measurement" ng-animate="&#39;fade&#39;">
/<?php echo ucfirst($rows['item_unit']); ?>,
</span>
        <div>
        </div>
      </td>
      <td class="column total-column text-right" id="total_header">
                    <?php echo ucfirst($rows['amount']); ?>
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
<?php
$sqll = "SELECT SUM(amount) AS Totaamount FROM purchase_order_item WHERE purchase_order_id = '$purchase_id' and company_email = '$user_email'";
$news = $conn->query($sqll);
$sub_amount = '0';
while($rows = $news->fetch_assoc()){
echo $Totaamount = $rows['Totaamount'];
  }
  ?>
 	 </label>

  </div>


  <div class="bottom-document-item total" ng-style="colorScheme()" style="background-color: rgb(240, 240, 240);">
  <label class="label-subtotal">
  Total
</label>
<label class="value">
<?php echo $Totaamount; ?>
</label>

  </div>
</div>


        </div>
        <div class="separator"></div>
        <div id="bottom">
            <div id="bottom-left">
                <div id="notes" ng-style="colorScheme()" style="background-color: rgb(240, 240, 240);">
                    <p ng-show="document_setting.notes.length" class="global ng-binding" style="display: none;"></p>
                </div>
            </div>
            <div id="bottom-right">
                
            </div>
        </div>
    </div>
      <!-- ngIf: global_setting.footer || global_setting.display.company.tax_id --><div id="footer" ng-if="global_setting.footer || global_setting.display.company.tax_id
  " class="ng-scope">
  <div class="footnote">
    <pre ng-show="global_setting.footer.length" class="ng-binding" style="display: none;"></pre>








  </div>
</div>


</div>

    </div>

    <?php
     }
       ?>

        <style>
    html {
  height: 100%; }

body {
	overflow-x: hidden;
  background-color: #f8f9fa;
  width: 100%;
  height: 100%; }
  body a {
    color: #2e709f; }
  body label {
    cursor: default; }

textarea {
  resize: none; }

.content {
  margin-top: 0;
  margin-right: 10px;
  width: 98%;
    display: inline-block; }
  .content .document {
    position: relative;
    border: 1px solid #e0e0e0;
    border-radius: 2px;
    box-shadow: 0px 1px 3px #E0E0E0; }

.editor {
  position: fixed;
  overflow-y: auto;
  height: 100%;
  margin: 0;
  display: inline-block;
  vertical-align: top;
  width: 30%; }
  .editor h4 {
    font-weight: normal; }
  .editor a.clear {
    float: right;
    cursor: pointer;
    margin-right: 10px;
    font-size: 13px; }
  .editor .picker {
    text-indent: -999px;
    cursor: pointer; }
  .editor .section {
    padding-bottom: 20px; }

.clear_button, .clear_button:hover {
  color: darkgray;
  text-decoration: none;
  font-size: 22px;
  right: 20px;
  top: 0;
  vertical-align: top;
  cursor: pointer;
  position: absolute; }

textarea + .clear_button,
textarea + .clear_button:hover {
  right: 32px; }

.clear_button_div input {
  padding-right: 20px; }

.panel-group {
  background: #ffffff;
  border: 1px solid #e5e5e5;
  margin-bottom: 25px; }
  .panel-group .panel {
    -webkit-border-radius: 0px;
    -moz-border-radius: 0px;
    border-radius: 0px;
    border: none;
    border-bottom: 1px solid #e0e0e0;
    margin-bottom: 0px;
    box-shadow: 0px 0px; }
  .panel-group .panel-heading {
    padding: 8px 15px;
    border-radius: 0px; }
    .panel-group .panel-heading a {
      text-decoration: none; }
    .panel-group .panel-heading:hover, .panel-group .panel-heading.selected {
      cursor: pointer;
      background-color: #2e709f; }
      .panel-group .panel-heading:hover a, .panel-group .panel-heading.selected a {
        color: white; }
  .panel-group .panel-body {
    padding: 5px 15px; }

.panel-heading:after {
  font-family: 'Glyphicons Halflings';
  float: right;
  color: #e5e5e5;
  content: "\e080"; }

.panel-heading.selected:after {
  content: "\e114"; }

.panel-group .panel + .panel {
  margin-top: 0px; }

.form-group {
  padding: 5px 0px;
  margin-bottom: 0px; }
  .form-group .control-label {
    font-weight: normal;
    text-align: left; }
  .form-group:hover, .form-group.selected {
    background-color: #F6F6F6; }

.onoffswitch {
  position: relative;
  width: 65px;
  padding-top: 3px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none; }

.onoffswitch-checkbox {
  left: -9999px;
  position: absolute; }

.onoffswitch-label {
  display: block;
  overflow: hidden;
  cursor: pointer;
  border: 1px solid #979798;
  border-radius: 5px; }

.onoffswitch-inner {
  width: 200%;
  margin-left: -100%;
  -moz-transition: margin 0.3s ease-in 0s;
  -webkit-transition: margin 0.3s ease-in 0s;
  -o-transition: margin 0.3s ease-in 0s;
  transition: margin 0.3s ease-in 0s; }

.onoffswitch-inner:before, .onoffswitch-inner:after {
  float: left;
  width: 50%;
  height: 21px;
  padding: 0;
  line-height: 21px;
  font-size: 10px;
  color: white;
  font-family: Trebuchet, Arial, sans-serif;
  font-weight: bold;
  -moz-box-sizing: border-box;
  -webkit-box-sizing: border-box;
  box-sizing: border-box; }

.onoffswitch-inner:before {
  content: "ON";
  padding-left: 5px;
  background-color: #2696c7;
  color: #FFFFFF; }

.onoffswitch-inner:after {
  content: "OFF";
  padding-right: 5px;
  background-color: #DBDDE0;
  color: #666666;
  text-align: right; }

.onoffswitch-switch {
  width: 31px;
  margin: 0px;
  background: #FFFFFF;
  border: 1px solid #979798;
  border-radius: 5px;
  position: absolute;
  height: 23px;
  bottom: 0;
  right: 34px;
  -moz-transition: all 0.3s ease-in 0s;
  -webkit-transition: all 0.3s ease-in 0s;
  -o-transition: all 0.3s ease-in 0s;
  transition: all 0.3s ease-in 0s;
  background-image: -moz-linear-gradient(cshow top, rgba(0, 0, 0, 0.1) 0%, transparent 100%);
  background-image: -webkit-linear-gradient(cshow top, rgba(0, 0, 0, 0.1) 0%, transparent 100%);
  background-image: -o-linear-gradient(cshow top, rgba(0, 0, 0, 0.1) 0%, transparent 100%);
  background-image: linear-gradient(cshow top, rgba(0, 0, 0, 0.1) 0%, transparent 100%); }

.onoffswitch-checkbox[disabled] + .onoffswitch-label .onoffswitch-inner:before {
  background: #7EC4E2; }

.onoffswitch-checkbox[disabled] + .onoffswitch-label .onoffswitch-inner:after {
  color: #A0A0A0; }

select[disabled], input[disabled], label[disabled], .onoffswitch-checkbox[disabled] + .onoffswitch-label {
  cursor: not-allowed !important;
  color: #A0A0A0 !important; }

.onoffswitch-checkbox:checked + .onoffswitch-label .onoffswitch-inner {
  margin-left: 0; }

.onoffswitch-checkbox:checked + .onoffswitch-label .onoffswitch-switch {
  right: 0px; }

.onoffswitch-checked .onoffswitch-inner {
  margin-left: 0; }

.onoffswitch-checked .onoffswitch-switch {
  right: 0px; }

.fade-hide, .fade-show {
  -webkit-transition: all cubic-bezier(0.25, 0.46, 0.45, 0.94) 0.5s;
  -moz-transition: all cubic-bezier(0.25, 0.46, 0.45, 0.94) 0.5s;
  -o-transition: all cubic-bezier(0.25, 0.46, 0.45, 0.94) 0.5s;
  transition: all cubic-bezier(0.25, 0.46, 0.45, 0.94) 0.5s; }

.fade-hide {
  opacity: 1; }

.fade-hide.fade-hide-active {
  opacity: 0; }

.fade-show {
  opacity: 0; }

.fade-show.fade-show-active {
  opacity: 1; }

.description-column {
  width: 275px !important; }
  .description-column p {
    width: 275px !important; }

.small-description-column {
  width: 200px !important; }
  .small-description-column p {
    width: 200px !important; }

    /*!
* Colorpicker for Bootstrap
*
* Copyright 2012 Stefan Petre
* Licensed under the Apache License v2.0
* http://www.apache.org/licenses/LICENSE-2.0
*
*/
.colorpicker-saturation {
  width: 100px;
  height: 100px;
  cursor: crosshair;
  float: left; }

.colorpicker-saturation i {
  display: block;
  height: 5px;
  width: 5px;
  border: 1px solid #000;
  -webkit-border-radius: 5px;
  -moz-border-radius: 5px;
  border-radius: 5px;
  position: absolute;
  top: 0;
  left: 0;
  margin: -4px 0 0 -4px; }

.colorpicker-saturation i b {
  display: block;
  height: 5px;
  width: 5px;
  border: 1px solid #fff;
  -webkit-border-radius: 5px;
  -moz-border-radius: 5px;
  border-radius: 5px; }

.colorpicker-hue, .colorpicker-alpha {
  width: 15px;
  height: 100px;
  float: left;
  cursor: row-resize;
  margin-left: 4px;
  margin-bottom: 4px; }

.colorpicker-hue i, .colorpicker-alpha i {
  display: block;
  height: 1px;
  background: #000;
  border-top: 1px solid #fff;
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  margin-top: -1px; }

.colorpicker-hue {

.colorpicker-alpha {
  display: none; }

.colorpicker {
  *zoom: 1;
  top: 0;
  left: 0;
  padding: 4px;
  min-width: 120px;
  margin-top: 1px;
  -webkit-border-radius: 4px;
  -moz-border-radius: 4px;
  border-radius: 4px; }

.colorpicker:before, .colorpicker:after {
  display: table;
  content: ""; }

.colorpicker:after {
  clear: both; }

.colorpicker:before {
  content: '';
  display: inline-block;
  border-left: 7px solid transparent;
  border-right: 7px solid transparent;
  border-bottom: 7px solid #ccc;
  border-bottom-color: rgba(0, 0, 0, 0.2);
  position: absolute;
  top: -7px;
  left: 6px; }

.colorpicker:after {
  content: '';
  display: inline-block;
  border-left: 6px solid transparent;
  border-right: 6px solid transparent;
  border-bottom: 6px solid #ffffff;
  position: absolute;
  top: -6px;
  left: 7px; }

.colorpicker div {
  position: relative; }

.colorpicker.alpha {
  min-width: 140px; }

.colorpicker.alpha .colorpicker-alpha {
  display: block; }

.colorpicker-color {
  height: 10px;
  margin-top: 5px;
  clear: both;
  background-position: 0 100%; }

.colorpicker-color div {
  height: 10px; }

.input-append.color .add-on i, .input-prepend.color .add-on i {
  display: block;
  cursor: pointer;
  width: 16px;
  height: 16px; }

</style>

<script type="text/javascript">
    /* =========================================================
 * bootstrap-colorpicker.js 
 * http://www.eyecon.ro/bootstrap-colorpicker
 * =========================================================
 * Copyright 2012 Stefan Petre
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ========================================================= */

/*
!function( $ ) {

  // Color object

  var Color = function(val) {
    this.value = {
      h: 1,
      s: 1,
      b: 1,
      a: 1
    };
    this.setColor(val);
  };

  Color.prototype = {
    constructor: Color,

    //parse a string to HSB
    setColor: function(val){
      val = val.toLowerCase();
      var that = this;
      $.each( CPGlobal.stringParsers, function( i, parser ) {
        var match = parser.re.exec( val ),
          values = match && parser.parse( match ),
          space = parser.space||'rgba';
        if ( values ) {
          if (space === 'hsla') {
            that.value = CPGlobal.RGBtoHSB.apply(null, CPGlobal.HSLtoRGB.apply(null, values));
          } else {
            that.value = CPGlobal.RGBtoHSB.apply(null, values);
          }
          return false;
        }
      });
    },

    setHue: function(h) {
      this.value.h = 1- h;
    },

    setSaturation: function(s) {
      this.value.s = s;
    },

    setLightness: function(b) {
      this.value.b = 1- b;
    },

    setAlpha: function(a) {
      this.value.a = parseInt((1 - a)*100, 10)/100;
    },

    // HSBtoRGB from RaphaelJS
    // https://github.com/DmitryBaranovskiy/raphael/
    toRGB: function(h, s, b, a) {
      if (!h) {
        h = this.value.h;
        s = this.value.s;
        b = this.value.b;
      }
      h *= 360;
      var R, G, B, X, C;
      h = (h % 360) / 60;
      C = b * s;
      X = C * (1 - Math.abs(h % 2 - 1));
      R = G = B = b - C;

      h = ~~h;
      R += [C, X, 0, 0, X, C][h];
      G += [X, C, C, X, 0, 0][h];
      B += [0, 0, X, C, C, X][h];
      return {
        r: Math.round(R*255),
        g: Math.round(G*255),
        b: Math.round(B*255),
        a: a||this.value.a
      };
    },

    toHex: function(h, s, b, a){
      var rgb = this.toRGB(h, s, b, a);
      return '#'+((1 << 24) | (parseInt(rgb.r) << 16) | (parseInt(rgb.g) << 8) | parseInt(rgb.b)).toString(16).substr(1);
    },

    toHSL: function(h, s, b, a){
      if (!h) {
        h = this.value.h;
        s = this.value.s;
        b = this.value.b;
      }
      var H = h,
        L = (2 - s) * b,
        S = s * b;
      if (L > 0 && L <= 1) {
        S /= L;
      } else {
        S /= 2 - L;
      }
      L /= 2;
      if (S > 1) {
        S = 1;
      }
      return {
        h: H,
        s: S,
        l: L,
        a: a||this.value.a
      };
    }
  };

  // Picker object

  var Colorpicker = function(element, options){
    this.element = $(element);
    var format = options.format||this.element.data('color-format')||'hex';
    this.format = CPGlobal.translateFormats[format];
    this.isInput = this.element.is('input');
    this.component = this.element.is('.color') ? this.element.find('.add-on') : false;

    this.picker = $(CPGlobal.template)
      .appendTo('body')
      .on('mousedown', $.proxy(this.mousedown, this));

    if (this.isInput) {
      this.element.on({
        'focus': $.proxy(this.show, this),
        'keyup': $.proxy(this.update, this)
      });
    } else if (this.component){
      this.component.on({
        'click': $.proxy(this.show, this)
      });
    } else {
      this.element.on({
        'click': $.proxy(this.show, this)
      });
    }
    if (format === 'rgba' || format === 'hsla') {
      this.picker.addClass('alpha');
      this.alpha = this.picker.find('.colorpicker-alpha')[0].style;
    }

    if (this.component){
      this.picker.find('.colorpicker-color').hide();
      this.preview = this.element.find('i')[0].style;
    } else {
      this.preview = this.picker.find('div:last')[0].style;
    }

    this.base = this.picker.find('div:first')[0].style;
    this.update();
  };

  Colorpicker.prototype = {
    constructor: Colorpicker,

    show: function(e) {
      this.update();
      this.picker.show();
      this.height = this.component ? this.component.outerHeight() : this.element.outerHeight();
      this.place();
      $(window).on('resize', $.proxy(this.place, this));
      if (!this.isInput) {
        if (e) {
          e.stopPropagation();
          e.preventDefault();
        }
      }
      $(document).on({
        'mousedown': $.proxy(this.hide, this)
      });

      this.element.trigger({
        type: 'show',
        color: this.color
      });
    },

    update: function(){
      this.color = new Color(this.isInput ? this.element.prop('value') : this.element.data('color'));
      this.picker.find('i')
        .eq(0).css({left: this.color.value.s*100, top: 100 - this.color.value.b*100}).end()
        .eq(1).css('top', 100 * (1 - this.color.value.h)).end()
        .eq(2).css('top', 100 * (1 - this.color.value.a));
      this.previewColor();
    },

    setValue: function(newColor) {
      this.color = new Color(newColor);
      this.picker.find('i')
        .eq(0).css({left: this.color.value.s*100, top: 100 - this.color.value.b*100}).end()
        .eq(1).css('top', 100 * (1 - this.color.value.h)).end()
        .eq(2).css('top', 100 * (1 - this.color.value.a));
      this.previewColor();
      this.element.trigger({
        type: 'changeColor',
        color: this.color
      });
    },

    hide: function(){
      this.picker.hide();
      $(window).off('resize', this.place);
      if (!this.isInput) {
        $(document).off({
          'mousedown': this.hide
        });
        if (this.component){
          this.element.find('input').prop('value', this.format.call(this));
        }
        this.element.data('color', this.format.call(this));
      } else {
        this.element.prop('value', this.format.call(this));
      }
      this.element.trigger({
        type: 'hide',
        color: this.color
      });
    },

    place: function(){
      var offset = this.component ? this.component.offset() : this.element.offset();
      this.picker.css({
        top: offset.top + this.height,
        left: offset.left
      });
    },

    //preview color change
    previewColor: function(){
      try {
        this.preview.backgroundColor = this.format.call(this);
      } catch(e) {
        this.preview.backgroundColor = this.color.toHex();
      }
      //set the color for brightness/saturation slider
      this.base.backgroundColor = this.color.toHex(this.color.value.h, 1, 1, 1);
      //set te color for alpha slider
      if (this.alpha) {
        this.alpha.backgroundColor = this.color.toHex();
      }
    },

    pointer: null,

    slider: null,

    mousedown: function(e){
      e.stopPropagation();
      e.preventDefault();

      var target = $(e.target);

      //detect the slider and set the limits and callbacks
      var zone = target.closest('div');
      if (!zone.is('.colorpicker')) {
        if (zone.is('.colorpicker-saturation')) {
          this.slider = $.extend({}, CPGlobal.sliders.saturation);
        }
        else if (zone.is('.colorpicker-hue')) {
          this.slider = $.extend({}, CPGlobal.sliders.hue);
        }
        else if (zone.is('.colorpicker-alpha')) {
          this.slider = $.extend({}, CPGlobal.sliders.alpha);
        } else {
          return false;
        }
        var offset = zone.offset();
        //reference to knob's style
        this.slider.knob = zone.find('i')[0].style;
        this.slider.left = e.pageX - offset.left;
        this.slider.top = e.pageY - offset.top;
        this.pointer = {
          left: e.pageX,
          top: e.pageY
        };
        //trigger mousemove to move the knob to the current position
        $(document).on({
          mousemove: $.proxy(this.mousemove, this),
          mouseup: $.proxy(this.mouseup, this)
        }).trigger('mousemove');
      }
      return false;
    },

    mousemove: function(e){
      e.stopPropagation();
      e.preventDefault();
      var left = Math.max(
        0,
        Math.min(
          this.slider.maxLeft,
          this.slider.left + ((e.pageX||this.pointer.left) - this.pointer.left)
        )
      );
      var top = Math.max(
        0,
        Math.min(
          this.slider.maxTop,
          this.slider.top + ((e.pageY||this.pointer.top) - this.pointer.top)
        )
      );
      this.slider.knob.left = left + 'px';
      this.slider.knob.top = top + 'px';
      if (this.slider.callLeft) {
        this.color[this.slider.callLeft].call(this.color, left/100);
      }
      if (this.slider.callTop) {
        this.color[this.slider.callTop].call(this.color, top/100);
      }
      this.previewColor();
      this.element.trigger({
        type: 'changeColor',
        color: this.color
      });
      return false;
    },

    mouseup: function(e){
      e.stopPropagation();
      e.preventDefault();
      $(document).off({
        mousemove: this.mousemove,
        mouseup: this.mouseup
      });
      return false;
    }
  }

  $.fn.colorpicker = function ( option, val ) {
    return this.each(function () {
      var $this = $(this),
        data = $this.data('colorpicker'),
        options = typeof option === 'object' && option;
      if (!data) {
        $this.data('colorpicker', (data = new Colorpicker(this, $.extend({}, $.fn.colorpicker.defaults,options))));
      }

        if (typeof option === 'string') data[option](val);
    });
  };

  $.fn.colorpicker.defaults = {
  };

  $.fn.colorpicker.Constructor = Colorpicker;

  var CPGlobal = {

    // translate a format from Color object to a string
    translateFormats: {
      'rgb': function(){
        var rgb = this.color.toRGB();
        return 'rgb('+rgb.r+','+rgb.g+','+rgb.b+')';
      },

      'rgba': function(){
        var rgb = this.color.toRGB();
        return 'rgba('+rgb.r+','+rgb.g+','+rgb.b+','+rgb.a+')';
      },

      'hsl': function(){
        var hsl = this.color.toHSL();
        return 'hsl('+Math.round(hsl.h*360)+','+Math.round(hsl.s*100)+'%,'+Math.round(hsl.l*100)+'%)';
      },

      'hsla': function(){
        var hsl = this.color.toHSL();
        return 'hsla('+Math.round(hsl.h*360)+','+Math.round(hsl.s*100)+'%,'+Math.round(hsl.l*100)+'%,'+hsl.a+')';
      },

      'hex': function(){
        return  this.color.toHex();
      }
    },

    sliders: {
      saturation: {
        maxLeft: 100,
        maxTop: 100,
        callLeft: 'setSaturation',
        callTop: 'setLightness'
      },

      hue: {
        maxLeft: 0,
        maxTop: 100,
        callLeft: false,
        callTop: 'setHue'
      },

      alpha: {
        maxLeft: 0,
        maxTop: 100,
        callLeft: false,
        callTop: 'setAlpha'
      }
    },

    // HSBtoRGB from RaphaelJS
    // https://github.com/DmitryBaranovskiy/raphael/
    RGBtoHSB: function (r, g, b, a){
      r /= 255;
      g /= 255;
      b /= 255;

      var H, S, V, C;
      V = Math.max(r, g, b);
      C = V - Math.min(r, g, b);
      H = (C === 0 ? null :
        V == r ? (g - b) / C :
          V == g ? (b - r) / C + 2 :
            (r - g) / C + 4
        );
      H = ((H + 360) % 6) * 60 / 360;
      S = C === 0 ? 0 : C / V;
      return {h: H||1, s: S, b: V, a: a||1};
    },

    HueToRGB: function (p, q, h) {
      if (h < 0)
        h += 1;
      else if (h > 1)
        h -= 1;

      if ((h * 6) < 1)
        return p + (q - p) * h * 6;
      else if ((h * 2) < 1)
        return q;
      else if ((h * 3) < 2)
        return p + (q - p) * ((2 / 3) - h) * 6;
      else
        return p;
    },

    HSLtoRGB: function (h, s, l, a)
    {
      if (s < 0) {
        s = 0;
      }
      var q;
      if (l <= 0.5) {
        q = l * (1 + s);
      } else {
        q = l + s - (l * s);
      }

      var p = 2 * l - q;

      var tr = h + (1 / 3);
      var tg = h;
      var tb = h - (1 / 3);

      var r = Math.round(CPGlobal.HueToRGB(p, q, tr) * 255);
      var g = Math.round(CPGlobal.HueToRGB(p, q, tg) * 255);
      var b = Math.round(CPGlobal.HueToRGB(p, q, tb) * 255);
      return [r, g, b, a||1];
    },

    // a set of RE's that can match strings and generate color tuples.
    // from John Resig color plugin
    // https://github.com/jquery/jquery-color/
    stringParsers: [
      {
        re: /rgba?\(\s*(\d{1,3})\s*,\s*(\d{1,3})\s*,\s*(\d{1,3})\s*(?:,\s*(\d+(?:\.\d+)?)\s*)?\)/,
        parse: function( execResult ) {
          return [
            execResult[ 1 ],
            execResult[ 2 ],
            execResult[ 3 ],
            execResult[ 4 ]
          ];
        }
      }, {
        re: /rgba?\(\s*(\d+(?:\.\d+)?)\%\s*,\s*(\d+(?:\.\d+)?)\%\s*,\s*(\d+(?:\.\d+)?)\%\s*(?:,\s*(\d+(?:\.\d+)?)\s*)?\)/,
        parse: function( execResult ) {
          return [
            2.55 * execResult[1],
            2.55 * execResult[2],
            2.55 * execResult[3],
            execResult[ 4 ]
          ];
        }
      }, {
        re: /#([a-fA-F0-9]{2})([a-fA-F0-9]{2})([a-fA-F0-9]{2})/,
        parse: function( execResult ) {
          return [
            parseInt( execResult[ 1 ], 16 ),
            parseInt( execResult[ 2 ], 16 ),
            parseInt( execResult[ 3 ], 16 )
          ];
        }
      }, {
        re: /#([a-fA-F0-9])([a-fA-F0-9])([a-fA-F0-9])/,
        parse: function( execResult ) {
          return [
            parseInt( execResult[ 1 ] + execResult[ 1 ], 16 ),
            parseInt( execResult[ 2 ] + execResult[ 2 ], 16 ),
            parseInt( execResult[ 3 ] + execResult[ 3 ], 16 )
          ];
        }
      }, {
        re: /hsla?\(\s*(\d+(?:\.\d+)?)\s*,\s*(\d+(?:\.\d+)?)\%\s*,\s*(\d+(?:\.\d+)?)\%\s*(?:,\s*(\d+(?:\.\d+)?)\s*)?\)/,
        space: 'hsla',
        parse: function( execResult ) {
          return [
            execResult[1]/360,
            execResult[2] / 100,
            execResult[3] / 100,
            execResult[4]
          ];
        }
      }
    ],
    template: '<div class="colorpicker dropdown-menu">'+
      '<div class="colorpicker-saturation"><i><b></b></i></div>'+
      '<div class="colorpicker-hue"><i></i></div>'+
      '<div class="colorpicker-alpha"><i></i></div>'+
      '<div class="colorpicker-color"><div /></div>'+
      '</div>'
  };

}( window.jQuery )

    'use strict';

angular.module('myerpCustomization', ['myerpCustomization.controllers', 'myerpCustomization.directives']);




    'use strict';

//Function that test if placeholder is supported or not by the browser
jQuery.support.placeholder = (function(){
    var i = document.createElement('input');
    return 'placeholder' in i;
})();


/* Directives 

angular.module('myerpCustomization.directives', [])
    //Placeholder for IE8/9
    .directive('placeholder', function(){
        return {
            require: 'ngModel',
            link: function(scope, element, attr, ctrl) {

                //Only if placehoder are not supported
                if(jQuery.support.placeholder) {return;}

                var value;

                //Update local value when model change
                scope.$watch(attr.ngModel, function (val) {
                    value = val || '';
                });

                // Focus -> clear
                element.bind('focus', function () {
                    if(value == '' || value === attr.placeholder){
                        element.val('');
                    }
                });

                // blur -> placeholder
                element.bind('blur', function () {
                    if (element.val() == '') {
                        element.val(attr.placeholder);
                    }
                });

                ctrl.$formatters.unshift(function (val) {
                    if (!val) {
                        element.val(attr.placeholder);
                        value = '';
                        return attr.placeholder;
                    }
                    return val;
                });
            }
        }
    })

    // Clearable input
    .directive('clearable', function() {
        return {
            restrict: 'A',
            require: 'ngModel',
            compile: function(tElement) {
                var clearClass = 'clear_button',
                    divClass = clearClass + '_div';

                if (!tElement.parent().hasClass(divClass)) {
                    tElement.wrap('<div class="' + divClass + '">' + tElement.html() + '</div>');
                    tElement.after('<a class="' + clearClass + '">&times;</a>');

                    var btn = tElement.next();

                    return function(scope, iElement, iAttrs) {
                        if (iElement[0].tagName == 'DIV') {
                            var text = angular.element(iElement.children()[0]);

                            btn.bind('click', function(e) {
                                text.val('');
                                text.triggerHandler('input');
                                text.triggerHandler('blur');
                                text.triggerHandler('keydown');
                                scope.$apply();
                                e.preventDefault();
                            });

                            scope.$watch(iAttrs.ngModel, function (v) {

						if (v && v != iAttrs.placeholder && (iAttrs.disabled === false || iAttrs.disabled === undefined)) {
                                    btn.css('display', 'inline-block');
                                } else {
                                    btn.css('display', 'none');
                                }
                            });
                        }
                    }
                }
            }
        }
    })

    //COLOR PICKER

    .factory('colorpicker.helpers', function () {
        return {
            prepareValues: function(format) {
                var thisFormat = 'hex';
                if (format) {
                    thisFormat = format;
                }
                return {
                    name: thisFormat,
                    transform: 'to' + (thisFormat === 'hex' ? thisFormat.charAt(0).toUpperCase() + thisFormat.slice(1) : thisFormat.length > 3 ? thisFormat.toUpperCase().slice(0, -1) : thisFormat.toUpperCase())
                };
            },
            updateView: function(element, value) {
                if (!value) {
                    value = '';
                }
                element.val(value);
                element.data('colorpicker').color.setColor(value);
            }
        }
    })
    .directive('colorpicker', ['colorpicker.helpers', function(helper) {
        return {
            require: '?ngModel',
            restrict: 'A',
            link: function(scope, element, attrs, ngModel) {

                var thisFormat = helper.prepareValues(attrs.colorpicker);

                element.colorpicker({format: thisFormat.name});
                if(!ngModel) return;

                element.colorpicker().on('changeColor', function(event) {
                    element.val(element.data('colorpicker').format(event.color[thisFormat.transform]()));
                    scope.$apply(ngModel.$setViewValue(element.data('colorpicker').format(event.color[thisFormat.transform]())));
                });

                ngModel.$render = function() {
                    helper.updateView(element, ngModel.$viewValue) ;
                }
            }
        };
    }])
;

    'use strict';

angular.module('myerpCustomization.controllers', []).controller('customizationDocument', ['$scope', '$http', function($scope, $http) {

  $scope.fonts = [{
    label: 'Arial',
    value: 'Arial, Arial, Helvetica, sans-serif'
  }, {
    label: 'Courier new',
    value: 'Courier New, Courier New, monospace'
  }, {
    label: 'Times New Roman',
    value: 'Times New Roman, Times New Roman, Times, serif'
  }, {
    label: 'Palatino',
    value: 'Palatino Linotype, Book Antiqua3, Palatino, serif'
  }];

  $scope.loadCustomizationEdition = function(api_url, api_auth, printing_template, document_type) {
    $scope.loadCustomization(api_url, api_auth, printing_template, document_type, null);
  }

  $scope.loadCustomization = function(api_url, api_auth, printing_template, document_type, document_id) {
    $scope.api_url = api_url;
    $scope.api_auth = api_auth;
    $scope.document_type = document_type;
    $scope.document_id = document_id;
    $scope.printing_template = printing_template;

    $scope.settings = JSON.parse($scope.printing_template.settings);
    $scope.global_setting = angular.copy($scope.settings.global);
    if($scope.settings[document_type]) {
      $scope.document_setting = angular.copy($scope.settings[document_type]);
    } else {
      // Case that document settings are not in the JSON, we fallback on the defaults
      // Default or modified version of default will be happened to the settings on Save
      $scope.document_setting = angular.copy($scope.default_document_setting);
    }
    $http.defaults.headers.common['Authorization'] = 'Basic ' + api_auth;
  }

  $scope.save = function(callback) {
    var previous_settings = angular.copy($scope.settings);
    // Update settings
    $scope.settings.global = $scope.global_setting;
    if($scope.document_type !== "common") {
      $scope.settings[$scope.document_type] = $scope.document_setting;
    }
    // if changes occured we save the as a new template
    if(JSON.stringify(previous_settings) !== JSON.stringify($scope.settings)) {
      // The template has a name so it is the main version.
      // To customize it for a document, we create a copy of it and assigned it to the document
      if($scope.printing_template.name && $scope.document_id) {
        $http({
          method: 'POST',
          withCredentials: true,
          url: $scope.api_url + '/v1/printing_templates?document_type=' + $scope.document_type + '&document_id=' + $scope.document_id,
          data: {
            settings: JSON.stringify($scope.settings)
          }
        }).success(function() {
          callback(true);
        }).error(function() {
          callback(false);
        });
      } else {
        // The template has no name.
        // Its a copy of a main template that has diverge so we update it directly
        $http({
          method: 'PUT',
          withCredentials: true,
          url: $scope.api_url + '/v1/printing_templates/' + $scope.printing_template.id,
          data: {
            id: $scope.printing_template.id,
            name: $scope.printing_template.name,
            settings: JSON.stringify($scope.settings),
            master_template_id: $scope.printing_template.master_template_id,
            from_lock: $scope.printing_template.from_lock,
            notes: $scope.printing_template.notes
          }
        }).success(function() {
          callback(true);
        }).error(function() {
          callback(false);
        });
      }
    } else {
      callback(true);
    }
  }

  $scope.fontStyle = function() {
    return {
      "font-family": $scope.global_setting.font.family,
      "font-size": $scope.global_setting.font.size + "px",
      "line-height": parseInt($scope.global_setting.font.size) + 4 + "px",
      "color": $scope.global_setting.font.color
    };
  }
  $scope.fontColor = function() {
    return {
      "background-color": $scope.global_setting.font.color
    };
  }
  $scope.colorScheme = function() {
    return {
      "background-color": $scope.global_setting.color.scheme
    };
  }
  $scope.logoPlacement = function() {
    if ($scope.global_setting.logo.position === "left") {
      return {
        "display": "inline-block"
      };
    }
    return "";
  };

  $scope.resetGlobalSettings = function() {
    $scope.global_setting = angular.copy($scope.settings.global);
  };

  $scope.resetDocumentSettings = function() {
    if($scope.settings[$scope.document_type]) {
      $scope.document_setting = angular.copy($scope.settings[$scope.document_type]);
    } else {
      // Case that document settings are not in the JSON, we fallback on the defaults
      // Default or modified version of default will be happened to the settings on Save
      $scope.document_setting = angular.copy($scope.default_document_setting);
    }
  };

  $scope.default_document_setting = {
    "name": "default",
    "default": true,
    "display": {
      "product": {
        "measurement": true,
        "price": true,
        "quantity": true,
        "number": true
      },
      "installment": true
    }
  };
}]);
*/
</script>



<script type="text/javascript">
    function saveCustomization(callback) {
        angular.element(document.getElementsByTagName("body")).scope().$apply(function (scope) {
            scope.save(callback);
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
</script>

      </div>
      <footer class="w3-container w3-teal">
        <p></p>
      </footer>
    </div>
  </div>
</div>

<!----------------------model box for add custumer ------------- -->


  

</body></html>