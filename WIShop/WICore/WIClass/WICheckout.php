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
				foreach($cart as $c){
              	echo '<li>
              	<div class="row">
				<div class="col-sm-2 hidden-xs">
				<img src="../../../WIAdmin/WIMedia/Img/shop/' . $c['product_image'] . '" alt="..." class="img-responsive"/></div>
				<div class="col-sm-10">
				<h4 class="nomargin">' . $c['product_title'] . '</h4>
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
				</div>

              	</li>';
              }

              echo '</ul></div>';
		

                echo '<a href="javascript:;" onclick="WICheckout.stepOne();" class="btn btn-as pull-right" type="button">
                    '; echo WILang::get('next'); echo '

                    <i class="fa fa-arrow-right"></i>
                </a>
                <div class="clearfix"></div>
            </div></div>';
	}

	public function payment()
	{
		echo '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" > 

            <div class="alert alert-danger hide" id="snap" >
                    <strong>'; echo WILang::get('next'); echo '</strong> 
                </div>

                
                    <h3>'; echo WILang::get('payment'); echo '</h3>
                <hr>
                
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- Ensures optimal rendering on mobile devices. -->
				  <meta http-equiv="X-UA-Compatible" content="IE=edge" /> <!-- Optimal Internet Explorer compatibility -->
                	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
				  <link rel="stylesheet" href="/resources/demos/style.css">
				   <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
				  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
				  <script>
				  $( function() {
				    $( "#accordion" ).accordion({
				      collapsible: true
				    });
				  } );
				  </script>

				<div id="accordion">
				  <h3>Paypal</h3>
				  <div style="height:200px;">

<div id="paypal-button-container">
<a href="WICore/WIVendor/paypal/rest-api-sdk-php/lib/PayPal/index.php"><img id="paypal_payments" src="https://wicms.uk/WIAdmin/WIMedia/Img/shop/paypal.png">
</a>
</div>


				 
				  </div>
				  <h3>Card</h3>
				  <div>
				 <!--CREDIT CART PAYMENT-->
                    <div class="panel panel-info">
                        <div class="panel-heading"><span><i class="glyphicon glyphicon-lock"></i></span> Secure Payment</div>
                        <div class="panel-body">
                            <div class="form-group">
                                <div class="col-md-12"><strong>Card Type:</strong></div>
                                <div class="col-md-12">
                                    <select id="CreditCardType" name="CreditCardType" class="form-control">
                                        <option value="5">Visa</option>
                                        <option value="6">MasterCard</option>
                                        <option value="7">American Express</option>
                                        <option value="8">Discover</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12"><strong>Credit Card Number:</strong></div>
                                <div class="col-md-12"><input type="text" class="form-control" name="car_number" value="" /></div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12"><strong>Card CVV:</strong></div>
                                <div class="col-md-12"><input type="text" class="form-control" name="car_code" value="" /></div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <strong>Expiration Date</strong>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <select class="form-control" name="">
                                        <option value="">Month</option>
                                        <option value="01">01</option>
                                        <option value="02">02</option>
                                        <option value="03">03</option>
                                        <option value="04">04</option>
                                        <option value="05">05</option>
                                        <option value="06">06</option>
                                        <option value="07">07</option>
                                        <option value="08">08</option>
                                        <option value="09">09</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                </select>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <select class="form-control" name="">
                                        <option value="">Year</option>
                                        <option value="2015">2015</option>
                                        <option value="2016">2016</option>
                                        <option value="2017">2017</option>
                                        <option value="2018">2018</option>
                                        <option value="2019">2019</option>
                                        <option value="2020">2020</option>
                                        <option value="2021">2021</option>
                                        <option value="2022">2022</option>
                                        <option value="2023">2023</option>
                                        <option value="2024">2024</option>
                                        <option value="2025">2025</option>
                                </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <span>Pay secure using your credit card.</span>
                                </div>
                                <div class="col-md-12">
                                    <ul class="cards">
                                        <li class="visa hand">Visa</li>
                                        <li class="mastercard hand">MasterCard</li>
                                        <li class="amex hand">Amex</li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <button type="submit" class="btn btn-primary btn-submit-fix">Place Order</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--CREDIT CART PAYMENT END-->
				  </div>

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
        //require  dirname(dirname(dirname(__FILE__))) .'/paypal.php';
        require  dirname(dirname(__FILE__)) .'/WIVendor/paypal/rest-api-sdk-php/lib/PayPal/Common/PayPalModel.php';
        require  dirname(dirname(__FILE__)) .'/WIVendor/paypal/rest-api-sdk-php/lib/PayPal/Api/Payer.php';
        require dirname(dirname(__FILE__)) .'/WIVendor/paypal/rest-api-sdk-php/lib/PayPal/Api/Item.php';
        require dirname(dirname(__FILE__)) .'/WIVendor/paypal/rest-api-sdk-php/lib/PayPal/Api/ItemList.php';
        require dirname(dirname(__FILE__)) .'/WIVendor/paypal/rest-api-sdk-php/lib/PayPal/Api/Details.php';
        require dirname(dirname(__FILE__)) .'/WIVendor/paypal/rest-api-sdk-php/lib/PayPal/Api/Amount.php';
        require dirname(dirname(__FILE__)) .'/WIVendor/paypal/rest-api-sdk-php/lib/PayPal/Api/CartBase.php';
        require dirname(dirname(__FILE__)) .'/WIVendor/paypal/rest-api-sdk-php/lib/PayPal/Api/TransactionBase.php';
        require dirname(dirname(__FILE__)) .'/WIVendor/paypal/rest-api-sdk-php/lib/PayPal/Api/Transaction.php';
        require dirname(dirname(__FILE__)) .'/WIVendor/paypal/rest-api-sdk-php/lib/PayPal/Api/RedirectUrls.php';
        require dirname(dirname(__FILE__)) .'/WIVendor/paypal/rest-api-sdk-php/lib/PayPal/Rest/IResource.php';
        require dirname(dirname(__FILE__)) .'/WIVendor/paypal/rest-api-sdk-php/lib/PayPal/Common/PayPalResourceModel.php';
        require dirname(dirname(__FILE__)) .'/WIVendor/paypal/rest-api-sdk-php/lib/PayPal/Api/Payment.php';


        

        $user_id = WISession::get('user_id');

        $data = $this->WIdb->select("SELECT * FROM `wi_cart` WHERE `user_id`=:user_id", array(
            "user_id" => $user_id
            )
        );
        

        foreach ($data as $d ) {
            $product = $d['product_title'];
            $price   = $d['price'];
            $quantity   = $d['quantity'];
            $shipping = 2.00;

        $total = $price + $shipping;

        $payer = new Payer();
        $payer->SetPaymentMethod('paypal');

        $item = new Item();
        $item->SetName($product)
             ->SetCurrency('GBP')
             ->SetQuantity($quantity)
             ->SetPrice($price);

        $itemList = new ItemList();
        $itemList->SetItems($item);

        $details = new Details();
        $details->SetShipping($shipping)
                ->SetSubtotal($price);

        $amount = new Amount();
        $amount->SetCurrency('GBP')
               ->SetTotal($total)
               ->SetDetails($details);

        $transaction = new Transaction();
        $transaction->SetAmount($amount)
                    ->SetItemList($itemList)
                    ->SetDescription('Pay for your items')
                    ->SetInvoiceNumber(uniqid() );

        $redirectUrls = new RedirectUrls();
        $redirectUrls->SetReturnUrl(paypal_callback . 'pay.php?success=true')
                    ->SetCancelUrl(paypal_callback . 'pay.php?success=true');

        $payment = new Payment();
        $payment->SetIntent('sale')
                ->SetPayer($payer)
                ->SetRedirectUrl($redirectUrls)
                ->SetTransactions($transaction);

        try{
            $payment->create($paypal);
        }catch(Exception $e){
            die($e);
        }

        }

        

        $approveUrl->payment->getApprovalLink();

        hedader("Location:{$redirectUrls}");

    }


    public function test()
    {
        // # Create Payment using PayPal as payment method
// This sample code demonstrates how you can process a 
// PayPal Account based Payment.
// API used: /v1/payments/payment

require __DIR__ . '/../bootstrap.php';
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;

// ### Payer
// A resource representing a Payer that funds a payment
// For paypal account payments, set payment method
// to 'paypal'.
$payer = new Payer();
$payer->setPaymentMethod("paypal");

// ### Itemized information
// (Optional) Lets you specify item wise
// information
$item1 = new Item();
$item1->setName('Ground Coffee 40 oz')
    ->setCurrency('USD')
    ->setQuantity(1)
    ->setSku("123123") // Similar to `item_number` in Classic API
    ->setPrice(7.5);
$item2 = new Item();
$item2->setName('Granola bars')
    ->setCurrency('USD')
    ->setQuantity(5)
    ->setSku("321321") // Similar to `item_number` in Classic API
    ->setPrice(2);

$itemList = new ItemList();
$itemList->setItems(array($item1, $item2));

// ### Additional payment details
// Use this optional field to set additional
// payment information such as tax, shipping
// charges etc.
$details = new Details();
$details->setShipping(1.2)
    ->setTax(1.3)
    ->setSubtotal(17.50);

// ### Amount
// Lets you specify a payment amount.
// You can also specify additional details
// such as shipping, tax.
$amount = new Amount();
$amount->setCurrency("USD")
    ->setTotal(20)
    ->setDetails($details);

// ### Transaction
// A transaction defines the contract of a
// payment - what is the payment for and who
// is fulfilling it. 
$transaction = new Transaction();
$transaction->setAmount($amount)
    ->setItemList($itemList)
    ->setDescription("Payment description")
    ->setInvoiceNumber(uniqid());

// ### Redirect urls
// Set the urls that the buyer must be redirected to after 
// payment approval/ cancellation.
$baseUrl = getBaseUrl();
$redirectUrls = new RedirectUrls();
$redirectUrls->setReturnUrl("$baseUrl/ExecutePayment.php?success=true")
    ->setCancelUrl("$baseUrl/ExecutePayment.php?success=false");

// ### Payment
// A Payment Resource; create one using
// the above types and intent set to 'sale'
$payment = new Payment();
$payment->setIntent("sale")
    ->setPayer($payer)
    ->setRedirectUrls($redirectUrls)
    ->setTransactions(array($transaction));


// For Sample Purposes Only.
$request = clone $payment;

// ### Create Payment
// Create a payment by calling the 'create' method
// passing it a valid apiContext.
// (See bootstrap.php for more on `ApiContext`)
// The return object contains the state and the
// url to which the buyer must be redirected to
// for payment approval
try {
    $payment->create($apiContext);
} catch (Exception $ex) {
    // NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
    ResultPrinter::printError("Created Payment Using PayPal. Please visit the URL to Approve.", "Payment", null, $request, $ex);
    exit(1);
}

// ### Get redirect url
// The API response provides the url that you must redirect
// the buyer to. Retrieve the url from the $payment->getApprovalLink()
// method
$approvalUrl = $payment->getApprovalLink();

// NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
 ResultPrinter::printResult("Created Payment Using PayPal. Please visit the URL to Approve.", "Payment", "<a href='$approvalUrl' >$approvalUrl</a>", $request, $payment);

return $payment;
    }

}

?>