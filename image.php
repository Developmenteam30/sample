<?php 
include('db.php');
$date = date('Y/m/d/h/i');
$name =  $company_email."dada/".$date;
$condition = basename($_FILES["file"]["name"]);
if(isset($condition)){
$target_dir = "emoji/".$name.'/';
$target_file = $target_dir. basename($_FILES["file"]["name"]);
if (!file_exists('/'.$target_dir)) {
mkdir('./'.$target_dir, 0777, true);
move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
} else {
move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
}
$_SESSION['filename']=$target_file;
}
?>