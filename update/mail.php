<?php 
include('SMTPconfig.php');
include('SMTPmail.php');

    $to = $_POST['email_to'];
    $from = "raghu@curveinfotech.com";
    $subject = $_POST['email_subject'];
    $body = $_POST['email_body'];

//     $to = "accountantdubai@gmail.com";
//     $from = "raghu@curveinfotech.com";
//     $subject = "Enquiry";
//     $body = "Hello world!";
//        $file = fopen("sample.pdf", "rb");
//        $data = fread($file, filesize("sample.pdf"));
//        fclose($file);
//        echo $data = chunk_split(base64_encode($data));

    $data = file_get_contents($_FILES['file']['tmp_name']);
    $data = chunk_split(base64_encode($data));

    $SMTPMail = new SMTPClient ($SmtpServer, $SmtpPort, $SmtpUser, $SmtpPass, $from, $to, $subject, $body, $data);
    $SMTPChat = $SMTPMail->SendMail();
?>