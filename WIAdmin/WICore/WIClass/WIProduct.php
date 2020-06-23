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
        
    }

    public function EditPRoduct()
    {

    }

    public function DeleteProduct()
    {

    }



}

