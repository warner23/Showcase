<?php


/**
* 
*/
class WICart 
{
	
	function __construct()
	{
		$this->WIdb = WIdb::getInstance();
		$this->User = new WIUser(WISession::get('user_id'));
		$this->site = new WISite();
	}


	public function addProduct($pid, $qty)
	{

		$userId = $this->User->id();
		if($userId !=0 || $userId!=null)
		{

		  $result = $this->WIdb->select(
                    "SELECT * FROM `wi_product`
                     WHERE `id` = :p_id",
                     array(
                       "p_id" => $pid
                     )
                  );

		  
		  $this->WIdb->insert('wi_cart', array(
            "p_id"     => $pid,
            "ip_addr"  => $_SERVER['REMOTE_ADDR'],
            "userId"  => $userId,
            "title" => $result[0]['title'],
            "photo" => $result[0]['photo'],
            "quantity" => $qty,
            "price" => $result[0]['price'],
            "total_amount" => $result[0]['price'] * $qty
        ));

		  	echo '<div class="alert alert-success">
					<a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<b>Product is added..</b>
					</div>';

		}
	}

	public function getCart($userId)
	{

		$result = $this->WIdb->select(
                    "SELECT * FROM `wi_cart`
                     WHERE `userId` = :user_id",
                     array(
                       "user_id" => $userId
                     )
                  );

					echo '';
		if (count($result) > 0){
			$no = 1;
			foreach ($result as $res) {
			//var_dump($result);
			$id  = $res['id'];
			$pid = $res['p_id'];


			echo '<span class="item">
                    <span class="item-left">
                        <img src="../../../WIAdmin/WIMedia/Img/shop/products/' . $res['photo'] . '" alt="' . $res['title'] . '" style="width:45px;height:45px;" />
                        <span class="item-info">
                            <span class="title">' . $res['title'] . '</span>
                            <span class="price">' .CURRENCY_SYMBOL . '' . $res['price'] . '</span>
                        </span>
                    </span>
                    <span class="item-right">
                        <button class="btn btn-xs btn-danger pull-right" onclick="WICart.Delete(`' . $res['id'] . '`)">x</button>
                    </span>
                </span>';
				$no = $no +1;

				
		  }
		}

	}


	public function CheckCart()
	{
		$userId = $this->User->id();

		$result = $this->WIdb->select(
                    "SELECT * FROM `wi_cart`
                     WHERE `userId` = :user_id",
                     array(
                       "user_id" => $userId
                     )
                  );
		$count = 0;
		$total = 0;
        $len = count($result);
		foreach ($result as $basket) {

			 if($count == $len){
					$total = $total + $subtotal;
				}else{

				$subtotal = $basket['price'] * $basket['quantity'];
				$total = $total + $subtotal;
				echo '<tr>
							<td data-th="Product">
							<div class="row">
									<div class="col-sm-2 hidden-xs"><img src="../../../WIAdmin/WIMedia/Img/shop/products/' . $basket['photo'] . '" alt="..." cwqlass="img-responsive"/></div>
									<div class="col-sm-10">
										<h4 class="nomargin">' . $basket['title'] . '</h4>
									
									</div>
								</div>
							</td>
							<td data-th="Price" class="price">
							<span>' .CURRENCY_SYMBOL . '</span>
							<span id="price_' . $basket['id'] . '">' . $basket['price'] . ' </span>
							</td>
							<td data-th="Quantity">
					<input type="number" pid="' . $basket['id'] . '" class="form-control text-center qty" id="qty_' . $basket['id'] . '" placeholder="' . $basket['quantity'] . '" value="' . $basket['quantity'] . '" min="1">
							</td>
							<td data-th="Subtotal" class="text-center subtotal" id="total_' . $basket['id'] . '">' . $subtotal .'</td>
							<td class="actions" data-th="">
								<button class="btn btn-info btn-sm update"  onclick="WICart.refresh(`' . $basket['id'] . '`);">
								<i class="fa fa-refresh"></i>
								</button>
								<button class="btn btn-danger btn-sm delete" onclick="WICart.MainKartDelete(`' . $basket['id'] . '`);">
								<i class="fa fa-trash-o"></i>
								</button>							
							</td>
						</tr>
						<script type="text/javascript">

						$(document).ready(function () {

						   $(document).on("input", "#qty_' . $basket['id'] . '", function(){
						    var qty = $("#qty_' . $basket['id'] . '").val();
						    var price = parseInt($("#price_' . $basket['id'] . '").text());
						    var total = qty* price;
						    $("#total_' . $basket['id'] . '").html(total);
						     });

						     $(document).on("keydown", "#qty_' . $basket['id'] . '", function(){
						    var qty = $("#qty_' . $basket['id'] . '").val();
						    var price = parseInt($("#price_' . $basket['id'] . '").text());
						    var total = qty* price;
						    $("#total_' . $basket['id'] . '").html(total);
						    var gTotal = parseInt($("#total").text());
						    console.log(gTotal);
						    $("#total").empty();
						    var grandTotal = gTotal - price;
						    console.log(grandTotal);
						    $("#total").html(grandTotal);

						     });
						


						});
						</script>';
						$count++;
				}	  
						
			}

			echo '</tbody>
					<tfoot>
						<tr class="visible-xs">
							<td class="text-center"><strong>Total</strong></td>
						</tr>
						<tr>
							<td style="width:15%;"><a href="index.php" class="btn btn-warning"><i class="fa fa-angle-left"></i> Continue Shopping</a></td>
							<td></td>';
							if(VAT == 1){
								echo '<td class="hidden-xs text-center" id="vat"><strong>VAT :</strong></td>';
							}
							

							echo '<td class="hidden-xs text-center" >
							
							<strong></strong>
							<span id="currency">' .CURRENCY_SYMBOL . '</span><span id="total">' .$total .'</span>

							</td>

							<td><a href="checkout.php" class="btn btn-success btn-block">Checkout <i class="fa fa-angle-right"></i></a></td>
						</tr>
					</tfoot>
				';
	}

	public function CartCount($userId)
	{
		
		$result = $this->WIdb->select(
                    "SELECT * FROM `wi_cart` WHERE userId=:userId", array(
                    	"userId"  => $userId
                    	));
		//var_dump($result);
		return count($result);

	}

	public function checkoutCart()
	{
		$userId = $this->User->id();

		$result = $this->WIdb->select(
                    "SELECT * FROM `wi_cart`
                     WHERE `userId` = :user_id",
                     array(
                       "user_id" => $userId
                     )
                  );
		return $result;
	}

	public function CreateOrder()
	{

		$result = self::checkoutCart();

		$orders = "";
		$count= 0;
		$len = count($result);
		foreach ($result as $res) {
			$count++;
			
			if($count == $len){
				$orders .= '{
                "name" : "' . $res['title'] . '",
                "description" : "",
                "sku" : "sku'.$res['id'] .'",
                "unit_amount" : {
                    "currency_code" : "'.CURRENCY.'",
                    "value" : "' . number_format($res['price'],  2, '.', '') . '"
                },
                "quantity" : "' . $res['quantity'] . '"

            }';
			}else{
				 $orders .='{
                "name" : "' . $res['title'] . '",
                "description" : "",
                "sku" : "sku'.$res['id'] .'",
                "unit_amount" : {
                    "currency_code" : "'.CURRENCY.'",
                    "value" : "' . number_format($res['price'], 2, '.', '') . '"
                },
                "quantity" : "' . $res['quantity'] . '"

            },';
			}

		}
		return $orders;
		
	}

	public function newAddress()
	{
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

                      <div class="results" id="aresults"></div>';
	}

	public function OrderAddress()
	{
		$userId = $this->User->id();

		$result = $this->WIdb->select(
                    "SELECT * FROM `wi_cust_address`
                     WHERE `user_id` = :user_id",
                     array(
                       "user_id" => $userId
                     )
                  );
		return $result;
	}

		public function OrderCost()
	{
		$userId = $this->User->id();

		$result = $this->WIdb->select(
                    "SELECT * FROM `wi_cust_address`
                     WHERE `user_id` = :user_id",
                     array(
                       "user_id" => $userId
                     )
                  );
		$shipping = $result[0]['Shipping_costs'];
		if($shipping == " "){
			
		}else{
			return $shipping;
		}
		
	}



	public function TotalCost()
	{

		$userId = $this->User->id();

		$result = $this->WIdb->select(
                    "SELECT * FROM `wi_cart`
                     WHERE `userId` = :user_id",
                     array(
                       "user_id" => $userId
                     )
                  );
		$count = 0;
		$total = 0;
        $len = count($result);
		foreach ($result as $basket) {
			
			 if($count == $len){
			 	//$subtotal = $basket['price'] * $basket['quantity'];
					$total = $total + $subtotal;
				}else{
					$subtotal = $basket['price'] * $basket['quantity'];
				$total = $total + $subtotal;
				
				}
				$count++;
			}

		//echo $total;
		$shipping = self::OrderCost();

		$grandTotal = $total + $shipping;
		//echo $grandTotal;

		return number_format($grandTotal,  2, '.', '');
	}

	public function cart_delete($id)
	{
		$this->WIdb->delete("wi_cart", "id = :id", array( "id" => $id ));

		$msg = "You have removed an item from your basket";

		$user = WISession::get('user_id');

		$result = array(
		"status" => "successful",
		"msg"    => $msg,
		"user"   => $user
		);

		echo json_encode($result);
	}

	public function update_cart($qty, $id, $total)
	{

			$this->WIdb->update(
                    "wi_cart", 
                    array("quantity" => $qty, "total_amount" => $total), 
                    "`id` = :id",
                    array( "id" => $id )
               );

		$msg = "You have updated an item from your basket";

		$user = WISession::get('user_id');

		$result = array(
		"status" => "successful",
		"msg"    => $msg,
		"user"   => $user
		);

		echo json_encode($result);
	}

}

?>