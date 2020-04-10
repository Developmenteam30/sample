<?php
class SMTPClient
{

    function SMTPClient ($SmtpServer, $SmtpPort, $SmtpUser, $SmtpPass, $from, $to, $subject, $body, $data)
    {

        $this->SmtpServer = $SmtpServer;
        $this->SmtpUser = base64_encode ($SmtpUser);
        $this->SmtpPass = base64_encode ($SmtpPass);
        $this->from = $from;
        $this->to = $to;
        $this->subject = $subject;
        $this->body = $body;
        $this->data = $data;

        if ($SmtpPort == "") 
        {
            $this->PortSMTP = 25;
        }
        else
        {
            $this->PortSMTP = $SmtpPort;
        }
    }

    function SendMail ()
    {
        $newLine = "\r\n";
        $filename = "sample.pdf";

        $boundary =md5(date('r', time())); 

        $headers = "MIME-Version: 1.0" . $newLine;  
        $headers .= "Content-type: multipart/mixed; boundary=\"_1_$boundary\"" . $newLine;  

       echo $this->body="This is a multi-part message in MIME format.

--_1_$boundary
Content-Type: multipart/alternative; boundary=\"_2_$boundary\"

--_2_$boundary
Content-Type: text/plain; charset=\"iso-8859-1\"
Content-Transfer-Encoding: 7bit


--_2_$boundary--
--_1_$boundary
Content-Type: application/octet-stream; name=\"$filename\" 
Content-Transfer-Encoding: base64 
Content-Disposition: attachment 

$this->data
--_1_$boundary--";
 

        if ($SMTPIN = fsockopen ($this->SmtpServer, $this->PortSMTP)) 
        {
            fputs ($SMTPIN, "EHLO ".$HTTP_HOST."\r\n"); 
            $talk["hello"] = fgets ( $SMTPIN, 1024 ); 
            fputs($SMTPIN, "auth login\r\n");
            $talk["res"]=fgets($SMTPIN,1024);
            fputs($SMTPIN, $this->SmtpUser."\r\n");
            $talk["user"]=fgets($SMTPIN,1024);
            fputs($SMTPIN, $this->SmtpPass."\r\n");
            $talk["pass"]=fgets($SMTPIN,256);
            fputs ($SMTPIN, "MAIL FROM: <".$this->from.">\r\n"); 
            $talk["From"] = fgets ( $SMTPIN, 1024 ); 
            fputs ($SMTPIN, "RCPT TO: <".$this->to.">\r\n"); 
            $talk["To"] = fgets ($SMTPIN, 1024); 
            fputs($SMTPIN, "DATA\r\n");
            $talk["data"]=fgets( $SMTPIN,1024 );
            fputs($SMTPIN, "To: <".$this->to.">\r\nFrom: <".$this->from.">\r\n".$headers."\n\nSubject:".$this->subject."\r\n\r\n\r\n".$this->body."\r\n.\r\n");
            $talk["send"]=fgets($SMTPIN,256);
            //CLOSE CONNECTION AND EXIT ... 
            fputs ($SMTPIN, "QUIT\r\n"); 
            fclose($SMTPIN); 
            // 
        } 
        return $talk;
    } 
}
?>