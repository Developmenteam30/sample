<?php

include('db.php');
echo $new = $_GET['auth'];
$conn->query("INSERT INTO `push_note` (`auth`) VALUES ('$new')");
?>