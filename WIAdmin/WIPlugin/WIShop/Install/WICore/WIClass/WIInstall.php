<?php
/**
* Install Plugin Class
* Created by Warner Infinity
* Author Jules Warner
*/

class WIInstall
{
	function __construct() 
	{
       $this->WIdb = WIdb::getInstance();
       $this->System = new WISystem();
    }

    public function pluginCheck($plug)
    {
      $sql = "SELECT * FROM `wi_plugin` WHERE `plugin`=:label";

      $query = $this->WIdb->prepare($sql);
      $query->bindParam(':label', $plug, PDO::PARAM_STR);
      $query->execute();

      $result = $query->fetch();
      //print_r($result);
      if( count($result) > 1){
        return "1";
      }else{
        return "0";
      }
    }

    public function sidebarCheck($configs, $plug)
    {
      $label = $configs['sidebar_name'];
      $sql = "SELECT * FROM `wi_sidebar` WHERE `label`=:label";

      $query = $this->WIdb->prepare($sql);
      $query->bindParam(':label', $label, PDO::PARAM_STR);
      $query->execute();

      $result = $query->fetch();

      if( count($result) > 1){
        return "1";
      }else{
        return "0";
      }
    }

        public function menuCheck($configs, $plug)
        {    
          $label = $configs['sidebar_name'];
         $sql = "SELECT * FROM `wi_menu` WHERE `label`=:label";

      $query = $this->WIdb->prepare($sql);
      $query->bindParam(':label', $label, PDO::PARAM_STR);
      $query->execute();

      $result = $query->fetch();

      if( count($result) > 1){
        return "1";
      }else{
        return "0";
      }
    }

        public function CssCheck($configs, $plug)
    {
      $label = $configs['sidebar_name'];
      $sql = "SELECT * FROM `wi_css` WHERE `page`=:label";

      $query = $this->WIdb->prepare($sql);
      $query->bindParam(':label', $label, PDO::PARAM_STR);
      $query->execute();

      $result = $query->fetch();
      //print_r($result);
      if( count($result) > 1){
        return "1";
      }else{
        return "0";
      }
    }

    public function JsCheck($configs, $plug)
    {
      $label = $configs['sidebar_name'];
      $sql = "SELECT * FROM `wi_scripts` WHERE `page`=:label";

      $query = $this->WIdb->prepare($sql);
      $query->bindParam(':label', $label, PDO::PARAM_STR);
      $query->execute();

      $result = $query->fetch();
      //print_r($result);
      if( count($result) > 1){
        return "1";
      }else{
        return "0";
      }
    }

    public function MetaCheck($configs, $plug)
    {
      $label = $configs['sidebar_name'];
      $sql = "SELECT * FROM `wi_meta` WHERE `page`=:label";

      $query = $this->WIdb->prepare($sql);
      $query->bindParam(':label', $label, PDO::PARAM_STR);
      $query->execute();

      $result = $query->fetch();
      //print_r($result);
      if( count($result) > 1){
        return "1";
      }else{
        return "0";
      }
    }

        public function pageCheck($configs, $plug)
    {
      $label = $configs['sidebar_name'];
      $sql = "SELECT * FROM `wi_page` WHERE `name`=:label";

      $query = $this->WIdb->prepare($sql);
      $query->bindParam(':label', $label, PDO::PARAM_STR);
      $query->execute();

      $result = $query->fetch();
      //print_r($result);
      if( count($result) > 1){
        return "1";
      }else{
        return "0";
      }
    }


    public function CatCheck($cat)
    {
      $sql = "SELECT * FROM `wi_categories` WHERE `title`=:title";

      $query = $this->WIdb->prepare($sql);
      $query->bindParam(':title', $cat, PDO::PARAM_STR);
      $query->execute();

      $result = $query->fetch();
      //print_r($result);
      if( count($result) > 1){
        return "1";
      }else{
        return "0";
      }

    }

        public function BrandCheck($brand)
    {
      $sql = "SELECT * FROM `wi_brands` WHERE `title`=:title";

      $query = $this->WIdb->prepare($sql);
      $query->bindParam(':title', $brand, PDO::PARAM_STR);
      $query->execute();

      $result = $query->fetch();
      //print_r($result);
      if( count($result) > 1){
        return "1";
      }else{
        return "0";
      }

    }

    public function productCheck($product)
    {
      $sql = "SELECT * FROM `wi_products` WHERE `product_selector`=:title";

      $query = $this->WIdb->prepare($sql);
      $query->bindParam(':title', $product, PDO::PARAM_STR);
      $query->execute();

      $result = $query->fetch();
      //print_r($result);
      if( count($result) > 1){
        return "1";
      }else{
        return "0";
      }

    }

    public function AddPlugin($configs, $plug)
    {

      $pluginCheck = self::pluginCheck($plug);
      //echo "plug". $pluginCheck;
      if ($pluginCheck === "0") {
        
              $activated = "false";
              $Installed = "true";
        //echo "plugin" .$plug;
        // add plugin into db plugin
        $this->WIdb->insert('wi_plugin', array(
            "plugin"     => $plug,
            "activated"  => $activated,
            "Installed"  => $Installed
           
        ));

      }
 

    }

        public function AddtoSideBar($configs, $plug)
    {

      $label = $configs['sidebar_name'];
      $lang  = $configs['lang'];
      $sort  = $configs['sort_no'];
      $img   = $configs['img'];
  $parent_no = $configs['parent_no'];

      //check if sidebar links have been installed or not
      $sidebarCheck = self::sidebarCheck($configs, $plug);
      //echo "side". $sidebarCheck;
      if ($sidebarCheck === "0") {

         //place into sidebar db
        $this->WIdb->insert('wi_sidebar', array(
            "label" => $label,
            "lang"  => $lang,
            "sort"  => $sort,
            "img"   => $img,
            "parent" => $parent_no
           
        )); 
        $sidebarId = $this->WIdb->lastInsertId();
        
      $link  = $configs['link'];

        $this->WIdb->insert('wi_sidebar', array(
            "label"   => $label,
            "parent"  => $sidebarId,
            "link"    => $link,
            "sort"    => $parent_no,
            "lang"    => $lang
           
        )); 


        $link2  = $configs['link2'];
        $lang2  = $configs['lang2'];
        $this->WIdb->insert('wi_sidebar', array(
            "label"   => $label,
            "parent"  => $sidebarId,
            "link"    => $link2,
            "sort"    => "1",
            "lang"    => $lang2
           
        )); 
      }
       
    }

    public function AddToMenu($configs, $plug)
    {
       $menuCheck = self::menuCheck($configs,$plug);
      // echo "menu".$menuCheck;
      if ($menuCheck === "0") {
         //place into menu db
        $lang  = $configs['lang'];
      $label  = $configs['sidebar_name'];

        $this->WIdb->insert('wi_menu', array(
            "label"   => $label,
            "link"    => $plug .'/index.php',
            "lang"    => $lang
           
        )); 
      }
    }

    public function Tables($configs, $plug)
    {
        // install tables
        $sql = "CREATE TABLE IF NOT EXISTS `wi_brands` (
  `brand_id` int(100) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  PRIMARY KEY (`brand_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `wi_brands`
--

INSERT INTO `wi_brands` (`brand_id`, `title`) VALUES
(1, 'Samsung'),
(2, 'Dell'),
(3, 'Hp'),
(4, 'Apple'),
(5, 'LG'),
(6, 'Canon'),
(7, 'Nikon'),
(8, 'Sony'),
(9, 'Acer'),
(10, 'None'),
(11, 'Swift'),
(12, 'Nike'),
(13, 'Lenovo');

-- --------------------------------------------------------

--
-- Table structure for table `wi_cart`
--

CREATE TABLE IF NOT EXISTS `wi_cart` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `userId` bigint(20) NOT NULL,
  `sessionId` varchar(100) DEFAULT NULL,
  `token` varchar(100) DEFAULT NULL,
  `p_id` int(11) NOT NULL,
  `ip_addr` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `photo` text NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` smallint(6) DEFAULT '0',
  `firstName` varchar(50) DEFAULT NULL,
  `middleName` varchar(50) DEFAULT NULL,
  `lastName` varchar(50) DEFAULT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `line1` varchar(50) DEFAULT NULL,
  `line2` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `county` varchar(50) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime DEFAULT NULL,
  `content` text,
  PRIMARY KEY (`id`),
  KEY `idx_cart_user` (`userId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `wi_cart_item`
--

CREATE TABLE IF NOT EXISTS `wi_cart_item` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `productId` bigint(20) NOT NULL,
  `cartId` bigint(20) NOT NULL,
  `sku` varchar(100) NOT NULL,
  `price` float NOT NULL DEFAULT '0',
  `discount` float NOT NULL DEFAULT '0',
  `quantity` smallint(6) NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime DEFAULT NULL,
  `content` text,
  PRIMARY KEY (`id`),
  KEY `idx_cart_item_product` (`productId`),
  KEY `idx_cart_item_cart` (`cartId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `wi_categories`
--

CREATE TABLE IF NOT EXISTS `wi_categories` (
  `cat_id` int(100) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `wi_categories`
--

INSERT INTO `wi_categories` (`cat_id`, `title`) VALUES
(1, 'Furniture'),
(2, 'Mobile'),
(3, 'Bedding'),
(4, 'Ladies Wear'),
(5, 'Men Wear'),
(6, 'Kids Wear'),
(7, 'Computers'),
(8, 'Laptops');

-- --------------------------------------------------------

--
-- Table structure for table `wi_checkout_steps`
--

CREATE TABLE IF NOT EXISTS `wi_checkout_steps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `step_number` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `identifier` varchar(255) NOT NULL,
  `classification` enum('active','inactive') NOT NULL,
  `sort` varchar(255) NOT NULL,
  `show` enum('show','hide') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3;

--
-- Dumping data for table `wi_checkout_steps`
--

INSERT INTO `wi_checkout_steps` (`id`, `name`, `step_number`, `class`, `identifier`, `classification`, `sort`, `show`) VALUES
(1, 'shipping', 'stepOne', 'fa fa-user', 'step_one', 'active', '0', 'show'),
(2, 'payment', 'stepTwo', 'fa fa-list', 'step_two', 'inactive', '1', 'hide'),
(3, 'confirmation', 'stepThree', 'fa fa-gears', 'step_three', 'inactive', '2', 'hide');

-- --------------------------------------------------------

--
-- Table structure for table `wi_cust_address`
--

CREATE TABLE IF NOT EXISTS `wi_cust_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `postcode` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `address_ref` varchar(255) NOT NULL,
  `main_addy` enum('false','true') NOT NULL DEFAULT 'false',
  `phone` varchar(255) NOT NULL,
  `Shipping_costs` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;



-- --------------------------------------------------------

--
-- Table structure for table `wi_order`
--

CREATE TABLE IF NOT EXISTS `wi_order` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `userId` bigint(20) DEFAULT NULL,
  `sessionId` varchar(100) NOT NULL,
  `token` varchar(100) NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '0',
  `subTotal` float NOT NULL DEFAULT '0',
  `itemDiscount` float NOT NULL DEFAULT '0',
  `tax` float NOT NULL DEFAULT '0',
  `shipping` float NOT NULL DEFAULT '0',
  `total` float NOT NULL DEFAULT '0',
  `promo` varchar(50) DEFAULT NULL,
  `discount` float NOT NULL DEFAULT '0',
  `grandTotal` float NOT NULL DEFAULT '0',
  `firstName` varchar(50) DEFAULT NULL,
  `middleName` varchar(50) DEFAULT NULL,
  `lastName` varchar(50) DEFAULT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `line1` varchar(50) DEFAULT NULL,
  `line2` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `province` varchar(50) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime DEFAULT NULL,
  `content` text,
  PRIMARY KEY (`id`),
  KEY `idx_order_user` (`userId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;



-- --------------------------------------------------------

--
-- Table structure for table `wi_order_item`
--

CREATE TABLE IF NOT EXISTS `wi_order_item` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `productId` bigint(20) NOT NULL,
  `orderId` bigint(20) NOT NULL,
  `sku` varchar(100) NOT NULL,
  `price` float NOT NULL DEFAULT '0',
  `discount` float NOT NULL DEFAULT '0',
  `quantity` smallint(6) NOT NULL DEFAULT '0',
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime DEFAULT NULL,
  `content` text,
  PRIMARY KEY (`id`),
  KEY `idx_order_item_product` (`productId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ;

-- --------------------------------------------------------

--
-- Table structure for table `wi_product`
--

CREATE TABLE IF NOT EXISTS `wi_product` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `userId` bigint(20) NOT NULL,
  `title` varchar(75) NOT NULL,
  `metaTitle` varchar(100) DEFAULT NULL,
  `slug` varchar(100) DEFAULT NULL,
  `summary` tinytext,
  `type` smallint(6) DEFAULT '0',
  `category_id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `sku` varchar(100) DEFAULT NULL,
  `price` float NOT NULL DEFAULT '0',
  `discount` float DEFAULT '0',
  `Shipping` decimal(10,0) NOT NULL,
  `quantity` smallint(6) DEFAULT '0',
  `shop` tinyint(1) DEFAULT '0',
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime DEFAULT NULL,
  `publishedAt` datetime DEFAULT NULL,
  `startsAt` datetime DEFAULT NULL,
  `endsAt` datetime DEFAULT NULL,
  `content` text,
  `photo` text NOT NULL,
  `insurance` decimal(10,2) NOT NULL,
  `VAT` decimal(10,2) NOT NULL,
  `shipping_discount` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_slug` (`slug`),
  KEY `idx_product_user` (`userId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `wi_product`
--

INSERT INTO `wi_product` (`id`, `userId`, `title`, `metaTitle`, `slug`, `summary`, `type`, `category_id`, `brand_id`, `sku`, `price`, `discount`, `Shipping`, `quantity`, `shop`, `createdAt`, `updatedAt`, `publishedAt`, `startsAt`, `endsAt`, `content`, `photo`, `insurance`, `VAT`, `shipping_discount`) VALUES
(1, 1, 'SWIFT Diego Ready Assembled Chest of 4 Drawers', 'SWIFT Diego Ready Assembled Chest of 4 Drawers', NULL, 'Stylish and striking, the Diego collection of bedroom furniture from SWIFT is all about the stunning', 0, 1, 11, '', 300, 0, '40', 1, 0, '2020-06-23 12:59:14', NULL, NULL, NULL, NULL, NULL, 'Q9K33_SQ1_0000000004_BLACK_SLf.jpg', '0.00', '0.00', '0.00'),
(2, 1, 'Galaxy S20+ 5G 128Gb - Grey', 'Galaxy S20+ 5G 128Gb - Grey', NULL, 'The Samsung Galaxy S20+ 5G features a beautiful display and incredible cameras.\nBuy this handset be ', 0, 2, 1, '', 500, 0, '10', 1, 0, '2020-06-23 16:16:37', NULL, NULL, NULL, NULL, NULL, 'Q6MUG_SQ1_0000000005_GREY_SLf.jpg', '0.00', '0.00', '0.00'),
(3, 1, 'NSW Club Legging (Curve) - Black', 'NSW Club Legging (Curve) - Black', NULL, 'NSW Club Legging (Curve) - Black', 0, 4, 12, 'sku', 30, 0, '5', 0, 0, '2020-06-23 16:21:38', NULL, NULL, NULL, NULL, NULL, 'PKF3L_SQ1_0000000004_BLACK_MDf.jpg', '0.00', '0.00', '0.00'),
(4, 1, 'React Element 55 - Black', 'React Element 55 - Black', NULL, 'Size & Fit\nStandard fit\nAvailable in sizes 6-12\nDetails\nEnd use: Training\nMen’s React Element 5     ', 0, 5, 12, '', 145, 0, '10', 0, 0, '2020-06-23 16:31:14', NULL, NULL, NULL, NULL, NULL, 'PKM6T_SQ1_0000000019_BLACK_WHITE_SLf.jpg', '0.00', '0.00', '0.00'),
(5, 1, ' Max 90 Crib Shoe', ' Max 90 Crib Shoe', NULL, '                        ', 0, 6, 12, '', 50, 0, '10', 1, 0, '2020-06-23 16:33:46', NULL, NULL, NULL, NULL, NULL, 'PKCWJ_SQ1_0000003854_WHITE_GREY_PINK_SLf.jpg', '0.00', '0.00', '0.00'),
(6, 1, 'Lenovo Ideacentre A340-24IWL', 'Lenovo Ideacentre A340-24IWL', NULL, 'Lenovo Ideacentre A340-24IWL Intel Core i5 10210U 8GB RAM 1TB Hard Drive & 128GB SSD 23.8in Full HD ', 0, 7, 13, '0', 1120, 0, '0', 1, 0, '2020-06-23 16:36:39', NULL, NULL, NULL, NULL, NULL, 'QDWCG_SQ1_0000000088_NO_COLOR_SLf.jpg', '0.00', '0.00', '0.00');

-- --------------------------------------------------------

--
-- Table structure for table `wi_product_meta`
--

CREATE TABLE IF NOT EXISTS `wi_product_meta` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `productId` bigint(20) NOT NULL,
  `key` varchar(50) NOT NULL,
  `content` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_product_meta` (`productId`,`key`),
  KEY `idx_meta_product` (`productId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;

-- --------------------------------------------------------

--
-- Table structure for table `wi_product_review`
--

CREATE TABLE IF NOT EXISTS `wi_product_review` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `productId` bigint(20) NOT NULL,
  `parentId` bigint(20) DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `rating` smallint(6) NOT NULL DEFAULT '0',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `createdAt` datetime NOT NULL,
  `publishedAt` datetime DEFAULT NULL,
  `content` text,
  PRIMARY KEY (`id`),
  KEY `idx_review_product` (`productId`),
  KEY `idx_review_parent` (`parentId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `wi_product_review`
--

INSERT INTO `wi_product_review` (`id`, `productId`, `parentId`, `title`, `rating`, `published`, `createdAt`, `publishedAt`, `content`) VALUES
(1, 2, NULL, '', 2, 0, '0000-00-00 00:00:00', NULL, 'This si a new review'),
(2, 2, NULL, '', 2, 0, '0000-00-00 00:00:00', NULL, 'This is a new rating and review'),
(3, 2, 1, '', 4, 0, '0000-00-00 00:00:00', NULL, 'This is a reviewing of this product');

-- --------------------------------------------------------

--
-- Table structure for table `wi_recommended`
--

CREATE TABLE IF NOT EXISTS `wi_recommended` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `price` decimal(3,0) NOT NULL,
  `img` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `wi_shipping`
--

CREATE TABLE IF NOT EXISTS `wi_shipping` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `cost` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `wi_shipping`
--

INSERT INTO `wi_shipping` (`id`, `name`, `cost`) VALUES
(3, 'Royal Mail', '2.00'),
(4, 'parcelforce', '8.00'),
(5, 'Yodel', '4.00'),
(6, 'Hermes', '6.00');

-- --------------------------------------------------------

--
-- Table structure for table `wi_shop_settings`
--

CREATE TABLE IF NOT EXISTS `wi_shop_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shop_name` varchar(255) NOT NULL,
  `business_email` varchar(255) NOT NULL,
  `paypal_id` varchar(255) NOT NULL,
  `paypal_secret` varchar(255) NOT NULL,
  `paypal_callback` varchar(255) NOT NULL,
  `cancel_url` varchar(255) NOT NULL,
  `notify_url` varchar(255) NOT NULL,
  `VAT` enum('0','1') NOT NULL DEFAULT '0',
  `base_url` varchar(255) NOT NULL,
  `paypal_pro` enum('0','1') NOT NULL DEFAULT '0',
  `currency` varchar(255) NOT NULL,
  `currency_symbol` varchar(255) NOT NULL,
  `current_url` varchar(255) NOT NULL,
  `paypal_environment` enum('sandbox','production') NOT NULL DEFAULT 'sandbox',
  `paypal_base_url` varchar(255) NOT NULL,
  `paypal_pro_base_url` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

--
-- Dumping data for table `wi_shop_settings`
--


-- --------------------------------------------------------

--
-- Table structure for table `wi_transaction`
--

CREATE TABLE IF NOT EXISTS `wi_transaction` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `userId` bigint(20) NOT NULL,
  `orderId` bigint(20) NOT NULL,
  `code` varchar(100) NOT NULL,
  `type` smallint(6) NOT NULL DEFAULT '0',
  `mode` smallint(6) NOT NULL DEFAULT '0',
  `status` smallint(6) NOT NULL DEFAULT '0',
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime DEFAULT NULL,
  `content` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

";

        $query = $this->WIdb->prepare($sql);
        $query->execute();
    }


    public function StartUpDb($configs, $plug)
    {
      // add meta
      // add css
      //add scripts
      //add page
      $cssCheck = self::CssCheck($configs, $plug);
      $JsCheck = self::JsCheck($configs, $plug);
      $MetaCheck = self::MetaCheck($configs, $plug);
      $pageCheck = self::pageCheck($configs, $plug);
      if ($cssCheck === "0") {
        
        $css = "INSERT INTO `wi_css` ( `href`, `rel`, `page`) VALUES

( 'shop/css/frameworks/bootstrap.css', 'stylesheet', 'shop'),
( 'shop/css/login_panel/css/slide.css', 'stylesheet', 'shop'),
( 'shop/css/font-awesome.css', 'stylesheet', 'shop'),
( 'shop/css/vendor/bootstrap.min.css', 'stylesheet', 'shop'),
( 'shop/css/style.css', 'stylesheet', 'shop'),
( 'shop/css/layout/wide.css', 'stylesheet', 'shop'),
( 'shop/css/switcher.css', 'stylesheet', 'shop'),
( 'shop/css/frameworks/menus.css', 'stylesheet', 'shop'),
( 'shop/css/frameworks/bootstrap.css', 'stylesheet', 'product'),
( 'shop/css/login_panel/css/slide.css', 'stylesheet', 'product'),
( 'shop/css/font-awesome.css', 'stylesheet', 'product'),
( 'shop/css/vendor/bootstrap.min.css', 'stylesheet', 'product'),
( 'shop/css/style.css', 'stylesheet', 'product'),
( 'shop/css/layout/wide.css', 'stylesheet', 'product'),
( 'shop/css/switcher.css', 'stylesheet', 'product'),
( 'shop/css/frameworks/menus.css', 'stylesheet', 'product'),
( 'shop/css/frameworks/bootstrap.css', 'stylesheet', 'cart'),
( 'shop/css/login_panel/css/slide.css', 'stylesheet', 'cart'),
( 'shop/css/font-awesome.css', 'stylesheet', 'cart'),
( 'shop/css/vendor/bootstrap.min.css', 'stylesheet', 'cart'),
( 'shop/css/style.css', 'stylesheet', 'cart'),
( 'shop/css/layout/wide.css', 'stylesheet', 'cart'),
( 'shop/css/switcher.css', 'stylesheet', 'cart'),
( 'shop/css/frameworks/menus.css', 'stylesheet', 'cart'),
( 'shop/css/frameworks/bootstrap.css', 'stylesheet', 'checkout'),
( 'shop/css/login_panel/css/slide.css', 'stylesheet', 'checkout'),
( 'shop/css/font-awesome.css', 'stylesheet', 'checkout'),
( 'shop/css/vendor/bootstrap.min.css', 'stylesheet', 'checkout'),
( 'shop/css/style.css', 'stylesheet', 'checkout'),
( 'shop/css/layout/wide.css', 'stylesheet', 'checkout'),
( 'shop/css/switcher.css', 'stylesheet', 'checkout'),
( 'shop/css/frameworks/menus.css', 'stylesheet', 'checkout'),
( 'shop/css/checkout.css', 'stylesheet', 'checkout'),
('shop/css/cart.css', 'stylesheet', 'cart'),
( 'shop/css/shop.css', 'stylesheet', 'shop');



      ";

      $query = $this->WIdb->prepare($css);
        $query->execute();

      }

      if ($JsCheck === "0") {
        $js = "INSERT INTO `wi_scripts` ( `src`, `page`) VALUES
        ( 'site/js/frameworks/JQuery.js', 'shop'),
      ( 'site/js/frameworks/bootstrap.js', 'shop'),
      ( 'site/js/login_panel/js/slide.js', 'shop'),
      ( 'site/js/frameworks/JQuery.js', 'product'),
      ( 'site/js/frameworks/bootstrap.js', 'product'),
      ( 'site/js/login_panel/js/slide.js', 'product'),
      ( 'site/js/frameworks/JQuery.js', 'cart'),
      ( 'site/js/frameworks/bootstrap.js', 'cart'),
      ( 'site/js/login_panel/js/slide.js', 'cart'),
      ( 'site/js/frameworks/JQuery.js', 'checkout'),
      ( 'site/js/frameworks/bootstrap.js', 'checkout'),
      ( 'site/js/login_panel/js/slide.js', 'checkout')
      ";

      $query = $this->WIdb->prepare($js);
        $query->execute();
      }

      if ($MetaCheck === "0") {
        $Meta = "INSERT INTO `wi_meta` ( `page`, `name`, `content`, `author`) VALUES
      ( 'shop', 'viewport', 'width=device-width, initial-scale=1', 'Jules Warner'),
      ( 'shop', 'description', 'Warner-Infinity Content Management System with simplified back end', 'Jules Warner'),
      ( 'shop', 'keywords', 'WI, WICMS, System, UI', 'Jules Warner'),
      ( 'shop', 'author', 'warner-infinity', 'Jules Warner'),
      ( 'product', 'viewport', 'width=device-width, initial-scale=1', 'Jules Warner'),
      ( 'product', 'description', 'Warner-Infinity Content Management System with simplified back end', 'Jules Warner'),
      ( 'product', 'keywords', 'WI, WICMS, System, UI', 'Jules Warner'),
      ( 'product', 'author', 'warner-infinity', 'Jules Warner'),
      ( 'cart', 'viewport', 'width=device-width, initial-scale=1', 'Jules Warner'),
      ( 'cart', 'description', 'Warner-Infinity Content Management System with simplified back end', 'Jules Warner'),
      ( 'cart', 'keywords', 'WI, WICMS, System, UI', 'Jules Warner'),
      ( 'cart', 'author', 'warner-infinity', 'Jules Warner'),
      ( 'checkout', 'viewport', 'width=device-width, initial-scale=1', 'Jules Warner'),
      ( 'checkout', 'description', 'Warner-Infinity Content Management System with simplified back end', 'Jules Warner'),
      ( 'checkout', 'keywords', 'WI, WICMS, System, UI', 'Jules Warner'),
      ( 'checkout', 'author', 'warner-infinity', 'Jules Warner')
      ";
      
      $query = $this->WIdb->prepare($Meta);
        $query->execute();
      }

      if ($pageCheck === "0") {
        $page = "INSERT INTO `wi_page` ( `name`, `panel`, `top_head`, `header`, `left_sidebar`, `right_sidebar`, `contents`, `footer`) VALUES
      ( 'shop', '1', '1', '0', '0', '0', 'shop', '1'),
      ( 'product', '1', '1', '0', '0', '0', 'product', '1'),
      ( 'cart', '1', '1', '0', '0', '0', 'cart', '1'),
      ( 'checkout', '1', '1', '0', '0', '0', 'checkout', '1');
        ";
        $query = $this->WIdb->prepare($page);
        $query->execute();
      }
      
    }

   

    public function TransferFiles($configs, $plug)
    {
            // shop dir

            $source = dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) .'/WIPlugin/'. $plug .'/' . $plug.'/' . $plug;
            $dest = dirname(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))) . '/' . $plug;
            $check = dirname(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))) . '/'. $plug .'/';

            if(!file_exists($check)){
                $this->System->full_copy($source , $dest);
                $fil = glob($dest . "/*");
               print_r($fil);
            }

            //modules dir
            $source1 = dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) .'/WIPlugin/'. $plug .'/Install/Module/';
            $dest1 = dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . '/WIModule/';
            $check1 = dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . '/WIModule/'. $configs['lang'];

            if(!file_exists($check1)){
              $this->System->full_copy($source1 , $dest1);
             // $fil = glob($dest1 . "/*");
             //print_r($fil);
            }
            
           // $fil = glob($dest . "/*");
             //  print_r($fil);

            //shop back end shop page WIShop

            $source2 = dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) .'/WIPlugin/'. $plug .'/shop/' . $plug . '.php';
            $dest2 = dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . '/' . $plug . '.php';
            $check2 = dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . '/' . $plug . '.php';

            if(!file_exists($check2)){
              $this->System->file_copy($source2 , $dest2);
            }

            //shop back end shop options page

            $source3 = dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) .'/WIPlugin/'. $plug .'/shop/' . $plug . '_Options.php';
            $dest3 = dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . '/' . $plug . '_Options.php';
            $check3 = dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . '/' . $plug . '_Options.php';

            if(!file_exists($check3)){
              $this->System->file_copy($source3 , $dest3);
            }


            //shop back end shop include files 
            
            $source4 = dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) .'/WIPlugin/'. $plug .'/shop/WIInc/' . $plug;
            $dest4 = dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . '/WIInc/site/' . $plug;
            $check4 = dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . '/WIInc/site/' . $plug;

            if(!file_exists($check4)){
              $this->System->full_copy($source4 , $dest4);
                //$fil = glob($dest4 . "/*");
               //print_r($fil);
            }

            //shop back end shop inc page  shop

            $source5 = dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) .'/WIPlugin/'. $plug .'/shop/WIInc/' .$configs['lang'] . '.php';
            $dest5 = dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . '/WIInc/';
            $check5 = dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . '/WIInc/' .$configs['lang'] . '.php';

            if(!file_exists($check5)){
              $this->System->full_copy($source5 , $dest5);
            }

            //shop back end shop inc page shop_Options
            $source6 = dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) .'/WIPlugin/'. $plug .'/shop/WIInc/' .$configs['page'].'.php';
            $dest6 = dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . '/WIInc/';
            $check6 = dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . '/WIInc/' .$configs['page'].'.php';

            if(!file_exists($check6)){
              $this->System->full_copy($source6 , $dest6);

            }
                    

    }

    public function styling($configs, $plug)
    {
            $currentTheme = self::WITheme();

            $source = dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) .'/WIPlugin/'. $plug . '/Install/Theme/'. $configs['lang'];
            $dest = dirname(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))) . '/WITheme/' . $currentTheme .'/'. $configs['lang'];

          $check = dirname(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))) . '/WITheme/' . $currentTheme .'/'. $configs['lang'];

            if(!file_exists($check)){
              $this->System->full_copy($source , $dest);
               //$fil = glob($dest . "/*");
               //print_r($fil);
            }
               
            
            
          
    }

    public function WITheme()
    {
      $in_use = 1;
      $sql = "SELECT * FROM  `wi_theme` WHERE `in_use`=:in_use";
      $query = $this->WIdb->prepare($sql);
      $query->bindParam(':in_use', $in_use, PDO::PARAM_INT);
      $query->execute();

      $res = $query->fetch();
      $currentTheme = $res['theme'];

      return $currentTheme;
    }


}