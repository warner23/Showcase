<?php




/**
* 
*/
class WIShop 
{
    
    function __construct()
    {
        $this->WIdb = WIdb::getInstance();
        $this->Page = new WIPagination();
        $this->maint = new WIMaintenace();
    }

    public function Cat()
    {

         echo '<div class="nav nav-pills nav-stacked">
           <li class="active">
           <a href="javascript:void(0);">
           <h4>Categories</h4></a>
           </li>';

         $result = $this->WIdb->select('SELECT * FROM `wi_categories`');

         foreach($result as $res){
        echo '<li>
        <a href="javascript:void(0);" class="category" cid="' . $res['cat_id']. '">' . $res['title'] . '</a>


        </li>';
         }
    
       echo '</div>';
    }

    public function EditCat()
    {
        echo '
        <style>
        ul, ol{ display:inline-block; vertical-align:top; margin:5%; padding:0; }
li{
  max-width:170px; margin-bottom:8px;
  a{ margin-left:5px; cursor:pointer;
    &:hover{ text-decoration:none; }
    &::before{
      color:red;
      content:"\00D7";
    }
  }
}

.repoLink{ position:absolute; top:10px; right:10px; font-weight:700; }
        </style>';
         echo '<section>
            <h4>Categories</h4>
             <ol id="catList">';

         $result = $this->WIdb->select('SELECT * FROM `wi_categories`');

         foreach($result as $res){
        echo '<li><span contenteditable>' . $res['title'] . '</span></li>';
         }
    
       echo '</ol>
        </section>';
    }

    public function Brand()
    {
        echo '<div class="nav nav-pills nav-stacked">
    <li class="active">
    <a href="javascript:void(0);">
    <h4>Brands</h4>
    </li>';

        $result = $this->WIdb->select('SELECT * FROM wi_brands');

         foreach($result as $res){
            echo '<li>
            <a href="javascript:void(0);" class="brand" bid="' . $res['brand_id'] . '">' . $res['title'] . '
            </li>';
        }
        echo '</div>';

    }

    public function EditBrand()
    {
         echo '
        <style>
        ul, ol{ display:inline-block; vertical-align:top; margin:5%; padding:0; }
li{
  max-width:170px; margin-bottom:8px;
  a{ margin-left:5px; cursor:pointer;
    &:hover{ text-decoration:none; }
    &::before{
      color:red;
      content:"\00D7";
    }
  }
}

.repoLink{ position:absolute; top:10px; right:10px; font-weight:700; }
        </style>';
         echo '<section>
            <h4>Categories</h4>
             <ol id="brandList">';

        $result = $this->WIdb->select('SELECT * FROM wi_brands');

         foreach($result as $res){
          echo '<li><span contenteditable>' . $res['title'] . '</span></li>';
         }
    
       echo '</ol>
        </section>';

    }
    

    public function Product()
    {
         if(isset($_POST["page"])){
        $page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH); //filter number
        if(!is_numeric($page_number)){die('Invalid page number!');} //incase of invalid page number
    }else{
        $page_number = 1; //if there's no page number, set it to 1
    }

        $item_per_page = 15;
        $result = $this->WIdb->select(
                    "SELECT * FROM `wi_products`");
        $rows = count($result);


        //break records into pages
        $total_pages = ceil($rows/$item_per_page);
        
        //get starting position to fetch the records
        $page_position = (($page_number-1) * $item_per_page);

        $results = $this->WIdb->select(
                    "SELECT * FROM `wi_product` ORDER BY RAND() ASC LIMIT :page, :item_per_page",
                     array(
                       "page" => $page_position,
                       "item_per_page" => $item_per_page,
                ));

        foreach($results as $res) {
            echo '  <div class="col-md-4 col-lg-4 col-sm-4 col-xs-4">
        <a class="product_link" href="product.php" id="' . $result['product_id'] . '">
        <div class="panel panel-info" id="' . WISession::get('user_id') . '">
        <div class="panel-heading">' . $result['product_title'] . '</div>
        <div class="panel-body">
            <img src="../WIAdmin/WIMedia/Img/shop/' . $result['product_image'] . '" style="width:100%;height:100%;"/>
        </div>
        <div class="panel-footer">£' . $result['product_price'] . '
        </div>
        </div></a>
    </div>';
        }

        $Pagin = $this->Page->Pagination($item_per_page, $page_number, $rows, $total_pages);
    //print_r($Pagination);


         echo '<div align="center">';
    /* We call the pagination function here to generate Pagination link for us. 
    As you can see I have passed several parameters to the function. */
    echo $Pagin;
    echo '</div>';
    }

    public function productInfo($id)
    {

        $results = $this->WIdb->select(
                    "SELECT * FROM wi_products WHERE `product_id`=:id'",
                     array(
                       "id" => $id
                ));

        foreach($results as $res) {
            echo '<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                    <div id="product_msg"></div>
                            <img class="img-responsive" id="image" src="../../WIAdmin/WIMedia/Img/shop/' . $result['product_image']. '">
                        </div>

                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                        <input type="hidden" id="pid" name="quantity" value="' . $result['product_id']. '" class="span1" />
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                            <span></span><span id="name">' . $result['product_title']. ' </span>
                            </div>
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                            <span></span><span id="descript"> ' . $result['product_desc']. '</span>
                            </div>

                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                            <span>£</span><span id="price">' . $result['product_price']. ' </span>
                            </div>

                             <label>
                <input type="text" id="quantity" name="quantity" value="1" class="span1" />Qty
              </label>
        <button id="product" class="btn btn-primary cart" product="' . $result['product_id']. '">Add to Cart</button>
            
            <a href="#">+ Add to whishlist</a>
            

                        </div>';
        }
    }

    
    public function selectCat($cid)
    {

         $results = $this->WIdb->select(
                    "SELECT * FROM wi_products WHERE product_cat = :cid",
                     array(
                       "cid" => $cid
                ));

        foreach($results as $res) {
            echo '  <div class="col-md-4 col-lg-4 col-sm-4 col-xs-4">
        <div class="panel panel-info">
        <div class="panel-heading">' . $result['product_title'] . '</div>
        <div class="panel-body">
            <img src="../WIAdmin/WIMedia/Img/shop/' . $result['product_image'] . '" style="width:100%;height:100%;"/>
            
        </div>
        <div class="panel-footer">£' . $result['product_price'] . '

        </div>
        </div>
    </div>';
        }
    }


    public function selectBrand($bid)
    {

        $results = $this->WIdb->select(
                    "SELECT * FROM wi_products WHERE product_brand = :bid",
                     array(
                       "bid" => $bid
                ));

        foreach($results as $res) {
            echo '  <div class="col-md-4 col-lg-4 col-sm-4 col-xs-4">
        <div class="panel panel-info">
        <div class="panel-heading">' . $result['product_title'] . '</div>
        <div class="panel-body">
            <img src="../WIAdmin/WIMedia/Img/shop/' . $result['product_image'] . '" style="width:100%;height:100%;"/>
            
        </div>
        <div class="panel-footer">£' . $result['product_price'] . '

        </div>
        </div>
    </div>';
        }
    }


    public function Search($keywords)
    {

        $results = $this->WIdb->select("SELECT * FROM wi_products");

        foreach($results as $res) {
            echo '  <div class="col-md-4 col-lg-4 col-sm-4 col-xs-4">
        <div class="panel panel-info">
        <div class="panel-heading">' . $result['product_title'] . '</div>
        <div class="panel-body">
            <img src="../WIAdmin/WIMedia/Img/shop/' . $result['product_image'] . '" style="width:100%;height:100%;"/>
            
        </div>
       <div class="panel-footer">£' . $result['product_price'] . '

        </div>
        </div>
    </div>';
        }
    }


    public function Shop_Info($column) 
    {
        $user_id = 1;

        $result = $this->WIdb->select("SELECT * FROM `wi_shop_settings` WHERE `id` = :user_id", 
            array(
            "user_id" => $user_id
            )
        );
        if(count($result) > 0){
            return $result[0][$column];
        }else{

        }
        
        
    }

    public function shop_settings($shop_settings) 
    {
        $shop = $shop_settings['ShopData']; 
 
         $user_id  = 1;

        $result = $this->WIdb->select("SELECT * FROM `wi_shop_settings` WHERE `id` = :user_id", 
            array(
            "user_id" => $user_id
            )
        );

        if(count($result) > 0){

                $this->WIdb->update(
                    "wi_shop_settings", 
                    $shop, 
                    "`id` = :id",
                    array( "id" => $user_id )
               );

        $msg = WILang::get('successfully_updated_site_settings');

        $st1  = WISession::get('user_id') ;
        $st2  = "You have succesfully updated Shop Settings";
           $this->maint->Notifications($st1, $st2);

         $result = array(
                "status" => "successful",
                "msg" => $msg
            );
            
            //output result
            echo json_encode ($result);  

        }else{

         $this->WIdb->insert('wi_shop_settings', array(
            "shop_name"     => $shop['shop_name'],
            "business_email"  => $shop['business_email'],
            "paypal_id"  => $shop['paypal_id'],
            "paypal_secret" => $shop['paypal_secret'],
            "paypal_callback" => $shop['paypal_callback'],
            "cancel_url" => $shop['cancel_url'],
            "notify_url" => $shop['notify_url']
        )); 

            $msg = WILang::get('successfully_updated_site_settings');

                  $st1  = WISession::get('user_id') ;
            $st2  = "You have succesfully updated Shop Settings";
           $this->maint->Notifications($st1, $st2);

         $result = array(
                "status" => "successful",
                "msg" => $msg
            );
            
            //output result
            echo json_encode ($result);  
        }

    }

    public function prependNewItem($newItem)
    {
        $this->WIdb->insert('wi_categories', array(
            "title" => $newItem
        ));

        $msg = "You have successful added a new category" .$newItem;
        $result = array(
         "status" => "successful",
         "msg"    => $msg 
        ); 

        echo json_encode($result);
    }

        public function appendNewItem($newItem)
    {
        $this->WIdb->insert('wi_categories', array(
            "title" => $newItem
        ));

        $msg = "You have successful added a new category" .$newItem;
        $result = array(
         "status" => "successful",
         "msg"    => $msg 
        ); 

        echo json_encode($result);
    }


    public function prependbrandNewItem($newItem)
    {
        $this->WIdb->insert('wi_brands', array(
            "title" => $newItem
        ));

        $msg = "You have successful added a new Brand" .$newItem;
        $result = array(
         "status" => "successful",
         "msg"    => $msg 
        ); 

        echo json_encode($result);
    }

        public function appendbrandNewItem($newItem)
    {
        $this->WIdb->insert('wi_brands', array(
            "title" => $newItem
        ));

        $msg = "You have successful added a new Brand" .$newItem;
        $result = array(
         "status" => "successful",
         "msg"    => $msg 
        ); 

        echo json_encode($result);
    }

    public function getProdShipping()
    {
        $result = $this->WIdb->select("SELECT * FROM `wi_shipping`");


                 echo '
        <style>
        ul, ol{ display:inline-block; vertical-align:top; margin:5%; padding:0; }
        li{
          max-width:170px; margin-bottom:8px;
          a{ margin-left:5px; cursor:pointer;
            &:hover{ text-decoration:none; }
            &::before{
              color:red;
              content:"\00D7";
            }
          }
        }

        .repoLink{ position:absolute; top:10px; right:10px; font-weight:700; }
                </style>';
                 echo '<section>
            <h4>Shipping Options</h4>
             <ol id="shippingList">';

         foreach($result as $res){
          echo '<li><span contenteditable>' . $res['name'] . '</span></li>';
         }
    
       echo '</ol>
        </section>';

    }


        public function prependshippingNewItem($newItem)
    {
        $this->WIdb->insert('wi_shipping', array(
            "name" => $newItem
        ));

        $msg = "You have successful added a new Brand" .$newItem;
        $result = array(
         "status" => "successful",
         "msg"    => $msg 
        ); 

        echo json_encode($result);
    }

        public function appendshippingNewItem($newItem)
    {
        $this->WIdb->insert('wi_shipping', array(
            "name" => $newItem
        ));

        $msg = "You have successful added a new Brand" .$newItem;
        $result = array(
         "status" => "successful",
         "msg"    => $msg 
        ); 

        echo json_encode($result);
    }


}

?>