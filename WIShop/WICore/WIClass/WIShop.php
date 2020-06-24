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
    }

    public function Cat()
    {

    $result = $this->WIdb->select('SELECT * FROM `wi_categories`');

    echo '<div class="nav nav-pills nav-stacked">
    <li class="active"><a href="javascript:void(0);"><h4>Categories</h4></li>';
    foreach($result as $res){
        echo '<li><a href="javascript:void(0);" class="category" cid="' . $res['cat_id']. '">' . $res['title'] . '</li>';
    }
    echo '</div>';



}


    public function Brand()
    {

    $result = $this->WIdb->select('SELECT * FROM wi_brands'); 
        echo '<div class="nav nav-pills nav-stacked">
              <li class="active"><a href="javascript:void(0);"><h4>Brands</h4></li>';
    foreach($result as $res){
        echo '><li><a href="javascript:void(0);" class="brand" bid="' . $res['brand_id'] . '">' . $res['title'] . '</li>';
    }

        echo '</div>';

    }
    

    

    

    
    public function selectCat($cid)
    {

        $result = $this->WIdb->select('SELECT * FROM wi_product WHERE category_id = :cid', array(
            "cid" => $cid
            )
        ); 

        foreach($result as $res){
                        echo '  <div class="col-md-4 col-lg-4 col-sm-4 col-xs-4">
        <div class="panel panel-info">
        <div class="panel-heading">' . $res['title'] . '</div>
        <div class="panel-body">
            <img src="../WIAdmin/WIMedia/Img/shop/' . $res['photo'] . '" style="width:100%;height:100%;"/>
            
        </div>
        <div class="panel-footer">£' . $res['price'] . '

        </div>
        </div>
    </div>';
        }

    }


    public function selectBrand($bid)
    {
        $result = $this->WIdb->select('SELECT * FROM wi_product WHERE product_brand = :bid', array(
            "bid" => $bid
            )
        ); 

        foreach($result as $res){
            echo '  <div class="col-md-4 col-lg-4 col-sm-4 col-xs-4">
        <div class="panel panel-info">
        <div class="panel-heading">' . $res['title'] . '</div>
        <div class="panel-body">
            <img src="../WIAdmin/WIMedia/Img/shop/' . $res['photo'] . '" style="width:100%;height:100%;"/>
            
        </div>
        <div class="panel-footer">£' . $res['price'] . '

        </div>
        </div>
    </div>';
        }
    }


    public function Search($keywords)
    {

        $result = $this->WIdb->select('SELECT * FROM wi_product'); 

        foreach($result as $res){
            echo '  <div class="col-md-4 col-lg-4 col-sm-4 col-xs-4">
        <div class="panel panel-info">
        <div class="panel-heading">' . $res['title'] . '</div>
        <div class="panel-body">
            <img src="../WIAdmin/WIMedia/Img/shop/' . $res['photo'] . '" style="width:100%;height:100%;"/>
            
        </div>
       <div class="panel-footer">£' . $res['price'] . '

        </div>
        </div>
    </div>';
        }
    }


}

?>