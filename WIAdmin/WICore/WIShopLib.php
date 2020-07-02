<?php
require_once "WIClass/WILib.php";
require_once "WIClass/WISettings.php";
//DATABASE CONFIGURATION

require_once "db.php";


$WIC = WILib::getInstance();
$config =  new WISettings();

$shop_name                = $config->Shop_Info("shop_name");
$business_email           = $config->Shop_Info("business_email");
$paypal_id                = $config->Shop_Info("paypal_id");
$paypal_secret            = $config->Shop_Info("paypal_secret");
$paypal_callback          = $config->Shop_Info("paypal_callback");
$cancel_url               = $config->Shop_Info("cancel_url");
$notify_url               = $config->Shop_Info("notify_url");
$VAT                      = $config->Shop_Info("VAT");
$base_url                 = $config->Shop_Info("base_url");
$paypal_pro               = $config->Shop_Info("paypal_pro");
$currency                 = $config->Shop_Info("currency");
$currency_symbol          = $config->Shop_Info("currency_symbol");
$current_url              = $config->Shop_Info("current_url");
$paypal_environment       = $config->Shop_Info("paypal_environment");
$paypal_base_url          = $config->Shop_Info("paypal_base_url");
$paypal_pro_base_url      = $config->Shop_Info("paypal_pro_base_url");






