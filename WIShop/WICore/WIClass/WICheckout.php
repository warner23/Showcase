<?php


/**
* 
*/
class WICheckout 
{

	function __construct()
	{
		$this->WIdb = WIdb::getInstance();
	    $this->login = new WILogin();
        $this->site = new WISite();
        $this->user   = new WIUser(WISession::get('user_id'));
        $this->Paypal = new WIPaypalExpress();
	}

	public function checkout()
	{

		$user_id = $this->user->id();

		$result = $this->WIdb->select(
                    "SELECT * FROM `wi_cart` WHERE user_id =:u",
                     array(
                       "u" => $user_id
                     )
                  );

		if($this->login->isLoggedIn()){
			self::UserisLoggedIn($result);	
        }else{
       echo "please log in or register";
        }

	}


	public function UserisLoggedIn($cart)
	{
		echo '<div class="wizard col-lg-12 col-md-12 col-sm-12">
            <div class="steps">
                <ul>';

        $result = $this->WIdb->select("SELECT * FROM `wi_checkout_steps`");

		foreach($result as $res){
			echo '<li>
                   <a :class="active">
                   <div class="stepNumber '. $res['classification'].'" id="'. $res['step_number'].'"><i class="'. $res['class'].'"></i></div>
                   <span class="stepDesc text-small">'; echo WILang::get($res['name']); 
                    echo '
                      </span>
                        </a>
                    </li>';
		}

		echo '</ul>
            </div>';

            foreach($result as $res){
			echo '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 step-content '.$res['show'].'" id="'. $res['identifier'].'">';
			self::steps($res['step_number'], $cart);

			echo '</div>';
		}
            echo '</div>';
	}

	public function steps($step, $cart)
	{
		$result = $this->WIdb->select("SELECT * FROM `wi_checkout_steps` WHERE `step_number`=:step", 
			array(
			"step" => $step
			)
			);

		$position = $result[0]['name'];

		if($position == "shipping"){
			self::shipping($cart);
		}elseif ($position == "payment") {
		    self::payment($cart);
		}elseif ($position == "confirmation") {
			self::confirmation($cart);
		}


	}


	public function shipping($cart)
	{
		$user_id = $this->user->id();
		$result = $this->WIdb->select("SELECT * FROM `wi_cust_address` WHERE `user_id`=:u", 
			array(
			"u" => $user_id
			)
			);

		echo '<style>
		/* style switcher  */



		/* switch button styling   */

		.switch {
		  position: relative;
		  display: inline-block;
		  width: 60px;
		  height: 34px;
		  margin-left: 8%;
		  float: right;
		}

		.switch input { 
		  opacity: 0;
		  width: 0;
		  height: 0;
		}

		.slider {
		  position: absolute;
		  cursor: pointer;
		  top: 0;
		  left: 0;
		  right: 0;
		  bottom: 0;
		  background-color: #ccc;
		  -webkit-transition: .4s;
		  transition: .4s;
		      padding-left: 10%;
		    padding-top: 10%;
		}

		.slider:before {
		  position: absolute;
		  content: "";
		  height: 26px;
		  width: 26px;
		  left: 4px;
		  bottom: 4px;
		  background-color: white;
		  -webkit-transition: .4s;
		  transition: .4s;
		}

		input:checked + .slider {
		  background-color: #2196F3;
		}

		input:focus + .slider {
		  box-shadow: 0 0 1px #2196F3;
		}

		input:checked + .slider:before {
		  -webkit-transform: translateX(26px);
		  -ms-transform: translateX(26px);
		  transform: translateX(26px);
		}

		/* Rounded sliders */
		.slider.round {
		  border-radius: 34px;
		}

		.slider.round:before {
		  border-radius: 50%;
		}
		</style>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
                <h3>'; WILang::get('shipping'); echo '</h3>
                <hr>
                <br>';

                echo '<form  class="form-horizontal address">
                    <fieldset>
                      <div id="legend">
                        <legend class="center">Address</legend>
                      </div>';

				$addresses = count($result);
				if($addresses > 0){
					
				}else{
					echo '<!--SHIPPING METHOD-->
					<div id="main_address_shipping">
                    <div class="panel panel-info">
                        <div class="panel-heading">Main Address</div>
                        <div class="panel-body">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <h4>Shipping Address</h4>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12"><strong>Country:</strong></div>
                                <div class="col-md-12">';
                                  $this->site->countries(); 
                                  echo '
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-xs-12">
                                    <strong>First Name:</strong>
                                    <input type="text" id="fname" name="first_name" class="form-control" value="" />
                                </div>
                                <div class="span1"></div>
                                <div class="col-md-6 col-xs-12">
                                    <strong>Last Name:</strong>
                                    <input type="text" id="lname" name="last_name" class="form-control" value="" />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12"><strong>Address:</strong></div>
                                <div class="col-md-12">
                                    <input type="text" id="address" name="address" class="form-control" value="" />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12"><strong>City:</strong></div>
                                <div class="col-md-12">
                                    <input type="text" id="city" name="city" class="form-control" value="" />
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-12"><strong>Zip / Postal Code:</strong></div>
                                <div class="col-md-12">
                                    <input type="text" id="postcode" name="post_code" class="form-control" value="" />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12"><strong>Phone Number:</strong></div>
                                <div class="col-md-12">
                                <input type="text" id="phone" name="phone_number" class="form-control" value="" /></div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-12"><strong>Address Reference:</strong></div>
                                <div class="col-md-12">
                                <input type="text" id="addy_ref" name="addy_ref" class="form-control" value="" />
                                </div>
                            </div>


                            <div class="form-group">
                                <div class="col-md-12"><strong></strong></div>
                                <div class="col-md-12">
                                <label>Main Address</label>
                    <div class="btn-group" data-toggle="buttons-radio">
                        <input type="hidden" name="main_address" class="btn-group-value" id="mn-address" value="true" />
                        <label class="switch">
                        <input type="checkbox" id="main_address" checked>
                        <span class="slider round" id="main_addy">ON</span>
                        
                      </label>
                    </div>
                                </div>
                            </div>
                        </div>

                        <script type="text/javascript">
                          var main_address = $("#mn-address").attr("value");
                       if (main_address === "false"){
                        $("#main_address").prop("checked", false);
                        $("#main_addy").text("OFF");
                        $("#main_addy").css("padding-left", "50%");
                       }else if (main_address === "true"){
                        $("#main_address").prop("checked", true);
                        $("#main_addy").text("ON");
                       }

                         </script>
                         </div>

                    <!--SHIPPING METHOD END-->

                    <div class="form-group">
                        <!-- Button -->
                        <div class="col-md-4 col-lg-8 col-xs-4">
                           <button id="addy" class="btn btn-success">Save</button> 
                        </div>
                      </div>

                      <div class="results" id="aresults"></div>
                    </fieldset>
                  </form> ';
				}

				echo '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><ul>';
                $count = 0;
        $total = 0;
        $len = count($cart);
				foreach($cart as $c){
                     $count++;
                    $subtotal = $c['price'] * $c['quantity'];
                $total = $total+ $subtotal;
              	echo '<li>
              	<div class="row">
				<div class="col-sm-2 hidden-xs">
				<img src="../../../WIAdmin/WIMedia/Img/shop/' . $c['product_image'] . '" alt="..." class="img-responsive"/></div>
				<div class="col-sm-10">
				<h4 class="nomargin title">' . $c['product_title'] . '</h4>
				<p>Quis aute iure reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Lorem ipsum dolor sit amet.</p>
				</div>
				<div class="addressing">';

				if($addresses > 0){
					echo '<label for="delivery_address">Choose a delivery address:</label>
						<select name="delivery_address" id="delivery_address">';
						foreach ($result as $res) {
							echo '<option value="'. $res['address_ref'] .'">'. $res['address_ref'] .'</option>';
						}
							 
							  
							echo '</select>
							<a href="javascript:void(0)">add new address</a>';
				}else{
					echo '<button class="btn">Add address</button>';
				}
				echo '</div>

                <div class="pricing" id="pricing">';
                    echo 'Item Price : £
                    <span class="individual_price">
                    <input type="text" class="item_price" value="' .$c['price'] . '" readonly>
                    </span>
                    Qty
                <span class="qty">
                    <input type="text" class="item_qty" value="' .$c['quantity'] . '" readonly>
                    </span>
                Total Price : £
                <span class="total_price">
                <input type="text" class="tot" id="total" value="' .$c['total_amount'] . '" readonly>
                </span>';
                
                echo '</div>
				</div>

              	</li>';

                if($count == $len){
                    $total;
                }
                       
              }

              echo '</ul>
              
                <meta name="viewport" content="width=device-width, initial-scale=1">
                 <!-- Ensures optimal rendering on mobile devices. -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge" /> 
  <!-- Optimal Internet Explorer compatibility -->

  <script
    src="https://www.paypal.com/sdk/js?client-id=' .PAYPAL_CLIENT_ID . '">
  </script>


              <strong>Total: £</strong>
            <span id="total">' .$total .'</span>
              <div id="paypalCheckoutContainer"></div>
              

            <!-- PayPal In-Context Checkout script -->
            <script type="text/javascript">';

              echo "


    paypal.Buttons({

        // Set your environment
        env: '". PAYPAL_ENVIRONMENT ."',


        // Set style of buttons
        style: {
            layout: 'horizontal',   // horizontal | vertical
            size:   'responsive',   // medium | large | responsive
            shape:  'pill',         // pill | rect
            color:  'gold',         // gold | blue | silver | black,
            fundingicons: false,    // true | false,
            tagline: false          // true | false,
        },

        // Wait for the PayPal button to be clicked
        createOrder: function() {

            let currencySelect = '".  CURRENCY ."'
            let formData = new FormData();

            $( '.total_price' ).each(function() {
              formData.append('item_amt', $('.item_price').attr('value'))
            });

            $( '.total_price' ).each(function() {
              formData.append('item_title', $('.title').text())
            });

            $( '.qty' ).each(function() {
              formData.append('item_qty', $('.item_qty').attr('value'))
            });

            formData.append('total_amt', $('#total').value);
            formData.append('return_url',  '". PAYPAL_CALLBACK ."?commit=false');
            formData.append('cancel_url', '". PAYPAL_CANCEL_URL."');

            return fetch(
                '".URL['services']['orderCreate']."',
                {
                    method: 'POST',
                    headers: {
                    'content-type': 'application/json',
                    'X-CSRFToken': '" .WICsrf::getToken() . "'
                },
                    body: formData
                }
            ).then(function(response) {
                console.log(response);
                return response.json();
            }).then(function(resJson) {
                console.log(resJson);
                 let token;
            token = resJson.paypal_response.links[1].href.match(/EC-\w+/)[0];
            console.log(token);
            return token;
                //console.log('Order ID: '+ resJson.data.id);
                //return resJson.data.id;
            });
        },

        // Wait for the payment to be authorized by the customer
        onApprove: function(data, actions) {
            return fetch(
                '". URL['services']['orderGet'] ."',
                {
                    method: 'GET'
                }
            ).then(function(res) {
                return res.json();
            }).then(function(res) {
                window.location.href = 'success.php';
            });
        }

    }).render('#paypalCheckoutContainer');

</script>";
              //include_once 'WIInc/payment.php';
              echo '</div>';
		

                echo '<a href="javascript:;" onclick="WICheckout.stepOne();" class="btn btn-as pull-right" type="button">
                    '; echo WILang::get('next'); echo '

                    <i class="fa fa-arrow-right"></i>
                </a>
                <div class="clearfix"></div>
            </div></div>';
	}

	public function payment($cart)
	{

		echo '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" > 

            <div class="alert alert-danger hide" id="snap" >
                    <strong>'; echo WILang::get('next'); echo '</strong> 
                </div>

                
                    <h3>'; echo WILang::get('payment'); echo '</h3>
                <hr>
                
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                
                ';
            //include_once 'WIInc/payment.php';
			
				  echo '</div>

				</div>

                 </div>
                    <a href="javascript:void(0);" class="btn btn-as pull-right" onclick="WICheckout.stepTwo()" type="button" id="required">'; 
                        echo WILang::get('next') ; echo '
                        <i class="fa fa-arrow-right"></i>
                    </a>
                    <div class="clearfix"></div>
                </div>
            </div>';
	}

	public function confirmation()
	{
		echo '<button class="btn btn-as pull-right" onclick="WIClient.stepThree();" type="button">
                    <span class="show" id="next">
                        '; echo WILang::get('next'); echo '
                        
                        <i class="fa fa-arrow-right" ></i>
                    </span>
                    <span class="hide" id="spin">
                        <i class="fa fa-circle-o-notch fa-spin"></i>
                       '; echo WILang::get('connecting'); echo '
                    </span>
                </button>
                <div class="clearfix"></div>
            ';
	}

	public function add_Address($Main_address)
	{
		$address = $Main_address['UserData'];

		$user_id = $this->user->id();

		$this->WIdb->insert('wi_cust_address', array(
			"user_id" => $user_id,
            "fname"     => strip_tags($address['first_name']),
            "lname"  => strip_tags($address['last_name']),
            "address"  => strip_tags($address['addy']),
            "city" => strip_tags($address['city']),
            "postcode" => strip_tags($address['post_code']),
            "country" => strip_tags($address['country']),
            "address_ref" => strip_tags($address['address_ref']),
            "main_addy" => $address['main_addy'],
            "phone" => strip_tags($address['phone'])
        ));

            $result = array(
                "status" => "successful"
            );
            
            //output result
            echo json_encode ($result);   
	}

    public function PayPal()
    {

    }

    public function Process()
    {

    if(isset($_GET["token"]) && isset($_GET["PayerID"]))
    {
    //we will be using these two variables to execute the "DoExpressCheckoutPayment"
    //Note: we haven't received any payment yet.
    
    $token = $_GET["token"];
    $payer_id = $_GET["PayerID"];
    
    //get session variables
    $paypal_product = $_SESSION["paypal_products"];
    $paypal_data = '';
    $ItemTotalPrice = 0;

    foreach($paypal_product['items'] as $key=>$p_item)
    {       
        $paypal_data .= '&L_PAYMENTREQUEST_0_QTY'.$key.'='. urlencode($p_item['itm_qty']);
        $paypal_data .= '&L_PAYMENTREQUEST_0_AMT'.$key.'='.urlencode($p_item['itm_price']);
        $paypal_data .= '&L_PAYMENTREQUEST_0_NAME'.$key.'='.urlencode($p_item['itm_name']);
        $paypal_data .= '&L_PAYMENTREQUEST_0_NUMBER'.$key.'='.urlencode($p_item['itm_code']);
        
        // item price X quantity
        $subtotal = ($p_item['itm_price']*$p_item['itm_qty']);
        
        //total price
        $ItemTotalPrice = ($ItemTotalPrice + $subtotal);
    }

    $padata =   '&TOKEN='.urlencode($token).
                '&PAYERID='.urlencode($payer_id).
                '&PAYMENTREQUEST_0_PAYMENTACTION='.urlencode("SALE").
                $paypal_data.
                '&PAYMENTREQUEST_0_ITEMAMT='.urlencode($ItemTotalPrice).
                '&PAYMENTREQUEST_0_TAXAMT='.urlencode($paypal_product['assets']['tax_total']).
                '&PAYMENTREQUEST_0_SHIPPINGAMT='.urlencode($paypal_product['assets']['shippin_cost']).
                '&PAYMENTREQUEST_0_HANDLINGAMT='.urlencode($paypal_product['assets']['handaling_cost']).
                '&PAYMENTREQUEST_0_SHIPDISCAMT='.urlencode($paypal_product['assets']['shippin_discount']).
                '&PAYMENTREQUEST_0_INSURANCEAMT='.urlencode($paypal_product['assets']['insurance_cost']).
                '&PAYMENTREQUEST_0_AMT='.urlencode($paypal_product['assets']['grand_total']).
                '&PAYMENTREQUEST_0_CURRENCYCODE='.urlencode($PayPalCurrencyCode);

    //We need to execute the "DoExpressCheckoutPayment" at this point to Receive payment from user.
    $paypal= new MyPayPal();
    $httpParsedResponseAr = $paypal->PPHttpPost('DoExpressCheckoutPayment', $padata, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);
    
    //Check if everything went ok..
    if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) 
    {

            echo '<h2>Success</h2>';
            echo 'Your Transaction ID : '.urldecode($httpParsedResponseAr["PAYMENTINFO_0_TRANSACTIONID"]);
            
                /*
                //Sometimes Payment are kept pending even when transaction is complete. 
                //hence we need to notify user about it and ask him manually approve the transiction
                */
                
                if('Completed' == $httpParsedResponseAr["PAYMENTINFO_0_PAYMENTSTATUS"])
                {
                    echo '<div style="color:green">Payment Received! Your product will be sent to you very soon!</div>';
                }
                elseif('Pending' == $httpParsedResponseAr["PAYMENTINFO_0_PAYMENTSTATUS"])
                {
                    echo '<div style="color:red">Transaction Complete, but payment is still pending! '.
                    'You need to manually authorize this payment in your <a target="_new" href="http://www.paypal.com">Paypal Account</a></div>';
                }

                // we can retrive transection details using either GetTransactionDetails or GetExpressCheckoutDetails
                // GetTransactionDetails requires a Transaction ID, and GetExpressCheckoutDetails requires Token returned by SetExpressCheckOut
                $padata =   '&TOKEN='.urlencode($token);
                $paypal= new MyPayPal();
                $httpParsedResponseAr = $paypal->PPHttpPost('GetExpressCheckoutDetails', $padata, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);

                if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) 
                {
                    
                    echo '<br /><b>Stuff to store in database :</b><br />';
                    
                    echo '<pre>';
                    /*
                    #### SAVE BUYER INFORMATION IN DATABASE ###
                    //see (http://www.sanwebe.com/2013/03/basic-php-mysqli-usage) for mysqli usage
                    //use urldecode() to decode url encoded strings.
                    
                    $buyerName = urldecode($httpParsedResponseAr["FIRSTNAME"]).' '.urldecode($httpParsedResponseAr["LASTNAME"]);
                    $buyerEmail = urldecode($httpParsedResponseAr["EMAIL"]);
                    
                    //Open a new connection to the MySQL server
                    $mysqli = new mysqli('host','username','password','database_name');
                    
                    //Output any connection error
                    if ($mysqli->connect_error) {
                        die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
                    }       
                    
                    $insert_row = $mysqli->query("INSERT INTO BuyerTable 
                    (BuyerName,BuyerEmail,TransactionID,ItemName,ItemNumber, ItemAmount,ItemQTY)
                    VALUES ('$buyerName','$buyerEmail','$transactionID','$ItemName',$ItemNumber, $ItemTotalPrice,$ItemQTY)");
                    
                    if($insert_row){
                        print 'Success! ID of last inserted record is : ' .$mysqli->insert_id .'<br />'; 
                    }else{
                        die('Error : ('. $mysqli->errno .') '. $mysqli->error);
                    }
                    
                    */
                    
                    echo '<pre>';
                    print_r($httpParsedResponseAr);
                    echo '</pre>';
                } else  {
                    echo '<div style="color:red"><b>GetTransactionDetails failed:</b>'.urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]).'</div>';
                    echo '<pre>';
                    print_r($httpParsedResponseAr);
                    echo '</pre>';

                }
    
    }else{
            echo '<div style="color:red"><b>Error : </b>'.urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]).'</div>';
            echo '<pre>';
            print_r($httpParsedResponseAr);
            echo '</pre>';
    }
}else{

    // if isset is not set


            //paypal settings
$PayPalMode             = 'sandbox'; // sandbox or live
$PayPalApiUsername      = 'sb-pxfjg2310161_api1.business.example.com'; //PayPal API Username
$PayPalApiPassword      = 'UQPKHCFNTU56657R'; //Paypal API password
$PayPalApiSignature     = 'A.pHE6kQt3KL-ifbh197SAudny1AAoIax5yjgbEvJ7Dg6oUI1J6dPdmH'; //Paypal API Signature
$PayPalCurrencyCode     = 'GBP'; //Paypal Currency Code
$PayPalReturnURL        = SCRIPT_URL. '/WIShow/checkout.php'; //Point to paypal-express-checkout page
$PayPalCancelURL        = SCRIPT_URL.'/WIShow/checkout.php'; //Cancel URL if user clicks cancel

//Additional taxes and fees                                         
$HandalingCost      = 0.00;  //Handling cost for the order.
$InsuranceCost      = 0.00;  //shipping insurance cost for the order.
$shipping_cost      = 1.50; //shipping cost
$ShippinDiscount    = 0.00; //Shipping discount for this order. Specify this as negative number (eg -1.00)
$taxes              = array( //List your Taxes percent here.
                            'VAT' => 12, 
                            'Service Tax' => 5
                            );
       
       $user_id = WISession::get('user_id');
       $result = $this->WIdb->select(
                    "SELECT * FROM `wi_cart` WHERE user_id =:u",
                     array(
                       "u" => $user_id
                     )
                  );

        $paypalmode = ($PayPalMode=='sandbox') ? '.sandbox' : '';
        $paypal_data = "";
        $ItemTotalPrice = 0;
        $i = 0;

        foreach($result as $res){
             $paypal_data .= '&L_PAYMENTREQUEST_0_NAME'.$i.'='.urlencode($res['product_title']);
        $paypal_data .= '&L_PAYMENTREQUEST_0_AMT'.$i.'='.urlencode($res['price']);        
        $paypal_data .= '&L_PAYMENTREQUEST_0_QTY'.$i.'='. urlencode($res["quantity"]);
        
        // item price X quantity
        $subtotal = ($res['price'] *$res["quantity"]);
        
        //total price
        $ItemTotalPrice = $ItemTotalPrice + $subtotal;
        
        //create items for session
        $paypal_product['items'][] = array('itm_name'=>$res['product_title'],
                                            'itm_price'=>$res['price'],
                                            'itm_qty'=>$res["quantity"]
                                            );
        $i++;
        }

        $total_tax = 0;
        foreach($taxes as $key => $value){ //list and calculate all taxes in array
            $tax_amount     = round($ItemTotalPrice * ($value / 100));
            $tax_item[$key] = $tax_amount;
            $total_tax = $total_tax + $tax_amount; //total tax amount
    }

    $GrandTotal = ($ItemTotalPrice + $total_tax + $HandalingCost + $InsuranceCost + $shipping_cost + $ShippinDiscount);
    
                                
    $paypal_product['assets'] = array('tax_total'=>$total_tax, 
                                'handaling_cost'=>$HandalingCost, 
                                'insurance_cost'=>$InsuranceCost,
                                'shippin_discount'=>$ShippinDiscount,
                                'shippin_cost'=>$shipping_cost,
                                'grand_total'=>$GrandTotal);
    
    //create session array for later use
    $_SESSION["paypal_products"] = $paypal_product;
    
    //Parameters for SetExpressCheckout, which will be sent to PayPal
    $padata =   '&METHOD=SetExpressCheckout'.
                '&RETURNURL='.urlencode($PayPalReturnURL ).
                '&CANCELURL='.urlencode($PayPalCancelURL).
                '&PAYMENTREQUEST_0_PAYMENTACTION='.urlencode("SALE").
                $paypal_data.               
                '&NOSHIPPING=0'. //set 1 to hide buyer's shipping address, in-case products that does not require shipping
                '&PAYMENTREQUEST_0_ITEMAMT='.urlencode($ItemTotalPrice).
                '&PAYMENTREQUEST_0_TAXAMT='.urlencode($total_tax).
                '&PAYMENTREQUEST_0_SHIPPINGAMT='.urlencode($shipping_cost).
                '&PAYMENTREQUEST_0_HANDLINGAMT='.urlencode($HandalingCost).
                '&PAYMENTREQUEST_0_SHIPDISCAMT='.urlencode($ShippinDiscount).
                '&PAYMENTREQUEST_0_INSURANCEAMT='.urlencode($InsuranceCost).
                '&PAYMENTREQUEST_0_AMT='.urlencode($GrandTotal).
                '&PAYMENTREQUEST_0_CURRENCYCODE='.urlencode($PayPalCurrencyCode).
                '&LOCALECODE=GB'. //PayPal pages to match the language on your website.
                '&LOGOIMG=http://wicms.uk/WIAdmin/WIMedia/Img/jeader/wi_cms_logo.jpg'. //site logo
                '&CARTBORDERCOLOR=FFFFFF'. //border color of cart
                '&ALLOWNOTE=1';

        
        //We need to execute the "SetExpressCheckOut" method to obtain paypal token
        $httpParsedResponseAr = $this->Paypal->PPHttpPost('SetExpressCheckout', $padata, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);
        
        //Respond according to message we receive from Paypal
        if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"]))
        {
                unset($_SESSION["cart_products"]); //session no longer needed
                //Redirect user to PayPal store with Token received.
                $paypalurl ='https://www'.$paypalmode.'.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token='.$httpParsedResponseAr["TOKEN"].'';
                header('Location: '.$paypalurl);
        }
        else
        {
            //Show error message
            echo '<div style="color:red"><b>Error : </b>'.urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]).'</div>';
            echo '<pre>';
            print_r($httpParsedResponseAr);
            echo '</pre>';
        }


}


    }

    public function cart()
    {
        $user_id = WISession::get('user_id');
        
        $result = $this->WIdb->select(
                    "SELECT * FROM `wi_cart`
                     WHERE `user_id` = :u",
                     array(
                       "u" => $user_id
                     )
                  );

        echo "item_list: {
                items: [
                    {";
        $count=0;
        $len = count($result);                         
        foreach ($result as $res) {
            $count++;

            if($count == $len){
                        echo "name: '".$res['product_title'] ."',
              image: '".$res['product_image'] ."',
              quantity: '".$res['quantity'] ."',
              price: '".$res['price'] ."',
              tax: '0.01',
              currency: 'GBP'
            }";
            }else{
                        echo "name: '".$res['product_title'] ."',
              image: '".$res['product_image'] ."',
              quantity: '".$res['quantity'] ."',
              price: '".$res['price'] ."',
              tax: '0.01',
              currency: 'GBP'
            },";
            }

        }

        echo "}]

         },
         amount: { total: '40', 
                               currency: 'GBP'
                               },";

    }


   
}

?>