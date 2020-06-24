<?php



class WIProduct
{

    function __construct(){
        $this->WIdb = WIdb::getInstance();

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

    public function EditPRoduct()
    {

    }

    public function DeleteProduct()
    {

    }



}

