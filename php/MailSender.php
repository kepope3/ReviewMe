<?php

class MailSender {

    public function SendMail($from,$subject,$msg,$add)
    {
        ini_set("SMTP", "smtp.nyu.edu");
        ini_set("smtp_port", "587");
        // In case any of our lines are larger than 70 characters, we should use wordwrap()
        $message = wordwrap($msg, 70, "\r\n");
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'From: '.$from.' <info@address.com>' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";


        // Send
        mail($add, $subject, $message, $headers);
    }

}
?>

