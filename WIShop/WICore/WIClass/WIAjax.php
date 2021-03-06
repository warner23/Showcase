<?php
include_once 'WI.php';

//csrf protection
if(empty($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') 
    die("Sorry bro!");

$url = parse_url( isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '');
if( !isset( $url['host']) || ($url['host'] != $_SERVER['SERVER_NAME']))
    die("Sorry bro!");

$action = $_POST['action'];

switch ($action) {
	case 'checkLogin':
		$logged = $login->userLogin($_POST['username'], $_POST['password']);
        if($logged === true)
            echo json_encode(array(
                'status' => 'success',
                'page'   => get_redirect_page()
            ));
		break;
    case "registerUser":
        $register->register($_POST['User']);
        break;
        
    case "resetPassword":
        $register->resetPassword($_POST['newPass'], $_POST['key']);
        break;
        
    case "forgotPassword":
        $result = $register->forgotPassword($_POST['email']);
        if ( $result !== TRUE )
            echo $result;
        break;
        
    case "postComment":
        $WIComment = new WIComment();
        echo $WIComment->insertComment(WISession::get("user_id"), $_POST['comment']);
        break;
        
    case "updatePassword":
        $user = new WIUser(WISession::get("user_id"));
        $user->updatePassword($_POST['oldpass'], $_POST['newpass']);
        break;
        
    case "updateDetails":
        $user = new WIUser(WISession::get("user_id"));
        $user->updateDetails($_POST['details']);
        break;
        
    case "changeRole":
        onlyAdmin();

        $user = new WIUser($_POST['userId']);
        echo ucfirst($user->changeRole());
        break;
        
    case "deleteUser":
        onlyAdmin();

        $user = new WIUser($_POST['userId']);
        $user->deleteUser();
        break;
    
    case "getUserDetails":
        onlyAdmin();

        $user = new WIUser($_POST['userId']);
        echo json_encode( $user->getAll() );
        break;

    case "addRole": 
        onlyAdmin();

        $role = new WIRole();
        echo json_encode( $role->add($_POST['role']) );
        break;

    case "deleteRole":
        onlyAdmin();

        $role = new WIRole();
        $role->delete($_POST['roleId']);
        break;


    case "addUser":
        onlyAdmin();

        $user = new WIUser(null);
        echo json_encode( $user->add($_POST) );
        break;

    case "updateUser":
        onlyAdmin();

        $user = new WIUser($_POST['userId']);
        $user->updateUser($_POST);
        break;

    case "banUser":
        onlyAdmin();

        $user = new WIUser($_POST['userId']);
        $user->updateInfo(array( 'banned' => 'Y' ));
        break;

    case "unbanUser":
        onlyAdmin();

        $user = new WIUser($_POST['userId']);
        $user->updateInfo(array( 'banned' => 'N' ));
        break;

    case "getUser":
        onlyAdmin();

        $user = new WIUser($_POST['userId']);
        echo json_encode($user->getAll());
        break;

        //  shop
        case "getCat":
        $shop = new WIShop();
        $shop->Cat();
        break;
        
        case "getBrand":
        $shop = new WIShop();
        $shop->Brand();
        break;

        case "getProduct":
        $product = new WIProduct();
        $product->Product($_POST['get_product']);
        break;

        case "getProductOverView":
        $product = new WIProduct();
        $product->getProductOverView($_POST['product_id']);
        break;

        case "getProductInfor":
        $product = new WIProduct();
        $product->getProductInfor($_POST['product_id']);
        break;

        case "getProductReviews":
        $product = new WIProduct();
        $product->getProductReviews($_POST['product_id']);
        break;

        case "OpenReview":
        $review = new WIProductReview();
        $review->OpenReview($_POST['id']);
        break;

        case "saveReview":
        $review = new WIProductReview();
        $review->saveReview($_POST['review'], $_POST['new_rating'], $_POST['product_id']);
        break;

        case "selected_cat":
        $shop = new WIShop();
        $shop->selectCat($_POST['cat_id']);
        break;

        case "selected_brand":
        $shop = new WIShop();
        $shop->selectBrand($_POST['brand_id']);
        break;

        case "keyword":
        $shop = new WIShop();
        $shop->Search($_POST['keyword']);
        break;

        case "addProduct":
        $cart = new WICart();
        $cart->addProduct($_POST['pid'], $_POST['qty']);
        break;

        case "getCart":
        $cart = new WICart();
        $cart->getCart(WISession::get("user_id"));
        break;

        case "update_cart":
        $cart = new WICart();
        $cart->update_cart($_POST['qty'], $_POST['id'], $_POST['total']);
        break;

        case "cart_delete":
        $cart = new WICart();
        $cart->cart_delete($_POST['id']);
        break;

         case "cartCount":
        $cart = new WICart();
        $cart->CartCount($_POST['userId']);
        break;

        case "process":
        $check = new WICheckout();
        $check->PayPal();
        break;

        case "showPaymentExecute":
        $check = new WICheckout();
        $check->showPaymentExecute($_POST['response']);
        break;

        case "showPaymentGet":
        $check = new WICheckout();
        $check->showPaymentGet($_POST['response']);
        break;

        case "changeShipping":
        $shop = new WIShop();
        $shop->changeShipping($_POST['cost']);
        break;
	
	default:
		
		break;
}

$action = isset($_GET['action']) ? $_GET['action'] : null;
switch($action){

       case "checkout":
       $check = new WICheckout();
       $check->PayPal();
       break;

       case "cart":
       $check = new WICheckout();
       $check->cart();
       break;

       case "newAddress":
       $cart = new WICart();
       $cart->newAddress();
       break;
}

function onlyAdmin() {
    $login = new WILogin();
    if ( ! $login->isLoggedIn() ) exit();

    $loggedUser = new WIUser(WISession::get("user_id"));
    if( ! $loggedUser->isAdmin() ) exit();
}