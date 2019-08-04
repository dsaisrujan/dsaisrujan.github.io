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
	
        //header("Location: ../error.php?err=Could not initiate a safe session (ini_set)");
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


function login($userid, $password) {
    // Using prepared statements means that SQL injection is not possible. 
    
$sql = "SELECT *  FROM user_master where `USER_ID` = '$userid'  LIMIT 1";
echo '..;;;;;;;;;;;;;;;;;;;;;'.$sql;
$retval = mysql_query($sql);
$row = mysql_fetch_array($retval);
  $num=mysql_num_rows($retval);
   
    if ($retval) {
         // get variables from result.
 $user_id=$row['USER_ID'];
 $usercat=$row['USER_CATG'];
 $userref=$row['REFERENCE_CODE'];
 $db_password=$row['PASSWORD'];
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
                    $userid = preg_replace("/[^0-9]+/", "", $user_id);
					//echo $user_id;
					//echo 'gfhfgh'.$userid; 
                    $_SESSION['USER_ID'] = $user_id;
                    // XSS protection as we might print this value
                    $username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $user_id);
					
					//$_SESSION['USER_ID'] = $user_id;   										
                    $_SESSION['USER_CATG'] = $usercat;
					$_SESSION["REF_CODE"]= $userref;
                    $_SESSION['login_string'] = hash('sha512',   $password . $user_browser);
					//echo '..88888..'.$user_id;
					//echo '....'. $usercat;
					//echo '......'.$userref;
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
$num=mysql_num_rows($result);

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
    if (isset($_SESSION['USER_ID'])) {
 
        $user_id = $_SESSION['USER_ID'];
		//echo  $user_id;
        $login_string = $_SESSION['login_string'];
        $username = $_SESSION['USER_CATG'];
 
        // Get the user-agent string of the user.
        $user_browser = $_SERVER['HTTP_USER_AGENT'];
 
 $sql = "SELECT password  FROM user_master where `USER_ID` = '$user_id'  LIMIT 1";
// echo $sql; 
$retval = mysql_query($sql);
$row = mysql_fetch_array($retval);
  $num=mysql_num_rows($retval);
    
 
            if ($num == 1) {
                // If the user exists get variables from result.
               $password=$row['password'];
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

function retsingreplacesafe($variable) {
    $variable = strip_html_tags($variable);
	$bad = array("~");
	$variable = str_replace($bad, "'", $variable);
     return $variable;
}

function singreplacesafe($variable) {
    $variable = strip_html_tags($variable);
	$bad = array("'");
	$variable = str_replace($bad, "~", $variable);
     return $variable;
}

function retrivefuns($variable)
{ 
$variable = retsingreplacesafe($variable);
	$variable = retandreplacesafe($variable);
	$variable = retreplacesafe($variable);
	 return $variable;
}

function make_safe($variable) {
    $variable = strip_html_tags($variable);
	$variable = andreplacesafe($variable);
	$variable = replacesafe($variable);
	$variable = singreplacesafe($variable);
	
	$bad = array("=","<", ">", "/","\"","`","'","$","#");
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
	
		 	$query="SELECT `USER_ID`, `PASSWORD`, `REFERENCE_CODE`, `USER_CATG`,  `STATUS_FLAG`, `salt` FROM `user_master` where   USER_ID='".$userid."'";
			//echo $query;
			$result=mysql_query($query);
			 while($rowreg =  mysql_fetch_array($result))
		 	{	
		 		$USER_ID =   $rowreg['USER_ID'];
				$PASSWORD =  $rowreg['PASSWORD'];
                $salt =  $rowreg['salt'];
			}
		
			 $ranpwd= generatePassword(12, 1, 2, 3);
  
   			// Create a random salt
        	$random_salt = hash('sha512', $ranpwd);
 
        	// Create salted password 
       		 $passwd = hash('sha512', $npass . $random_salt);
        
         $sql_inser= "update user_master set  PASSWORD = '$passwd' , salt = '$random_salt', DATE_CREATED='$DDate'  where USER_ID = '$USER_ID'";
		 
			$resul_inser= mysql_query($sql_inser) or die('could not connect');
			if(!$resul_inser){ $variable .=  "Database error occured";}
			 	else{   $variable .= "<h3>Your Password Updation is Completed</h3>";  }
				
    return $variable;
}


 
 
function mainmenu($usercode,$usercat){
$menu = ' ';
$sql2 = "";

  if($usercat=="adm"){
		$sql2 = "SELECT `s_id`, `menu_name`, `menu_head`, `menu_url`, `orderlevel`,`c_date`, `c_user`, `status` FROM `menu_master` where status='A' and menu_head=0 order by menu_head, `orderlevel`";
  }else{
  
  if($usercat=="emp"){
 		 $sql11 = "select DISTINCT accept_screens from role_master where s_id = (select role_id from employee_master where emp_code in (SELECT `REFERENCE_CODE` FROM `user_master` where USER_CATG='emp' and  USER_ID='".$usercode."'))";  
  }elseif($usercat=="cuser"){
 		 $sql11 = "select DISTINCT accept_screens from role_master where s_id = (select role_id from employee_master where emp_code in (SELECT `REFERENCE_CODE` FROM `user_master` where USER_CATG='cuser' and  USER_ID='".$usercode."' ))";  
	}	 
		   echo $sql11;
  		$query11 = mysql_query($sql11) or die("Query failed --module emp");
	   	$menus="0";
			while ($row11 = mysql_fetch_array($query11))
			{
				$menus=$row11["accept_screens"];
			}
	
		$sql2 = "SELECT `s_id`, `menu_name`, `menu_head`, `menu_url`, `c_date`, `c_user`, `status` FROM `menu_master` where status='A' and  s_id in (select menu_head FROM `menu_master` where  s_id in (".$menus.") )   order by menu_head, orderlevel";
	 	 echo $sql2;
 }
 // echo $sql2;
  $querys  = mysql_query($sql2) or die("Query failed --3");
	 $aciv= ""; 
 
$menu .=  ' 
 	<ul  > ';	
			while ($rowf  = mysql_fetch_array($querys))
			{
			$whr ="";
if($usercat!="adm"){ $whr = "and s_id in (".$menus.")"; }
$sql  = "SELECT `s_id`, `menu_name`, `menu_head`, `menu_url`, `c_date`, `c_user`, `status`,  (select menu_name from menu_master where s_id=e.menu_head)module_name  FROM `menu_master` e   where menu_head='".$rowf["s_id"]."' ".$whr."  and status='A' order by orderlevel";	 
	 // echo $sql;
				 $query  = mysql_query($sql) or die("Query failed --1");
				 $j=0;
       		 
					
	 $menu .= '  <li  > <a href="#" >
                     <strong>'.retreplacesafe($rowf["menu_name"]).'</strong>
                    
                  </a> 
                  ';
                 while ($row  = mysql_fetch_array($query))
				{
			   			$menu .= '    <ul  > <li style="padding-left:10px;"><a href="'.$row["menu_url"]. '">'.retreplacesafe($row["menu_name"]). ' </a></li> </ul>';
				}									
                  $menu .= '   
                                           </li> ';
					}					   
				  $menu .= '     <li> <a href="changepassword.php" >  <strong>Change Password</strong></a>  </li>';
				
				$menu .= '     </ul>'; 

return $menu;
  
  
  $user_id = $_SESSION['USER_ID'];
         $login_string = $_SESSION['login_string'];
        $username = $_SESSION['USER_CATG'];
$menu = ' ';
   //echo '...'.$usercat;
  if($_SESSION['USER_CATG'] == 'emp')
  {
  $sqln = "SELECT `role_id` FROM `employee_master` where emp_name='$user_id'";
  //echo  $sqln;
   while ($rowr = mysql_fetch_array($sqln))
			{
				$role=$rowr["role_id"];
			}

	}
else
{

 $sqln = "SELECT `role_id` FROM `credit_customer_master` where credit_customer_name='$user_id'";
// echo  $sqln;
 while ($rowr = mysql_fetch_array($sqln))
			{
				$role=$rowr["role_id"];
			
			}
//echo '....'.'".$rowr['user_type_code']."';
       		}
 

 $query  = mysql_query($sqln) or die("Query failed -- role");
 $sql = "SELECT `user_type_code`, `user_type_name`, `status` FROM `user_type_master` where status='A' order by user_type_code";
	 
 $sqlr = "select DISTINCT accept_screens from role_master where s_id='1'";
echo $sqlr;
		 $queryr = mysql_query($sqlr) or die("Query failed --role");
       		while ($rowr = mysql_fetch_array($queryr))
			{
				$menus=$rowr["accept_screens"];
			}
			 
		 $query  = mysql_query($sql) or die("Query failed -- module");
		 	 
$menu .= '   <div class="sidebar-nav">  <ul> ';
	 $mhead="";
	$k=0;
			while ($row  = mysql_fetch_array($query))
			{
				 $sqlm  = "SELECT `s_id`, `menu_name`, `menu_head`, `menu_url`, `c_date`, `c_user`, `status`,  (select user_type_name from user_type_master where user_type_code=e.menu_head)module_name  FROM `menu_master` e   where   menu_head='".$row['user_type_code']."' and s_id in (".$menus.") and status='A' order by menu_head, menu_name";
				// echo  $sqlm;	 
				 $querym  = mysql_query($sqlm) or die("Query failed -- menu");
	  			$num=mysql_num_rows($querym);
				 
    		while ($rowm  = mysql_fetch_array($querym))
			{
				if(($num>0) && ($mhead!=$row["user_type_code"]))
				{ 
					$mhead=$row["user_type_code"]; 
					
				 $menu .= '  <li><a href="#" data-target=".'.$mhead.'" class="nav-header" data-toggle="collapse"><i class="fa fa-fw fa-dashboard"></i> '.$row["user_type_name"].' <i class="fa fa-collapse"></i></a></li>
	<li><ul class="'.$mhead.' nav nav-list collapse in"> ';
	$k=1;
				} // if
				
					$menu .= '    <li><a href="'.$rowm["menu_url"].'"><span class="fa fa-caret-right"></span> '.$rowm["menu_name"].'</a></li> ';
			} /// while
					if($k==1){ 	$menu .= '   </ul></li> ';  $k=0;}
	 
	 } // while
	  
  $menu .= ' </ul></div>  ';
  
		return $menu;
}


function headeruser_menu($usercode){
$hhmuser='';
$design_name = $emp_name ="";

 $qury = "SELECT *  from employee_master e where s_id=(select REFERENCE_CODE from user_master where user_id='".$usercode."')";
  $sqls= mysql_query($qury);
//	$res .=  $qury;
	  	$row = mysql_fetch_array($sqls);
		
		$emp_name = $row["emp_name"];
		 $arrSelected = explode(",", $row["photo"]);
		
 
$hhmuser .=' <div class="user-panel">
                        <div class="pull-left image">';
                        if($arrSelected[1]!=""){
				$hhmuser .='<img src="user_data/'.$arrSelected[1].'" id="'.$row["s_id"].'" height="40px" />';
		}else{ 		  $hhmuser .='   <img src="../img/shashi.jpg" class="img-circle" alt="User Image" />';  }
                 $hhmuser .='     </div>
                        <div class="pull-left info">
                            <p>Hello, '.$emp_name.'</p>

                           
							 <a href="../includes/logout.php" class="fa fa-circle text-success"> Sign out</a>
                        </div>
                    </div>';
		return $hhmuser;
}
function header_menu($usercode){
$emp_name ="";

 $qury = "SELECT * from employee_master e where s_id=(select REFERENCE_CODE from user_master where user_id='".$usercode."')";
  $sqls= mysql_query($qury);
//	$res .=  $qury;
	  	$row = mysql_fetch_array($sqls);
		$emp_name = $row["emp_name"];
		
		 $arrSelected = explode(",", $row["photo"]);
		

$hmenu = '';
$hmenu .='  <ul class="nav navbar-nav">
                         
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                             
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header bg-light-blue"> ';
                        if($arrSelected[1]!=""){
				$hmenu .='<img src="user_data/'.$arrSelected[1].'" id="'.$row["s_id"].'" height="40px" />';
		}else{ 		 $hmenu .='  <img src="../img/pt.jpg" class="img-circle" alt="User Image" />';  }
               
			                  $hmenu .='      <p>
                                       '.$emp_name.'   
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
                                   
                                    <div class="pull-right">
                                        <a href="../includes/logout.php" class="btn btn-default btn-flat">Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>';
					
return $hmenu;
}
  
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

function date_slashconvert_M_D_Y($date){
$ret="";
$pieces = explode("/", $date);
$ret=$pieces[2]."-".$pieces[0]."-".$pieces[1];
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
   
 
function upcommingnomineecourse($ttype) {
 $res='';
   $query= "SELECT `s_id`, `SCHEDULE_ID`, (select  count(traineename) count FROM `nominee` where course=s.COURSE_CODE and `course_dates`=s.s_id) count ,`SCHEDULE_YEAR`, `START_DATE`, `END_DATE`, `COURSE_CODE`,(select COURSE_NAME from course_master where s.COURSE_CODE=S_ID) COURSE_NAME, `COURSE_duration`, `STATUS_FLAG`, `TRAINEE_TYPE` FROM `schedule_master` s where START_DATE  >=CURDATE() and COURSE_CODE in (select s_id from course_master where COURSE_INTENDED in ('$ttype')) order by START_DATE limit 2 ";
$trname= $res_1 = "";
    $result=mysql_query($query); 
                  $total=0;
 		while ($rowm = mysql_fetch_array($result)) {
 			$res_1 .= "<p>".retrivefuns($rowm["COURSE_NAME"])."(".$rowm["count"].") </br>"; 
			$total = $total + $rowm["count"];
	 	}
		if($ttype=="1") { $trname = "Supervisors"; }
		if($ttype=="9") { $trname = "Compters"; }
		if($ttype=="10") { $trname = "Officers"; }
		  $res .='<h4> <strong>'.$trname.' ('.$total.' Nominee)</strong> </h4>';
   $res .=$res_1;
   return  $res;
} 
      