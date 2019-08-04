 <?php 
 include_once '../includes/db_connect.php';
include_once '../includes/functions.php';
include_once 'function/rolefunction.php';
 require_once("header.php");
 
 sec_session_start();

if (login_check() == true) {
    $logged = 'in';
} else {
    $logged = 'out'; header("Location:../includes/logout.php");
}
 
$icode=$edm="";
if(!empty($_GET["icode"])){  $icode = $_GET["icode"];  }
if(!empty($_GET["edm"])){  $edm = $_GET["edm"];  }
 $psno = $cname= $status1= $status2="";
	
	 if($icode!=""){
	   if((!empty($edm)) && ($edm=="del")){   
		     $del_qry = "DELETE FROM role_master WHERE trim(s_id)=trim('".$icode."')";
			 $result = mysql_query($del_qry);
	  	} 
	 
	 
	if((!empty($edm)) && ($edm=="edit")){   
	  $select_query =  "SELECT `s_id`, `role_name`,accept_screens,permission,`c_date`, `c_user`, `status` FROM `role_master`  WHERE  s_id='".$icode."'";
	  $resultk = mysql_query($select_query);
	//echo $select_query;
    	while ($rowk = mysql_fetch_array($resultk)) {
			if($rowk["status"]=="A") $status1="selected";
			if($rowk["status"]=="I") $status2="selected";
			$psno = $rowk["s_id"];
			$cname = $rowk["role_name"]; 
					$cbox = $rowk["accept_screens"]; 
							$permission = $rowk["permission"]; 
					  
					
    	}
	}
	}
 
 ?>
 
 	<!-- about-heading -->
<div class="about-heading">
	<h2>ROLE  <span>MASTER</span></h2>
</div>
<!-- //about-heading -->
<!-- choose -->
<div class="choose jarallax">
	<div class="w3-agile-page">
		<div class="container">
            <div class="header">
              	<ul class="breadcrumb">
                	<li><a href="home.php">Home</a> </li>
                	<li class="active">Role Master</li>
            	</ul>
        	</div> 
		 		<div class="col-md-3">
					<div class="top-choose-page">
						<div class="choose-info-top">
							<div class="choose-left-grid col-sm-12">
								<div class="choose-page-grid ">
									<?php  include_once("leftmenus.php");?>
								</div>
							</div>
								<div class="clearfix"> </div>
						</div>
					</div>
				</div>
					<div class="col-md-9 choose-grid1">
					 	<div class="agileinfo-contact-form-grid">
<!-- form start -->
    <form  name="cform" method="post" action="rolemaster.php" >
        <div class="col-sm-3 textalign labelalign">  ROLE NAME
            <input type="text" class="form-control"  name="rname" id="rname" placeholder="Role Name" maxlength="100"  onkeypress="return pfNumberKey(event)"  value="<?php echo $cname; ?>" />
			<input type="hidden"   name="sid" id="sid" value="<?php echo $psno; ?>" />
        </div>
        <div class="col-sm-12 textalign labelalign">  MENU LIST
            <?php echo $sd =  menulist($cbox); ?>    Permissions <input type="checkbox" name="permission"<?php if($permission=="P"){echo "checked";} ?>  value="P" /> (For All Privileges)
		</div>
        <div class="col-sm-3 textalign labelalign">  STATUS 
            <select class="form-control"  name="status" id="status">
            <option value="A" <?php echo $status1; ?>>Active</option>
            <option value="I" <?php echo $status2; ?>>InActive</option>
        </select> 
        </div>
             <br /><br /><br />
		<div class="col-sm-12" align="center"> 
            <button class="btn1" type="submit">Submit</button>
            <button type="reset" class="btn1" >clear</button>
        </div>
    </form>
</div>
<?php 
if (isset($_POST['rname'])) {
$rname =   make_safe($_POST['rname']);
$permission = make_safe($_POST['permission']);
$cbox = $_POST['cbox'];   
$access_menu_id ="";
	for($i=0; $i<sizeof($cbox); $i++)
		{
			$access_menu_id .= $cbox[$i];
			if (($i+1) < sizeof($cbox))  $access_menu_id .= "-";
		}
$cbox=$access_menu_id;
$status =   make_safe($_POST['status']);
$userid =  htmlentities($_SESSION['USER_ID']);  
$sid =  make_safe($_POST['sid']);
if ($rname!="" && $cbox!="") {
	if(rolename($rname,$cbox,$permission,$status)){
		echo $mpass = rolemaster($sid,$rname,$cbox,$permission,$userid,$status);
		 	header("location:rolemaster.php");
			}
			else{ echo 'This Role Name already exits'; } 
 	} else {
    	// The correct POST variables were not sent to this page. 
    	echo 'Please enter the Role Name And Select any one check Box';
	}
} 
?>
                   <br />
    <div class="col-sm-12">
        <div class="panel panel-default">
			
			<div class="panel-body "><?php echo $sd =rolegrid(); ?></div>
               </div></div>
					</div>
					<div class="clearfix"> </div>
				</div>
              </div>
        </div>
	<!-- //choose -->
 <?php require_once("footer.php"); ?>
 </body>
 </html>