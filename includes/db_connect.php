 
<?php 
$dbhost = "localhost";
	$dbuser = "pumpuser";
	$dbpwd = "pumpuser1234$";
	
	$conn = mysql_connect($dbhost, $dbuser, $dbpwd);
if(!$conn)
{
	die('Could not connect' . mysql_error());
}
mysql_select_db("pump");

//mysql_select_db("ctara_camp");

define("CAN_REGISTER", "any");
define("DEFAULT_ROLE", "member");
 
define("SECURE", FALSE);    // FOR DEVELOPMENT ONLY!!!!
   error_reporting(0);  
   ini_set('display_errors', 0); // change to 0 for production version
error_reporting(E_ALL);

?>