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
    //This applies if the hacker got access to the database
    
    return "THI3SMAy!MakeNoSenseG)00D,BecauseItISM&YSaLT!";
 }

?>

