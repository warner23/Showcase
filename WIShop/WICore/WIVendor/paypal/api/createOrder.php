<?php 
include_once '../../../WIClass/WI.php';
include_once('Helpers/PayPalHelper.php');

$paypalHelper = new PayPalHelper;
$randNo= (string)rand(10000,20000);

//var_dump($_POST);
$orderData = '{
    "intent" : "CAPTURE",
    "application_context" : {
        "return_url" : "",
        "cancel_url" : ""
    },
    "purchase_units" : [ 
        {
            "reference_id" : "PU1",
            "description" : "Camera Shop",
            "invoice_id" : "INV-' . SHOP_NAME . '-'.$randNo.'",
            "custom_id" : "CUST-' . SHOP_NAME . '",
            "id"
            "amount" : {
                "currency_code" : "'.$_POST['currency'].'",
                "value" : "'.$_POST['total_amt'].'",
                "breakdown" : {
                    "item_total" : {
                        "currency_code" : "'.$_POST['currency'].'",
                        "value" : "'.$_POST['item_amt'].'"
                    }*

                }
            },
            "items" : [{
                "name" : "DSLR Camera",
                "description" : "Black Camera - Digital SLR",
                "sku" : "sku01",
                "unit_amount" : {
                    "currency_code" : "'.$_POST['currency'].'",
                    "value" : "'.$_POST['item_amt'].'"
                },
                "quantity" : "1",
                "category" : "PHYSICAL_GOODS"
            }]
        }
    ]
}';

if(array_key_exists('shipping_country_code', $_POST)) {

    $orderDataArr = json_decode($orderData, true);
	$orderDataArr['application_context']['shipping_preference'] = "SET_PROVIDED_ADDRESS";
	$orderDataArr['application_context']['user_action'] = "PAY_NOW";
	
    $orderDataArr['purchase_units'][0]['shipping']['address']['address_line_1']= $_POST['shipping_line1'];
    $orderDataArr['purchase_units'][0]['shipping']['address']['address_line_2']= $_POST['shipping_line2'];
    $orderDataArr['purchase_units'][0]['shipping']['address']['admin_area_2']= $_POST['shipping_city'];
    $orderDataArr['purchase_units'][0]['shipping']['address']['admin_area_1']= $_POST['shipping_state'];
    $orderDataArr['purchase_units'][0]['shipping']['address']['postal_code']= $_POST['shipping_postal_code'];
    $orderDataArr['purchase_units'][0]['shipping']['address']['country_code']= $_POST['shipping_country_code'];

    $orderData = json_encode($orderDataArr);
}

header('Content-Type: application/json');
echo json_encode($paypalHelper->orderCreate($orderData));