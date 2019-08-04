<?php
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';
 
sec_session_start();
$user_id = $_SESSION['USER_ID'];
         $login_string = $_SESSION['login_string'];
        $usercat = $_SESSION['USER_CATG']; 
?>

<div class="choose-left-grid col-sm-12">
		<div class="choose-page-grid ">
<?php echo $menu = mainmenu($user_id,$usercat); ?>
   </div>
 </div>  