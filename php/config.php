<?php

/* * *****************************************************************************
 * Author: Keith Pope
 * File Name: config.php
 * File description: Contains all the parameters neeeded for ReviewMe to operate
 * **************************************************************************** */

 function GetSalt()
 {
     //hard coded salt (makes key unique), this allows the user to only send the public 
    //API Key 
    //because if a hacker new which HASH function the program used
    //they could identify the user's credencials by just entering the public API
    //This only applies if the hacker got access to the database
    
    return "THI3SMAy!MakeNoSenseG)00D,BecauseItISM&YSaLT!";
 }
###########################
#######email messages######
###########################
 
 //privileged confirmation email
function GetConfirmationMsgPriv($usrName,$publicKey,$secret)
{
    $msg = "Dear ".$usrName."<br><br>";
                $msg .= "Congratulation! You are now part of the ReviewMe community,"
                        ." you are now able to take advantage of including this service"
                        ." within your own webspace.<br><br>"
                        ."Your Public API key is:".$publicKey."<br>"
                        ."Your Secret is:".$secret
                        ."<br><br>"
                        ."Since you are a privileged user, you will need to generate"
                        ." a signature with each request you perform. This is to allow"
                        ." the system to authorize you."
                        ."<br><br>"
                        ."Please follow this link: localhost/ReviewMe/help.html to get"
                        ." instructions on how to do this. <br><br>"
                        ."Welcome to the team and happy reviewing."
                        ."<br><br>"
                        ."Regards,<br><br>"
                        ."ReviewMe Management :)";
        return $msg;
}
?>

