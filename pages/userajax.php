<?php
ob_start();
include_once '../includes/db_connect.php';

if(isset($_GET["user"]))
{
	$user=$_GET['user'];
	 	$output = preg_replace('/[^a-zA-Z0-9]/s', '', $user);
	
	  $sqlquery2 = "SELECT `USER_ID` FROM `user_master` WHERE `USER_ID`='".$output."'";
//echo $sqlquery2;
	  $result = mysql_query($sqlquery2) or die("Query failed -----1");
  	  $num=mysql_numrows($result);
	 if ($num > 0) {
	 
	   echo $res='<strong style="color:#FF0000">This user already Exists</strong> ';  
	  
                              ?>  <input type="text" class="form-control"  name="user" id="user" placeholder="Employee user" maxlength="50"  onkeypress="return checkNum(event)"   onblur="getTimeemp(this.value);" />  
										   <?php 
										   
	
	 } else {
		?>   User Id :<input type="text" class="form-control"  name="user" id="user" placeholder="Employee user" maxlength="50"  onkeypress="return checkNum(event)" value="<?php echo $output; ?>"  onblur="getTimeemp(this.value);" />
	<?php }
	 
} 
?>