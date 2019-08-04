<?php
 ob_start("ob_gzhandler");
include_once 'db_connect.php';
include_once 'functions.php';
sec_session_start(); // Our custom secure way of starting a PHP session.

if (isset($_POST['userid'], $_POST['password'])) {
    
	$userid = make_safe($_POST['userid']);
 $password =   make_safe($_POST['password']);
 //pll9dq47moTw
 //echo ';;;;;;;;;;;'.$userid;
 //echo ';;;;;;;;;'.$password;
    if (login($userid, $password) == true) {
        // Login success 
		//echo 'shashi';
      header('Location: ../pages/home.php');
        exit();
   }  else {
        // Login failed 
       header('Location: ../index.php?error=1');
        
        exit();
    }
   
 {
    // The correct POST variables were not sent to this page. 
    echo 'Invalid Request';
}}
 ob_end_clean();
 ?> 
