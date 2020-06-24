<?php
require_once "WIClass/WILib.php";
require_once "WIClass/WISettings.php";
//DATABASE CONFIGURATION

require_once "db.php";


$WIC = WILib::getInstance();
$config =  new WISettings();

$shop_name          = $config->Shop_Info("shop_name");
$business_email      = $config->Shop_Info("business_email");
$paypal_id          = $config->Shop_Info("paypal_id");
$paypal_secret          = $config->Shop_Info("paypal_secret");
$paypal_callback          = $config->Shop_Info("paypal_callback");
$cancel_url          = $config->Shop_Info("cancel_url");
$notify_url               = $config->Shop_Info("notify_url");






