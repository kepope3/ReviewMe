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
require_once './php/MailSender.php';
// get the HTTP method
$method = $_SERVER['REQUEST_METHOD'];

//generate new Authentication object
$auth = new Authentication();
//generate new API key
$auth->GenerateAPIKey("Elisabeth's Amazon");
?>