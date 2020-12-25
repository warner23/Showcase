<?php
ini_set('display_errors',1);
error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT );

// Files that inculde this file at the very top would NOT require 
// connection to database or session_start(), be careful.
// Initialize some vars
$user_ok = false;
$log_id = "";
$log_username = "";
$log_password = "";
$log_email = "";



// User Verify function
function evalLoggedUser($db_conn,$id,$u,$e){
	$sql = "SELECT ip FROM users WHERE id='$id' AND username='$u' AND activated='1' LIMIT 1";
    $query = mysqli_query($db_conn, $sql);
    $numrows = mysqli_num_rows($query);


	if($numrows > 0){
		return true;
		
	}
	
}



if(isset($_SESSION["userid"]) && isset($_SESSION["username"]) && isset($_SESSION["password"])) {
	$log_id = preg_replace('#[^0-9]#', '', $_SESSION['userid']);
	$log_username = preg_replace('#[^a-z0-9]#i', '', $_SESSION['username']);
	$log_password = preg_replace('#[^a-z0-9]#i', '', $_SESSION['password']);
	// Verify the user
	$user_ok = evalLoggedUser($db_conn,$log_id,$log_username,$log_email);
} else if(isset($_COOKIE["id"]) && isset($_COOKIE["user"]) && isset($_COOKIE["pass"])){
	$_SESSION['userid'] = preg_replace('#[^0-9]#', '', $_COOKIE['id']);
    $_SESSION['username'] = preg_replace('#[^a-z0-9]#i', '', $_COOKIE['user']);
    $_SESSION['password'] = preg_replace('#[^a-z0-9]#i', '', $_COOKIE['pass']);
	$log_id = $_SESSION['userid'];
	$log_username = $_SESSION['username'];
	$log_password = $_SESSION['password'];
	// Verify the user
	$user_ok = evalLoggedUser($db_conn,$log_id,$log_username,$log_email);
	if($user_ok == true){
		// Update their lastlogin datetime field
		$sql = "UPDATE users SET lastlogin=now() WHERE id='$log_id' LIMIT 1";
        $query = mysqli_query($db_conn, $sql);
	}
}
?>