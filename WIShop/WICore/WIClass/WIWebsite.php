<?php

/**
* 
*/
class WIWebsite
{
    
    function __construct() 
    {
         $this->WIdb = WIdb::getInstance();
         $this->cart = new WICart();

    }




        public function webSite_essentials($column)
    {
        $sql = "SELECT * FROM `wi_header`";
        $query = $this->WIdb->prepare($sql);
        $query->execute();

        $res = $query->fetch(PDO::PARAM_STR);
        return $res[$column];
        //$res->closeCursor();
    }

    public function webSite_icons()
    {
        $sql = "SELECT * FROM `wi_site`";
        $query = $this->WIdb->prepare($sql);
        $query->execute();

        $res = $query->fetch(PDO::PARAM_STR);
        //echo $res;
        echo '<link rel="icon" type="image/png" href="../WIAdmin/WIMedia/Img/favicon/' . $res['favicon'] . '"/>';
        //$res->closeCursor();
    }

    

    public function Meta($page)
    {
         
          $query = $this->WIdb->prepare('SELECT * FROM `wi_meta` WHERE `page`=:page');
          $query->bindParam(':page', $page, PDO::PARAM_STR);
          $query->execute();
         while($result = $query->fetch(PDO::FETCH_ASSOC))
        {
            echo '<meta name="' . $result['name'] . '" content="' . $result['content'] . '" author="' . $result['author'] . '" >';
        }
        //$result->closeCursor();

    }

    public function Theme()
    {
      $in_use = 1;
      $sql ="SELECT * FROM `wi_theme` WHERE `in_use`=:in_use";
      $query = $this->WIdb->prepare($sql);
      $query->bindParam(':in_use', $in_use, PDO::PARAM_INT);
      $query->execute();

      $result = $query->fetch();
      $theme = $result['destination'];

      return $theme;

    }

    public function Styling($page)
    {
         $query = $this->WIdb->prepare('SELECT * FROM `wi_css` WHERE `page`=:page');
        $query->bindParam(':page', $page, PDO::PARAM_STR);
        $query->execute();

        while($res = $query->fetch(PDO::FETCH_ASSOC))
        {
        echo '<link href="../' . self::theme() . $res['href'] . '" rel="' . $res['rel'] . '">';
        }

       // $res->closeCursor();
    }

    public function Scripts($page)
    {
                 $query = $this->WIdb->prepare('SELECT * FROM `wi_scripts` WHERE `page`=:page');
                  $query->bindParam(':page', $page, PDO::PARAM_STR);
        $query->execute();

        while($res = $query->fetch(PDO::FETCH_ASSOC))
        {
        echo ' <script src="../' . self::theme() . $res['src'] . '" type="text/javascript"></script>';
        }

        //$res->closeCursor();
    }

    public function StartUp()
    {
        echo '<!DOCTYPE html>
                <html class="no-js" lang="en">
                <head>
                  <title>' . WEBSITE_NAME. ' </title>
                  <meta charset="utf-8">';
    }

    public function Social()
    {

        $query = $this->WIdb->prepare('SELECT * FROM `wi_Social`');
        $query->execute();

        while($res = $query->fetch(PDO::FETCH_ASSOC))
        {
            echo ' <ul class="social_media"> 
                            <li><a href="' . $res['facebook'] .'" data-placement="bottom" data-toggle="tooltip" class="fa fa-facebook" title="Facebook">Facebook</a></li>
                            <li><a href="' . $res['google'] .'" data-placement="bottom" data-toggle="tooltip" class="fa fa-google-plus" title="Google+">Google+</a></li>
                            <li><a href="' . $res['twitter'] .'" data-placement="bottom" data-toggle="tooltip" class="fa fa-twitter" title="Twitter">Twitter</a></li>
                            <li><a href="' . $res['pinterest'] .'" data-placement="bottom" data-toggle="tooltip" class="fa fa-pinterest" title="Pinterest">Pinterest</a></li>
                            <li><a href="' . $res['linkedIn'] .'" data-placement="bottom" data-toggle="tooltip" class="fa fa-linkedin" title="Linkedin">Linkedin</a></li>
                            <li><a href="' . $res['rss'] .'" data-placement="bottom" data-toggle="tooltip" class="fa fa-rss" title="Feedburner">RSS</a></li>
                        </ul><!-- End Social --> ';
        }
        //$res->closeCursor();
    }

    public function MainHeader()
    {
        $sql = "SELECT * FROM `wi_header`";
        $query = $this->WIdb->prepare($sql);
        $query->execute();

        while($res = $query->fetch(PDO::PARAM_STR))
        {
         echo ' <header class="header">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-2">
                            <div class="navbar_brand">
                                <a href="index.php">
                                <img alt=""  class="logo" src="../WIAdmin/WIMedia/Img/header/' . $res['logo'] .'"></a>
                                
                            </div>
                        </div>

                        <!-- start of header-->
                        <div class="col-lg-9 col-md-9 col-sm-10">
                        <div class="col-ms"> 
                        <div class="zapfino">' . $res['header_content'] . '
                        <span class="slogan">' . $res['header_slogan'] . '</span>
                        </div><!-- end col-ms-->
                        </div>
                         <!--end opf header-->

                         <!-- start of menu -->
                    </div>
                </div> 
        </header>';
    }
    //$res->closeCursor();

    }

    public function MainMenu()
    {
        $sql = "SELECT * FROM `wi_menu`";
        $query = $this->WIdb->prepare($sql);
        $query->execute();
        $result = $query->fetch();
        $menu_order = $result['sort'];

        $sql1 = "SELECT * FROM `wi_menu` ORDER BY :order";
        $query1 = $this->WIdb->prepare($sql1);
        $query1->bindParam(':order', $menu_order, PDO::PARAM_INT);
        $query1->execute();
        /*echo '<div class="col-lg-12 col-md-12 col-sm-12">
              <div id="nav">
               <ul id="mainMenu" class="mainMenu default">';
    */
            echo '<nav class="navbar navbar-inverse">
  <div class="container-fluid flx menuz">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="#"></a>
      <div class="logo">
 
        </div>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">';
        while($res = $query1->fetch(PDO::FETCH_ASSOC))
        {    
         echo '<li><a href="../' . $res['link'] . '">' . WILang::get('' .$res['lang'] .'') . '</a></li>';
         if($res['parent'] > 0)
         {
            echo '<li><a href="../' . $res['link'] . '">' . WILang::get('' .$res['lang'] .'') . '</a></li>';
         }
        }
       /* echo '</ul>
            </div><!-- nav -->   
            <!-- end of menu -->
            </div>';
            */
            echo '</ul>
    </div>
       

  </div>

  <ul class="nav navbar-nav navbar-right">
        <li class="dropdownCart"><a href="javascript:void(0)" id="cart" class="dropdown-toggle" aria-expanded="false" dropdown="false" data-toggle="dropdown"><span class="fa fa-shopping-cart"></span>Cart
<span class="badge">'; echo  $this->cart->CartCount(WISession::get('user_id') ); echo '</span></a>
<div class="dropdown-menu" >
  <div class="panel panel-success">
    <div class="panel-heading">
    </div>
    <div class="panel-body">
          <div class="row" id="cart_product"></div>

    </div>
    <div class="panel-footer">
    <a href="cart.php"> Go to Cart</a>
    </div>
  </div>
</div>

</li>
      </ul>
</nav>';
    }


   


    public function footer()
    {
        $id = 1;

        $date = date("Y");
        $http = str_replace("www.", "", $_SERVER['HTTP_HOST']);
        $query = $this->WIdb->prepare('SELECT * FROM `wi_footer` WHERE footer_id=:id');
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();

        while($res = $query->fetch(PDO::PARAM_STR))
        {
            echo '  <footer class="footer">
            <section class="footer_bottom container-fluid text-center">
            <div class="container">
                <div class="row">
                    <div class="">
                        <p class="copyright"><?php echo WILang::get("copyright");?> &copy; ' .$date . ' ' . $res['website_name'] . '-  All rights reserved.</p>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">

                    </div>
                </div>
            </div>
        </section>
        </footer>
        <!--End Footer-->';
        }
        //$res->closeCursor();
    }

    public function langClassSelector($lang)
    {
      //echo $lang;

      if( WILang::getLanguage() === $lang){
        return WILang::getLanguage();
      }else{
        return "fade";
      }

    }

      public function viewLang()
    {
    

         
        $sql = "SELECT * FROM `wi_lang`";
        $query = $this->WIdb->prepare($sql);
        $query->execute();
         echo '<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                         <div class="flags-wrapper">';
        while($res = $query->fetchAll(PDO::FETCH_ASSOC) ){

          
        foreach ($res as $lang ) {


        
            echo '<a href="' . $lang['href'] . '">
                 <img src="../WIAdmin/WIMedia/Img/lang/' . $lang['lang_flag'] . '" alt="' . $lang['name'] .'" title="' . $lang['name'] .'"
                      class="'. WIWebsite::langClassSelector($lang['lang']) .'" /></a>';
            }
        }

         echo '</div>
                    </div><!-- end col-lg-6 col-md-6 col-sm-6-->';
    } 


   

    public function PageMod($page, $column)
    {
        //echo "col" . $column;

                $result = $this->WIdb->selectColumn(
                    "SELECT * FROM `wi_page` WHERE `name`=:page",
                     array(
                       "page" => $page
                     ), $column
                  );
               // print_r($result[$column]);
         if(count($result < 1)){
            return $column;
         }else{
            return $column;
         }


    }

       public function pageModPower($page, $column)
        {
        //echo "col" . $column;

                $result[$column] = $this->WIdb->selectColumn(
                    "SELECT * FROM `wi_page` WHERE `name`=:page",
                     array(
                       "page" => $page
                     ), $column
                  );
               // print_r($result[$column]);
         if(count($result < 1)){
            return $result[$column];
         }else{
            return $result[$column];
         }
    }

    public function google_lang()
    {
      echo '<div class="col-lg-5 col-md-5 col-sm-5 col-xs-10">
                         <div class="flags-wrapper">
                         <div id="google_translate_element"></div><script type="text/javascript">
function googleTranslateElementInit() {
  new google.translate.TranslateElement({pageLanguage: `en`, layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, `google_translate_element`);
}
</script><script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
                         </div>
                    </div><!-- end col-lg-6 col-md-6 col-sm-6-->';

    }
}



?>
