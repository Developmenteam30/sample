<?php
    $to = $_REQUEST['email_to'];
    $file_send = $_REQUEST['email_file'];
    $subject = $_REQUEST['email_subject'];
    $body = $_REQUEST['email_body'];
    echo $data = file_get_contents("http://king18yat.com/taxiapp/mail/PHP/examples/send_file_upload.php?email_to=".$to."&email_file=".$file_send."&email_subject=".$subject."&email_body=".$body);

?>