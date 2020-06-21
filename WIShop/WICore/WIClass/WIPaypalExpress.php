<?php
/*
 * PaypalExpress Class
 * This class is used to handle PayPal API related operations
 * @author    CodexWorld.com
 * @url        http://www.codexworld.com
 * @license    http://www.codexworld.com/license
 */
class WIPaypalExpress{
    public $paypalEnv       = 'sandbox'; // Or 'production'
    public $paypalURL       = 'https://api.sandbox.paypal.com/v2/checkout';
    public $paypalClientID  = PAYPAL_CLIENT_ID;
    private $paypalSecret   = PAYPAL_SECRET;
    
    public function validate($paymentID, $paymentToken, $payerID, $productID){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->paypalURL.'oauth2/token');
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $this->paypalClientID.":".$this->paypalSecret);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
        $response = curl_exec($ch);
        curl_close($ch);
        
        if(empty($response)){
            return false;
        }else{
            $jsonData = json_decode($response);
            $curl = curl_init($this->paypalURL.'payments/payment/'.$paymentID);
            curl_setopt($curl, CURLOPT_POST, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'Authorization: Bearer ' . $jsonData->access_token,
                'Accept: application/json',
                'Content-Type: application/xml'
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            
            // Transaction data
            $result = json_decode($response);
            
            return $result;
        }
    
    }


        function PPHttpPost($methodName_, $nvpStr_, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode) {
            // Set up your API credentials, PayPal end point, and API version.
            $API_UserName = urlencode($PayPalApiUsername);
            $API_Password = urlencode($PayPalApiPassword);
            $API_Signature = urlencode($PayPalApiSignature);
            
            $paypalmode = ($PayPalMode=='sandbox') ? '.sandbox' : '';
    
            $API_Endpoint = "https://api-3t".$paypalmode.".paypal.com/nvp";
            $version = urlencode('109.0');
            

            // Set the curl parameters.
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $API_Endpoint);
            curl_setopt($ch, CURLOPT_VERBOSE, 1);
        
            // Turn off the server and peer verification (TrustManager Concept).
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            //curl_setopt($ch, CURLOPT_SSL_CIPHER_LIST, 'TLSv1'); //comment out incase of NSS instead of OpenSSL
            
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);

        
            // Set the API operation, version, and API signature in the request.
            $nvpreq = "METHOD=$methodName_&VERSION=$version&PWD=$API_Password&USER=$API_UserName&SIGNATURE=$API_Signature$nvpStr_";
        
            // Set the request as a POST FIELD for curl.
            curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq);
            

            // Get response from the server.
            $httpResponse = curl_exec($ch);
        
            if(!$httpResponse) {
                exit("$methodName_ failed: ".curl_error($ch).'('.curl_errno($ch).')');
            }
        
            // Extract the response details.
            $httpResponseAr = explode("&", $httpResponse);
        
            $httpParsedResponseAr = array();
            foreach ($httpResponseAr as $i => $value) {
                $tmpAr = explode("=", $value);
                if(sizeof($tmpAr) > 1) {
                    $httpParsedResponseAr[$tmpAr[0]] = $tmpAr[1];
                }
            }
        
            if((0 == sizeof($httpParsedResponseAr)) || !array_key_exists('ACK', $httpParsedResponseAr)) {
                exit("Invalid HTTP Response for POST request($nvpreq) to $API_Endpoint.");
            }
        
        return $httpParsedResponseAr;
    }
}