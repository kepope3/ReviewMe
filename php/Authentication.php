<?php

/* * *****************************************************************************
 * Author: Keith Pope
 * class Name: Authentication
 * class description: Authentication.php generates new API keys and also 
 *  autheticates clients
 * **************************************************************************** */

class Authentication {

    //function used to generate unique API keys
    public function GenerateAPIKey($usrName)
    {
        //loop until unique API key is generated and saved
        while (1)
        {
            //get random string
            $rndStr = $this->GenRndStr();
            //sha1 produces 160 bit public key for user
            $publicKey = sha1($rndStr);
            //sha1 produces 160 bit private key with salt for storage 
            $privateKey = sha1(GetSalt().$publicKey);
            
            //attempt to save key
            if ($this->InsertKey($privateKey))
            {
                //send email to user
                //make new mailsender object
                $ms = new MailSender();
                //create message               
                $msg= GetConfirmationMsgPriv($usrName,$publicKey,$privateKey);
                                
                $ms->SendMail("ReviewMe", "Welcome", $msg,"ivanov78787@gmail.com");
                break;
            }
        }
    }

    //function checks in database to see if generated KEY is unique, if not then
    //it inserts it
    private function InsertKey($privateKey)
    {

        //check if private API exists in db
        //if !$privateKey then add
        //echo "privateKey: ".$privateKey;
        
        return true;
    }
    //check if API KEY exists in db
    public function APIExist($publicKey)
    {
        //convert publicKey into hash and check if private key exists (includes salt)
        echo $privateKey = sha1(GetSalt().$publicKey);
        
    }
    //function creates random string
    private function GenRndStr()
    {
        //include all numeric and alphbet chars + time
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0987654321' . time();
        //get the length of the $character string
        $charactersLength = strlen($characters);
        $randomString = '';
        //loop through entire length of Characters string, picking random chars from characters string
        //and adding them to the randomstring variable
        for ($i = $charactersLength; $i > 0; $i--)
        {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}
?>
