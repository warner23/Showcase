<?php 

include_once  dirname(dirname(dirname(dirname(dirname(__FILE__))))) .'/init.php';
include_once('Helpers/PayPalHelper.php');

$paypalHelper = new PayPalHelper;

header('Content-Type: application/json');
echo json_encode($paypalHelper->orderCapture());