<?php
/*******************************************************************************
 * Author: Keith Pope
 * Project Name: ReviewMe
 * Project Description: Product reviewing service with company ethical ratings
 * file description: index.php first access point for handling client requests
 ******************************************************************************/
//includes
require_once './php/Authentication.php';
require_once './php/config.php';
// get the HTTP method
$method = $_SERVER['REQUEST_METHOD'];

//generate new Authentication object
$auth = new Authentication();
//get new API key
$publicKey = $auth->GenerateAPIKey();
//
// the message
$msg = "public key: ".$publicKey;

// use wordwrap() if lines are longer than 70 characters
$msg = wordwrap($msg,70);
$headers =  'MIME-Version: 1.0' . "\r\n"; 
$headers .= 'From: Your name <info@address.com>' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 
// send email
mail("pope_446@hotmail.com","ReviewMe",$msg,$headers);


//example of login
//$publicKey= "f0e6ecbb9c33c68df5e41b22d7753cf38becdc52";
//$auth->APIExist($publicKey);
?>