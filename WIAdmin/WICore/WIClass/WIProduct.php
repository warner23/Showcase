<?php



class WIProduct
{

    function __construct(){
        $this->WIdb = WIdb::getInstance();
        $this->Page = new WIPagination();
    }

    public function CreateProduct()
    {

    }

    public function AddNewProduct($product)
    {
        $prod = $product['UserData'];
        $products = $product['FieldId'];

        //$this->WIdb->AutoInsert('wi_product', $products)
        $this->WIdb->insert('wi_product', $prod); 

        $msg = "You have successfully added a new Product.";
        $result = array(
            "status" => "success",
            "msg"  => $msg
        );

        echo json_encode($result);
        
    }

    public function EditProduct()
    {
                 if(isset($_POST["page"])){
        $page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH); //filter number
        if(!is_numeric($page_number)){die('Invalid page number!');} //incase of invalid page number
    }else{
        $page_number = 1; //if there's no page number, set it to 1
    }

        $item_per_page = 15;
        $result = $this->WIdb->select(
                    "SELECT * FROM `wi_product`");
        $rows = count($result);

        $onclick="WIProduct";
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
        <div class="panel panel-info" id="' . WISession::get('user_id') . '">
        <div class="panel-heading">' . $result['title'] . '</div>
        <div class="panel-body">
            <img src="../WIAdmin/WIMedia/Img/shop/products/' . $result['photo'] . '" class="img-responsive img img-fluid/>
        </div>
        <div class="panel-footer">£' . $result['price'] . '
        </div>
        </div>
    </div>';
        }

        $Pagin = $this->Page->Pagination($item_per_page, $page_number, $rows, $total_pages, $onclick);
    //print_r($Pagination);


         echo '<div align="center">';
    /* We call the pagination function here to generate Pagination link for us. 
    As you can see I have passed several parameters to the function. */
    echo $Pagin;
    echo '</div>';
    }

    public function DeleteProduct()
    {

    }



}

