<?php include('../db.php'); 
$sqlj = "SELECT * FROM `company` WHERE `email` = '$company_email'";
$newj = $conn->query($sqlj);
$rowj= $newj->fetch_assoc();
?>
<div style="width: 1000px; height: 60px; padding: 5px;border: 1px solid #000;">
<div  style="width: 100%;">
<div  style="width: 50%; float: left;">
<span style="text-decoration: underline;">RECIEVED BY:</span><br>
DATE : 
</div>

<div  style="width: 50%; float: left;">
<div style=" height:60px; border-left:1px solid #000;text-align: right; ">
  For <?php echo  $rowj['company_name']; ?><br><br><br>
  Authorised Signatory
</div>
</div>
</div>
</div>