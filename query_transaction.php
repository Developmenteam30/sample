<?php
    include("db.php");
    $i = '0';
    error_reporting(1);
    $result = array();
    
    if(isset($_GET['type'])){
    	$type = $_GET['type'];
        if(isset($_GET['page'])){
        	$page = ($_GET['page']-1)*9;
        $sql = "SELECT * FROM `transaction` WHERE `entry_type` = '$type' AND `company_email` = '$company_email' LIMIT 9 OFFSET $page";
        }else{
        $sql = "SELECT * FROM `transaction` WHERE `entry_type` = '$type' AND `company_email` = '$company_email' LIMIT 9";
        }
    }
    $new = $conn->query($sql);
    while($row = $new->fetch_assoc()){
        $result[$i] = $row;
        $i++;
    }
    $response = $result;
    header('Cache-Control: no-cache, must-revalidate');
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
    header('Content-type: application/json');
    echo json_encode($response);

?>