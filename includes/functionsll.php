<?php

include_once 'db_connect.php';
 
function sec_session_start() {
/* session_cache_expire( 10 );
//session_start(); // NEVER FORGET TO START THE SESSION!!!
$inactive = 600;
if(isset($_SESSION['start']) ) {
$session_life = time() - $_SESSION['start'];
if($session_life > $inactive){
header("Location: logout.php");
}
}
$_SESSION['start'] = time(); */


    $session_name = 'sec_session_id';   // Set a custom session name
    $secure = SECURE;
    // This stops JavaScript being able to access the session id.
    $httponly = true;
    // Forces sessions to only use cookies.
    if (ini_set('session.use_only_cookies', 1) === FALSE) { 
	
        header("Location: ../error.php?err=Could not initiate a safe session (ini_set)");
		//header(string,replace,http_response_code)
	/*
	string	: Required. Specifies the header string to send
   replace	: Optional. Indicates whether the header should replace previous or add a second header. Default is TRUE (will replace). FALSE (allows multiple headers of the same type)
http_response_code  Optional. Forces the HTTP response code to the specified value (available in PHP 4.3 and higher)
	*/
        exit();
    }
//	session_cache_expire(4);
    // Gets current cookies params.
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params($cookieParams["lifetime"],$cookieParams["path"],   $cookieParams["domain"], $secure,   $httponly);
         // Sets the session name to the one set above.
    session_name($session_name);
    session_start();            // Start the PHP session 
    session_regenerate_id();    // regenerated the session, delete the old one. 
	
	
}


function login($email, $password) {
    // Using prepared statements means that SQL injection is not possible. 
    
$sql = "SELECT *  FROM user_master where `USER_ID` = '".$email."'  LIMIT 1";
echo $sql;
$retval = mysql_query($sql);
$row = mysql_fetch_array($retval);
  $num=mysql_numrows($retval);
   
    if ($retval) {
         // get variables from result.
 $user_id=$row['USER_ID'];
 $usercat=$row['user_type_code'];

 $db_password=$row['user_pwd'];
 $salt=$row['salt'];
    
        // hash the password with the unique salt.
        $password = hash('sha512', $password . $salt);
        if ($num == 1) {
            // If the user exists we check if the account is locked
            // from too many login attempts 
 
            if (checkbrute($user_id) == true) {
                // Account is locked 
                // Send an email to user saying their account is locked
                return false;
            } else {
                // Check if the password in the database matches
                // the password the user submitted.
                if ($db_password == $password) {
                    // Password is correct!
                    // Get the user-agent string of the user.
                    $user_browser = $_SERVER['HTTP_USER_AGENT'];
                    // XSS protection as we might print this value
                    $user_id = preg_replace("/[^0-9]+/", "", $user_id);
                    $_SESSION['USER_ID'] = $user_id;
                    // XSS protection as we might print this value
                    $username = preg_replace("/[^a-zA-Z0-9_\-]+/", 
                                                                "", 
                                                                $user_id);
                    $_SESSION['user_type_code'] = $usercat;
					
                    $_SESSION['login_string'] = hash('sha512',   $password . $user_browser);
                    // Login successful.
                    return true;
                } else {
                    // Password is not correct
                    // We record this attempt in the database
                    $now = time();
					 $sql_ins= "INSERT INTO login_attempts(user_id, time)
                                    VALUES ('$user_id', '$now')";
		// echo $sql_ins;
			$resul_ins= mysql_query($sql_ins) or die('could not connect');
			
                   
                    return false;
                }
            }
        } else {
            // No user exists.
            return false;
        }
    }  
}
 
function checkbrute($user_id) {
    // Get timestamp of current time 
    $now = time();
 
    // All login attempts are counted from the past 2 hours. 
    $valid_attempts = $now - (2 * 60 * 60);
 $query= "SELECT time   FROM login_attempts 
                             WHERE user_id = '$user_id'  
                            AND time > '$valid_attempts'";
 
   $result=mysql_query($query);
$num=mysql_numrows($result);

    if ($result) {
         
        // If there have been more than 5 failed logins 
        if ($num > 5) {
            return true;
        } else {
            return false;
        }

    }
}

function login_check() {
    // Check if all session variables are set 
    if (isset($_SESSION['USER_ID'], 
                        $_SESSION['user_type_code'], 
                        $_SESSION['login_string'])) {
 
        $user_id = $_SESSION['USER_ID'];
        $login_string = $_SESSION['login_string'];
        $username = $_SESSION['user_type_code'];
 
        // Get the user-agent string of the user.
        $user_browser = $_SERVER['HTTP_USER_AGENT'];
 
 $sql = "SELECT user_pwd  FROM user_master where `USER_ID` = '$user_id'  LIMIT 1";
 echo  $sql;
$retval = mysql_query($sql);
$row = mysql_fetch_array($retval);
  $num=mysql_numrows($retval);
    
 
            if ($num == 1) {
                // If the user exists get variables from result.
               $password=$row['user_pwd'];
                $login_check = hash('sha512', $password . $user_browser);
 
                if ($login_check == $login_string) {
                    // Logged In!!!! 
                    return true;
                } else {
                    // Not logged in 
                    return false;
                }
            } else {
                // Not logged in 
                return false;
            }
        } else {
            // Not logged in 
            return false;
        }
     
}

 
function esc_url($url) {
 
    if ('' == $url) {
        return $url;
    }
 
    $url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);
 
    $strip = array('%0d', '%0a', '%0D', '%0A');
    $url = (string) $url;
 
    $count = 1;
    while ($count) {
        $url = str_replace($strip, '', $url, $count);
    }
 
    $url = str_replace(';//', '://', $url);
 
    $url = htmlentities($url);
 
    $url = str_replace('&amp;', '&#038;', $url);
    $url = str_replace("'", '&#039;', $url);
 
    if ($url[0] !== '/') {
        // We're only interested in relative links from $_SERVER['PHP_SELF']
        return '';
    } else {
        return $url;
    }
}


function replacesafe($variable) {
    $variable = strip_html_tags($variable);
	$bad = array("/");
	$variable = str_replace($bad, "^", $variable);
     return $variable;
}

function retandreplacesafe($variable) {
    $variable = strip_html_tags($variable);
	$bad = array("!");
	$variable = str_replace($bad, "&", $variable);
     return $variable;
}

function retreplacesafe($variable) {
    $variable = strip_html_tags($variable);
	$bad = array("^");
	$variable = str_replace($bad, "/", $variable);
     return $variable;
}

function andreplacesafe($variable) {
    $variable = strip_html_tags($variable);
	$bad = array("&");
	$variable = str_replace($bad, "!", $variable);
     return $variable;
}



function make_safe($variable) {
    $variable = strip_html_tags($variable);
	$variable = andreplacesafe($variable);
	$variable = replacesafe($variable);
	
	$bad = array("=","<", ">", "/","\"","`","~","'","$","%","#");
	$variable = str_replace($bad, "", $variable);
    $variable = mysql_real_escape_string(trim($variable));
    return $variable;
}


function strip_html_tags( $text )
{
    $text = preg_replace(
        array(
          // Remove invisible content
            '@<head[^>]*?>.*?</head>@siu',
            '@<style[^>]*?>.*?</style>@siu',
            '@<script[^>]*?.*?</script>@siu',
            '@<object[^>]*?.*?</object>@siu',
            '@<embed[^>]*?.*?</embed>@siu',
            '@<applet[^>]*?.*?</applet>@siu',
            '@<noframes[^>]*?.*?</noframes>@siu',
            '@<noscript[^>]*?.*?</noscript>@siu',
            '@<noembed[^>]*?.*?</noembed>@siu'
        ),
        array(
            '', '', '', '', '', '', '', '', ''), $text );
      
    return strip_tags( $text);
}



function make_password($userid,$npass) {
    $variable = '';
	$DDate = Date("Y-m-d");
		$TTime = Time();
	
		 	$query="SELECT `user_s_id`, `user_id`, `user_pwd`, `user_type_code`, `user_id_code`, `salt`,`status` FROM `user_master` where   USER_ID='".$userid."' ";
			$result=mysql_query($query);
			 while($rowreg =  mysql_fetch_array($result))
		 	{	
		 		$USER_ID =   $rowreg['USER_ID'];
				$PASSWORD =  $rowreg['user_pwd'];
                $salt =  $rowreg['salt'];
			}
		
			 $ranpwd= generatePassword(12, 1, 2, 3);
  
   			// Create a random salt
        	$random_salt = hash('sha512', $ranpwd);
 
        	// Create salted password 
       		 $passwd = hash('sha512', $npass . $random_salt);
        
         $sql_inser= "update user_master set  user_pwd = '$passwd' ,salt = '$random_salt'  where USER_ID = '$USER_ID'";
		 
			$resul_inser= mysql_query($sql_inser) or die('could not connect');
			if(!$resul_inser){ $variable .=  "Database error occured";}
			 	else{   $variable .= "<h3>Your Password Updation is Completed</h3>";  }
				
    return $variable;
}


 
function loginadmin_check() {
    // Check if all session variables are set 
    if (isset($_SESSION['USER_ID'], 
                        $_SESSION['USER_CATG'], 
                        $_SESSION['login_string'])) {
 
        $user_id = $_SESSION['USER_ID'];
        $login_string = $_SESSION['login_string'];
        $username = $_SESSION['user_type_code'];
 
        // Get the user-agent string of the user.
        $user_browser = $_SERVER['HTTP_USER_AGENT'];
 
     $sql = "SELECT user_pwd  FROM user_master where `USER_ID` = '$user_id'  LIMIT 1";
	$retval = mysql_query($sql);
	$row = mysql_fetch_array($retval);
  	$num=mysql_numrows($retval);
     
            if ($num == 1) {
                // If the user exists get variables from result.
               $password=$row['user_pwd'];
               $login_check = hash('sha512', $password . $user_browser);
 
                if (($username == "2") && ($login_check == $login_string)) {
                    // Logged In!!!! 
                    return true;
                } else {
                    // Not logged in 
                    return false;
                }
            } else {
                // Not logged in 
                return false;
            }
        } else {
            // Not logged in 
            return false;
        }
}
 
 
function mainmenu(){
$menu = ' ';

$menu .= ' 
<div id="cssmenu" >
<ul>
<li><a href="dashboard.php">
                                 <span>Dashboard</span>
                            </a></li>
		 					
  ';
						
$sql2 = "SELECT `s_id`, `menu_name`, `menu_head`, `menu_url`, `c_date`, `c_user`, `status` FROM `menu_master` where status='A' and menu_head='0' order by menu_head, s_id";
 
if($_SESSION['USER_CATG']=="usr!23"){
	 
	 $querys  = mysql_query($sql2) or die("Query failed --3");
	 $aciv= "";
			while ($rowf  = mysql_fetch_array($querys))
			{
	 			 $sql  = "SELECT `s_id`, `menu_name`, `menu_head`, `menu_url`, `c_date`, `c_user`, `status`,  (select menu_name from menu_master where s_id=e.menu_head)module_name  FROM `menu_master` e   where menu_head='".$rowf["s_id"]."'   and status='A'";	 
 	 
 $query  = mysql_query($sql) or die("Query failed --1");
 $j=0;
       		while ($row  = mysql_fetch_array($query))
			{
			//if($rowf["s_id"]=="16"){ $aciv= "active"; }
			 	if($j==0){ $menu .= ' 
				 <li class="has-sub '.$aciv.'"><a href="#"><span>'.retreplacesafe($rowf["menu_name"]).'</span></a> <ul>';
	 
							} 
           			 
   $menu .= '<li> <a href="'.$row["menu_url"]. '"> <span>'.retreplacesafe($row["menu_name"]). ' </span></a></li>'; 
			 $j=$j+1;
			   
			}
		
			if($j!=0){  $menu .=  '  </ul></li>';
                       $j=0; } 
		  }
 
}
elseif($_SESSION['USER_CATG']=="emp"){
	$sql11 = "select DISTINCT accept_screens from role_master where s_id=(select Role_ID from employee_master where s_id='".$_SESSION["REF_CODE"]."')";
   //     echo $sql11 ;
		 $query11 = mysql_query($sql11) or die("Query failed --emp");
       		while ($row11 = mysql_fetch_array($query11))
			{
				$menus=$row11["accept_screens"];
			}
		 $querys  = mysql_query($sql2) or die("Query failed --1");
	
			while ($rowf  = mysql_fetch_array($querys))
			{
				 $sql  = "SELECT `s_id`, `menu_name`, `menu_head`, `menu_url`, `c_date`, `c_user`, `status`,  (select menu_name from menu_master where s_id=e.menu_head)module_name  FROM `menu_master` e   where menu_head='".$rowf["s_id"]."' and   s_id in (".$menus.") and status='A'";	 
// echo  $sql;
 $query  = mysql_query($sql) or die("Query failed --1");
 $j=0;
       		while ($row  = mysql_fetch_array($query))
			{
				if($j==0){ $menu .= '  <li class="has-sub"><a href="#"><span>'.retreplacesafe($rowf["menu_name"]).'</span></a> <ul>';
		/*		 <li class="treeview">
                            <a href="'.$rowf["menu_url"].'">
                                <i class="fa fa-laptop"></i>
                                <span>'.$rowf["menu_name"].'</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu"> '; */
						 } 
           			 
   $menu .= '<li> <a href="'.$row["menu_url"]. '"> <span>'.retreplacesafe($row["menu_name"]). '</span> </a></li>'; 
			 $j=$j+1;
			   
			}
		
			if($j!=0){  $menu .=  '  </ul></li>';
                       $j=0; } 
		} 

}
elseif($_SESSION['USER_CATG']=="usr"){

$menu .= '    <li class="has-sub"><a href="#">  <span>Courses</span>   </a>
                            <ul >
                                <li><a href="timetable.php"><span> Time Table </span></a></li>
                                <li><a href="feedback.php"><span> Feedback Details </span></a></li>
                                <li><a href="bookhistory.php"><span> Books History </span></a></li>
                            </ul>
                        </li>
                       ';
}
elseif($_SESSION['USER_CATG']=="nom"){

$menu .= '    <li class="treeview">
                             <a href="#">
                                <i class="fa fa-table"></i> <span>Nominee</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="nomineeentry.php"><i class="fa fa-angle-double-right"></i> Nominee Register</a></li>
                                <li><a href="nomineelist.php"><i class="fa fa-angle-double-right"></i> Nominee List</a></li>
                               
                            </ul>
                        </li>
                       ';
	}				   
                 
          $menu .= '           </ul>	</div> '; 

return $menu;
} 


function headeruser_menu($usercode){
$hhmuser='';
$design_name = $emp_name ="";
$sql = "select emp_code, emp_name, designation, (select design_name from design_master where design_code=e.designation) design_name from employee_master e where user_id='$usercode'";
	$result=mysql_query($sql);
			 while($rowreg =  mysql_fetch_array($result))
		 	{	
		 		$design_name =   $rowreg['design_name'];
				$emp_name =  $rowreg['emp_name'];
        	}
$hhmuser .=' <div class="user-panel">
                        <div class="pull-left image">
                            <img src="../img/user.png" class="img-circle" alt="User Image" />
                        </div>
                        <div class="pull-left info">
                            <p>Hello, '.$emp_name.'</p>

                            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
							 <a href="../includes/logout.php" class="fa fa-circle text-success"> Sign out</a>
                        </div>
                    </div>';
		return $hhmuser;
}
function header_menu($usercode){
$design_name = $emp_name ="";
$sql = "select emp_code, emp_name, designation, (select design_name from design_master where design_code=e.designation) design_name from employee_master e where user_id='$usercode'";
 
	$result=mysql_query($sql);
			 while($rowreg =  mysql_fetch_array($result))
		 	{	
		 		$design_name =   $rowreg['design_name'];
				$emp_name =  $rowreg['emp_name'];
        	}

$hmenu = '';
$hmenu .='  <ul class="nav navbar-nav">
                         
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span>'.$design_name.' <i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header bg-light-blue">
                                    <img src="../img/user.png" class="img-circle" alt="User Image" />
                                    <p>
                                       '.$emp_name.' - '.$design_name.'  
                                        <small><a href="../pages/changepassword.php">Change Password</a></small>
                                    </p>
                                </li>
                                <!-- Menu Body -- >
                                <li class="user-body">
                                    <div class="col-xs-4 text-center">
                                        <a href="../pages/changepassword.php">Change Password</a>
                                    </div>
                                   
                                </li>
                                <! -- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="../pages/profile.php" class="btn btn-default btn-flat">Profile</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="../includes/logout.php" class="btn btn-default btn-flat">Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>';
					
return $hmenu;
}
 
/*
function header_menu(){
$hmenu = '';
$hmenu .='  <ul class="nav navbar-nav">
                        <!-- Messages: style can be found in dropdown.less-->
                        <li class="dropdown messages-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-tasks"></i>
                                <span class="label label-success">4</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">You have 4 messages</li>
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu">
                                        <li><!-- start message -->
                                            <a href="#">
                                                <div class="pull-left">
                                                    <img src="img/avatar3.png" class="img-circle" alt="User Image"/>
                                                </div>
                                                <h4>
                                                    Support Team
                                                    <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                                </h4>
                                                <p>Why not buy a new awesome theme?</p>
                                            </a>
                                        </li><!-- end message -->
                                      
                                        <li>
                                            <a href="#">
                                                <div class="pull-left">
                                                    <img src="img/avatar.png" class="img-circle" alt="user image"/>
                                                </div>
                                                <h4>
                                                    Reviewers
                                                    <small><i class="fa fa-clock-o"></i> 2 days</small>
                                                </h4>
                                                <p>Why not buy a new awesome theme?</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="footer"><a href="#">See All Messages</a></li>
                            </ul>
                        </li>
                        <!-- Notifications: style can be found in dropdown.less -->
                        <li class="dropdown notifications-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-tasks"></i>
                                <span class="label label-warning">10</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">You have 10 notifications</li>
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu">
                                        <li>
                                            <a href="#">
                                                <i class="ion ion-ios7-people info"></i> 5 new members joined today
                                            </a>
                                        </li>
                                         
                                    </ul>
                                </li>
                                <li class="footer"><a href="#">View all</a></li>
                            </ul>
                        </li>
                        <!-- Tasks: style can be found in dropdown.less -->
                        <li class="dropdown tasks-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-tasks"></i>
                                <span class="label label-danger">9</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">You have 9 tasks</li>
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu">
                                        <li><!-- Task item -->
                                            <a href="#">
                                                <h3>
                                                    Design some buttons
                                                    <small class="pull-right">20%</small>
                                                </h3>
                                                <div class="progress xs">
                                                    <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                        <span class="sr-only">20% Complete</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </li><!-- end task item -->
                                        <li><!-- Task item -->
                                            <a href="#">
                                                <h3>
                                                    Create a nice theme
                                                    <small class="pull-right">40%</small>
                                                </h3>
                                                <div class="progress xs">
                                                    <div class="progress-bar progress-bar-green" style="width: 40%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                        <span class="sr-only">40% Complete</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </li><!-- end task item -->
                                        
                                    </ul>
                                </li>
                                <li class="footer">
                                    <a href="#">View all tasks</a>
                                </li>
                            </ul>
                        </li>
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span>Administrator <i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header bg-light-blue">
                                    <img src="img/avatar3.png" class="img-circle" alt="User Image" />
                                    <p>
                                        Admin - Administrator
                                        <small><a href="../pages/changepassword.php">Change Password</a></small>
                                    </p>
                                </li>
                                <!-- Menu Body -- >
                                <li class="user-body">
                                    <div class="col-xs-4 text-center">
                                        <a href="../pages/changepassword.php">Change Password</a>
                                    </div>
                                   
                                </li>
                                <! -- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="../pages/profile.php" class="btn btn-default btn-flat">Profile</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="../includes/logout.php" class="btn btn-default btn-flat">Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>';
					
return $hmenu;
}*/
 
function todolist(){
$tdo = '';
$tdo.= '  <!-- TO DO List -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <i class="ion ion-clipboard"></i>
                                    <h3 class="box-title">To Do List</h3>
                                    <div class="box-tools pull-right">
                                        <ul class="pagination pagination-sm inline">
                                            <li><a href="#">&laquo;</a></li>
                                            <li><a href="#">1</a></li>
                                            <li><a href="#">2</a></li>
                                            <li><a href="#">3</a></li>
                                            <li><a href="#">&raquo;</a></li>
                                        </ul>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <ul class="todo-list">
                                        <li>
                                            <!-- drag handle -->
                                            <span class="handle">
                                                <i class="fa fa-ellipsis-v"></i>
                                                <i class="fa fa-ellipsis-v"></i>
                                            </span>  
                                                                       
                                            <!-- todo text -->
                                            <span class="text">Design a nice theme</span>
                                            <!-- Emphasis label -->
                                            <small class="label label-danger"><i class="fa fa-clock-o"></i> 2 mins</small>
                                            <!-- General tools such as edit or delete-->
                                            <div class="tools">
                                                <i class="fa fa-edit"></i>
                                                <i class="fa fa-trash-o"></i>
                                            </div>
                                        </li>
                                        <li>
                                            <span class="handle">
                                                <i class="fa fa-ellipsis-v"></i>
                                                <i class="fa fa-ellipsis-v"></i>
                                            </span>                                            
                                          
                                            <span class="text">Make the theme responsive</span>
                                            <small class="label label-info"><i class="fa fa-clock-o"></i> 4 hours</small>
                                            <div class="tools">
                                                <i class="fa fa-edit"></i>
                                                <i class="fa fa-trash-o"></i>
                                            </div>
                                        </li>
                                        <li>
                                            <span class="handle">
                                                <i class="fa fa-ellipsis-v"></i>
                                                <i class="fa fa-ellipsis-v"></i>
                                            </span>
                                       
                                            <span class="text">Let theme shine like a star</span>
                                            <small class="label label-warning"><i class="fa fa-clock-o"></i> 1 day</small>
                                            <div class="tools">
                                                <i class="fa fa-edit"></i>
                                                <i class="fa fa-trash-o"></i>
                                            </div>
                                        </li>
                                        <li>
                                            <span class="handle">
                                                <i class="fa fa-ellipsis-v"></i>
                                                <i class="fa fa-ellipsis-v"></i>
                                            </span>
                                          
                                            <span class="text">Let theme shine like a star</span>
                                            <small class="label label-success"><i class="fa fa-clock-o"></i> 3 days</small>
                                            <div class="tools">
                                                <i class="fa fa-edit"></i>
                                                <i class="fa fa-trash-o"></i>
                                            </div>
                                        </li>
                                        <li>
                                            <span class="handle">
                                                <i class="fa fa-ellipsis-v"></i>
                                                <i class="fa fa-ellipsis-v"></i>
                                            </span>
                                           
                                            <span class="text">Check your messages and notifications</span>
                                            <small class="label label-primary"><i class="fa fa-clock-o"></i> 1 week</small>
                                            <div class="tools">
                                                <i class="fa fa-edit"></i>
                                                <i class="fa fa-trash-o"></i>
                                            </div>
                                        </li>
                                        <li>
                                            <span class="handle">
                                                <i class="fa fa-ellipsis-v"></i>
                                                <i class="fa fa-ellipsis-v"></i>
                                            </span>
                                           
                                            <span class="text">Let theme shine like a star</span>
                                            <small class="label label-default"><i class="fa fa-clock-o"></i> 1 month</small>
                                            <div class="tools">
                                                <i class="fa fa-edit"></i>
                                                <i class="fa fa-trash-o"></i>
                                            </div>
                                        </li>
                                    </ul>
                                </div><!-- /.box-body -->
                              <!--  <div class="box-footer clearfix no-border">
                                    <button class="btn btn-default pull-right"><i class="fa fa-plus"></i> Add item</button>
                                </div>-->
                            </div><!-- /.box -->' ;
							
return $tdo;							
}

function dashChart(){

$dchart = '';
$dchart .= '
 <!-- Custom tabs (Charts with tabs)-->
                            <div class="nav-tabs-custom">
                                <!-- Tabs within a box -->
                                <ul class="nav nav-tabs pull-right">
                                    <li class="active"><a href="#revenue-chart" data-toggle="tab">Quarter Wise Participants</a></li>
                                    <li><a href="#sales-chart" data-toggle="tab">Donut</a></li>
                                    <li class="pull-left header"><i class="fa fa-inbox"></i> Graph</li>
                                </ul>
                                <div class="tab-content no-padding">
                                    <!-- Morris chart - Sales -->
                                    <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 350px;">
									<iframe src="../prismind/examples/charts/erp_e_bar.html" frameborder="0" width="500" height="300px" ></iframe>
 
									</div>
                                    <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 350px;">
										<iframe src="../prismind/examples/charts/part_e_pie.html" frameborder="0" width="500" height="300px" ></iframe>
 </div>
                                </div>
                            </div><!-- /.nav-tabs-custom -->
							';
	return $dchart;						
}


function generatePassword($l = 8, $c = 0, $n = 0, $s = 0) {
     // get count of all required minimum special chars
     $count = $c + $n + $s;
 
     // sanitize inputs; should be self-explanatory
     if(!is_int($l) || !is_int($c) || !is_int($n) || !is_int($s)) {
          trigger_error('Argument(s) not an integer', E_USER_WARNING);
          return false;
     }
     elseif($l < 0 || $l > 20 || $c < 0 || $n < 0 || $s < 0) {
          trigger_error('Argument(s) out of range', E_USER_WARNING);
          return false;
     }
     elseif($c > $l) {
          trigger_error('Number of password capitals required exceeds password length', E_USER_WARNING);
          return false;
     }
     elseif($n > $l) {
          trigger_error('Number of password numerals exceeds password length', E_USER_WARNING);
          return false;
     }
     elseif($s > $l) {
          trigger_error('Number of password capitals exceeds password length', E_USER_WARNING);
          return false;
     }
     elseif($count > $l) {
          trigger_error('Number of password special characters exceeds specified password length', E_USER_WARNING);
          return false;
     }
 
     // all inputs clean, proceed to build password
 
     // change these strings if you want to include or exclude possible password characters
     $chars = "abcdefghijklmnopqrstuvwxyz";
     $caps = strtoupper($chars);
     $nums = "0123456789";
     $syms = "1979ADAMshaffi";
     $out = "";
 
     // build the base password of all lower-case letters
     for($i = 0; $i < $l; $i++) {
          $out .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
     }
 
     // create arrays if special character(s) required
     if($count) {
          // split base password to array; create special chars array
          $tmp1 = str_split($out);
          $tmp2 = array();
 
          // add required special character(s) to second array
          for($i = 0; $i < $c; $i++) {
               array_push($tmp2, substr($caps, mt_rand(0, strlen($caps) - 1), 1));
          }
          for($i = 0; $i < $n; $i++) {
               array_push($tmp2, substr($nums, mt_rand(0, strlen($nums) - 1), 1));
          }
          for($i = 0; $i < $s; $i++) {
               array_push($tmp2, substr($syms, mt_rand(0, strlen($syms) - 1), 1));
          }
 
          // hack off a chunk of the base password array that's as big as the special chars array
          $tmp1 = array_slice($tmp1, 0, $l - $count);
          // merge special character(s) array with base password array
          $tmp1 = array_merge($tmp1, $tmp2);
          // mix the characters up
          shuffle($tmp1);
          // convert to string for output
          $out = implode('', $tmp1);
     }
 
     return $out;
}


function fdate_convert($date){
$ret="";
$pieces = explode("/", $date);
$ret=$pieces[2]."-".$pieces[1]."-".$pieces[0];
return $ret;
}

function rdate_convert($date){
$ret="";
$pieces = explode("-", $date);
$ret=$pieces[2]."/".$pieces[1]."/".$pieces[0];
return $ret;
}
	
	
	
   
function upcommingcourse() {
 $res='';
   $query= "SELECT `s_id`, `SCHEDULE_ID`, `SCHEDULE_YEAR`, `START_DATE`, `END_DATE`, `COURSE_CODE`,(select COURSE_NAME from course_master where s.COURSE_CODE=S_ID) COURSE_NAME, `COURSE_duration`, `STATUS_FLAG`, `TRAINEE_TYPE` FROM `schedule_master` s where START_DATE  >=CURDATE() and START_DATE  <= DATE_ADD(CURDATE(), INTERVAL 14 day)  ";
 
   $result=mysql_query($query);
	while ($rowm = mysql_fetch_array($result)) {
	$res .= '&nbsp; &nbsp; '. retreplacesafe($rowm['COURSE_NAME']).'('.rdate_convert($rowm['START_DATE']).' - '.rdate_convert($rowm['END_DATE']).') &nbsp; &nbsp; '; 
		}
  return  $res;
}
   