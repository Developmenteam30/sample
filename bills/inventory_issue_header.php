<?php include('../db.php'); 
$id = $_REQUEST['id'];

$sql = "SELECT * FROM `transaction` WHERE `id` = '$id' AND `company_email` = '$company_email'";
$new = $conn->query($sql);
$row = $new->fetch_assoc();
$name_id = $row['name_id'];

$sqlj = "SELECT * FROM `company` WHERE `email` = '$company_email'";
$newj = $conn->query($sqlj);
$rowj= $newj->fetch_assoc();

$sqli = "SELECT * FROM `customer` WHERE `id` = '$name_id'";
$newi = $conn->query($sqli);
$rowi= $newi->fetch_assoc();

  ?>

        <div  style="width: 100%;float: left;">

                <div style="width: 45%;float: left;border:1px solid #000;padding: 0px 0px 0px 0px; margin-left: 5px;height: 150px;">
                <div style="border-bottom:1px solid #000;line-height: 15px">
                <h2 align="left" style="font-weight: bold; font-size: 16px; padding-right: 20px;border-bottom: 1px solid#000; padding-left: 10px"><?php echo $rowj['company_name']; ?></h2>
                </div>
                <div>
                     <p style="padding-left: 10px">
                            <?php echo $rowj['address']; ?><br>
                            <?php echo $rowj['city']; ?> <br>
                            <?php echo $rowj['state']; ?> & 
                            <?php echo $rowj['country']; ?><br>
                            Phone: <?php echo $rowj['phone']; ?><br>
                        <span style="font-weight:bold;">TRN: <?php echo $rowj['tax_number']; ?></span><br>
                        </div>
            </div>

            <div style="width: 50%;float: right;">
                <h2 style="text-transform: uppercase;text-align: center;"><?php echo $row['cat_type']; ?></h2>
                <table style="width: 100%;float: right;border:1px solid #ccc">
                  <tbody><tr style="font-weight: bold;text-align: center;">
                    <td style="padding: 12px 33px 12px 33px;border-right:1px solid #ccc;border-bottom: 1px solid #ccc">Date</td>
                    <td style="padding: 12px 33px 12px 33px;border-bottom: 1px solid #ccc "><?php echo date('d-m-Y',strtotime($row['date'])); ?></td>
                  </tr>
                  <tr style="font-weight: bold;border:1px solid #ccc;text-align: center;background-color: transparent !important;">
                    <td style="padding: 12px 33px 12px 33px;border-right:1px solid #ccc"><?php echo ucwords($row['cat_type']); ?></td>
                    <td style="padding: 12px 33px 12px 33px "><?php echo $row['transaction_number']; ?></td>
                  </tr>
                 </tbody>
                </table>
            </div>

        </div>

        <div  style="width: 100%;float: left;padding: 15px 0px 0px 0px; " >

            <div style="width: 45%;float: left;border:1px solid #000;padding: 0px 0px 0px 0px; margin-left: 5px;max-height: 150px;">
            <div style="border-bottom:1px solid #000;line-height: 15px">
            <p align="left" style="text-transform: uppercase; font-weight: bold; padding-right: 20px;border-bottom: 1px solid#000; padding-left: 10px"><span style="color: #cc;">(Vendor)</span> <?php echo $rowi['company_name']; ?></p>
            </div>
            <div>
                 <p style="padding-left: 10px">
                            <?php echo $rowi['address']; if($rowi['address']!=''){echo ',';} ?><br>
                            <?php echo $rowi['city']; if($rowi['city']!=''){echo ',';} ?><br>
                            <?php echo $rowi['state']; if($rowi['state']!=''){echo ',';} ?>
                            <?php echo $rowi['country']; ?><br>
                            TRN: <?php echo $rowi['tax_number']; ?></p><br><br>
                        </div>
        </div>
            <div style="width: 50%;float: right;border:1px solid #000;padding: 0px 0px 0px 0px; margin-left: 5px;height: 170px;">
                <div style="border-bottom:1px solid #000;line-height: 15px">
      <p align="left" style="font-weight: bold; padding-right: 20px;border-bottom: 1px solid#000; padding-left: 10px">Ship TO</p>
                </div>
                <div>
                    <p style="padding-left: 10px">
                      <?php echo $rowi['contact_name']; if($rowi['contact_name']!=''){echo ',';} ?><br>
                      <?php echo $rowi['company_name']; if($rowi['company_name']!=''){echo ',';} ?><br>
                      <?php echo $rowi['delivery_address']; if($rowi['delivery_address']!=''){echo ',';} ?><br>
                      <?php echo $rowi['city']; if($rowi['city']!=''){echo ',';} ?><br>
                      <?php echo $rowi['state']; if($rowi['country']!=''){echo ',';} ?><br>
                      <?php echo $rowi['country']; ?>
                    </p>

                        </div>
            </div>


        </div>