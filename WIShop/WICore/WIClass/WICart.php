<?php


/**
* 
*/
class WICart 
{
	
	function __construct()
	{
		$this->WIdb = WIdb::getInstance();
	}


	public function addProduct($pid, $qty)
	{

		$userId = WISession::get('user_id');
		if($userId !=0 || $userId!=null)
		{

		  $result = $this->WIdb->select(
                    "SELECT * FROM `wi_products`
                     WHERE `product_id` = :p_id",
                     array(
                       "p_id" => $pid
                     )
                  );

		  

		  $this->WIdb->insert('wi_cart', array(
            "p_id"     => $pid,
            "ip_addr"  => $_SERVER['REMOTE_ADDR'],
            "user_id"  => $userId,
            "product_title" => $result[0]['product_title'],
            "product_image" => $result[0]['product_image'],
            "quantity" => $qty,
            "price" => $result[0]['product_price'],
            "total_amount" => $result[0]['product_price'] * $quant
        ));

		  	echo '<div class="alert alert-success">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<b>Product is added..</b>
					</div>';

		}
	}

	public function getCart($userId)
	{

		$result = $this->WIdb->select(
                    "SELECT * FROM `wi_cart`
                     WHERE `user_id` = :user_id",
                     array(
                       "user_id" => $userId
                     )
                  );
		if (count($result) > 0){
			$no = 1;
			foreach ($result as $res) {
			//var_dump($result);
			$id  = $res['id'];
			$pid = $res['p_id'];

			//<div class="col-md-3 col-sm-3 col-xs-3 col-lg-3">' . $no .'</div>
			//echo "id" . $id;
			echo '<div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
			
				<div class="col-md-3 col-sm-3 col-xs-3 col-lg-3">
				<div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
				<img class="img-responsive" src="../../../WIAdmin/WIMedia/Img/shop/' . $res['product_image'] . '" style="width:60px;height:60px;">
				</div>
				</div>
				<div class="col-md-3 col-sm-3 col-xs-3 col-lg-3">' . $res['product_title'] . '</div>
				<div class="col-md-2 col-sm-2 col-xs-2 col-lg-2">' . $res['price'] . '</div>
				<div class="col-md-2 col-sm-2 col-xs-2 col-lg-2">' . $res['quantity'] . '</div>
				</div>';
				$no = $no +1;
		  }
		}

	}


	public function CheckCart()
	{
		$userId = WISession::get('user_id');

		$result = $this->WIdb->select(
                    "SELECT * FROM `wi_cart`
                     WHERE `user_id` = :user_id",
                     array(
                       "user_id" => $userId
                     )
                  );
		$count = 0;
		$total = 0;
        $len = count($result);
		foreach ($result as $basket) {
				$subtotal = $basket['price'] * $basket['quantity'];
				$total =+ $subtotal;
				echo '<tr>
							<td data-th="Product">
								<div class="row">
									<div class="col-sm-2 hidden-xs"><img src="../../../WIAdmin/WIMedia/Img/shop/' . $basket['product_image'] . '" alt="..." cwqlass="img-responsive"/></div>
									<div class="col-sm-10">
										<h4 class="nomargin">' . $basket['product_title'] . '</h4>
										<p>Quis aute iure reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Lorem ipsum dolor sit amet.</p>
									</div>
								</div>
							</td>
							<td data-th="Price" class="price">
							<span>£</span>
							<span id="price_' . $basket['id'] . '">' . $basket['price'] . ' </span>
							</td>
							<td data-th="Quantity">
					<input type="number" pid="' . $basket['id'] . '" class="form-control text-center qty" id="qty_' . $basket['id'] . '" placeholder="' . $basket['quantity'] . '" value="' . $basket['quantity'] . '">
							</td>
							<td data-th="Subtotal" class="text-center subtotal" id="total_' . $basket['id'] . '">' . $subtotal .'</td>
							<td class="actions" data-th="">
								<button class="btn btn-info btn-sm update"><i class="fa fa-refresh"></i></button>
								<button class="btn btn-danger btn-sm delete"><i class="fa fa-trash-o"></i></button>							
							</td>
						</tr>
						<script type="text/javascript">

						$(document).ready(function () {

						    $("body").delegate("#qty_' . $basket['id'] . '", "keyup", function(){
						    var qty = $("#qty_' . $basket['id'] . '").val();
						    console.log(qty);
						    var price = $("#price_' . $basket['id'] . '").html();
						    console.log(price);
						    var total = qty * price;
						    console.log(total);
						    $("#total_' . $basket['id'] . '").html(total);

						        });

						    $(document).on("input", "#qty_' . $basket['id'] . '", function(){
						    var qty = $("#qty_' . $basket['id'] . '").val();
						    var price = $("#price_' . $basket['id'] . '").text();
						    var total = qty* price;
						    $("#total_' . $basket['id'] . '").html(total);
						});

						});

						</script>';

				   if($count == $len){
					$total =+ $subtotal;
				}
						$count++;
			}

			echo '</tbody>
					<tfoot>
						<tr class="visible-xs">
							<td class="text-center"><strong>Total</strong></td>
						</tr>
						<tr>
							<td style="width:15%;"><a href="index.php" class="btn btn-warning"><i class="fa fa-angle-left"></i> Continue Shopping</a></td>
							<td></td>
							<td class="hidden-xs text-center" id="vat"><strong>VAT :</strong></td>

							<td class="hidden-xs text-center" >
							
							<strong>Total: £</strong>
							<span id="total">' .$total .'</span>

							</td>

							<td><a href="checkout.php" class="btn btn-success btn-block">Checkout <i class="fa fa-angle-right"></i></a></td>
						</tr>
					</tfoot>
				';
	}

	public function CartCount($userId)
	{
		//$userId = WISession::get('user_id');
		//echo "usert" . $userId;
		$result = $this->WIdb->select(
                    "SELECT * FROM `wi_cart` WHERE user_id=:userId", array(
                    	"userId"  => $userId
                    	));
		//var_dump($result);
		return count($result);

	}

}

?>