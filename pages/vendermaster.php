 <?php 
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';
include_once 'function/venderfunction.php';
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
 $psno = $vname= $status1= $status2="";
	
	 if($icode!=""){
	   if((!empty($edm)) && ($edm=="del")){   
		     $del_qry = "DELETE FROM vender_master WHERE trim(s_id)=trim('".$icode."')";
			 //echo $del_qry;
			 $result = mysql_query($del_qry);
	  	} 
	 
	 
	if((!empty($edm)) && ($edm=="edit")){ 

$select_query ="SELECT `s_id`, `vender_name`, `vender_address`, `contact_no`, `email_id`, `contact_person_name`, `c_date`, `c_user`, `status` FROM `vender_master` WHERE  s_id='".$icode."'";
	  //echo $select_query;
	  $resultk = mysql_query($select_query);
    	while ($rowk = mysql_fetch_array($resultk)) {
			if($rowk["Status"]=="A") $status1="selected";
			if($rowk["Status"]=="I") $status2="selected";
			$psno = $rowk["s_id"];
			$vname = $rowk["vender_name"]; 
			$venderadd = $rowk["vender_address"];
			$contactno = $rowk["contact_no"];
			$email = $rowk["email_id"];
			$cpname = $rowk["contact_person_name"];
			
			
    	}
	}
	}
	
 
 ?>
 <!DOCTYPE html>
<html>

<body>
<!-- about-heading -->
	<div class="about-heading">
		<h2>VENDER  <span>MASTER</span></h2>
	</div>
<!-- //about-heading -->
<!-- choose -->
<div class="choose jarallax">
	<div class="w3-agile-page">
		<div class="container">
            <div class="header">
              	<ul class="breadcrumb">
                	<li><a href="home.php">Home</a> </li>
                	<li class="active">Vender Master</li>
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
    <form  name="cform" method="post" action="vendermaster.php" >
       
            
       
		<div class="col-sm-3 textalign labelalign">  VENDER NAME
			<input type="text" class="form-control"  name="vname" id="vname" placeholder="Vender Name" maxlength="100"  onkeypress="return checkNum(event)"  value="<?php echo $vname; ?>" required/><input type="hidden" class="form-control"  name="sid" id="sid"  value="<?php echo $psno; ?>" />
			
		</div>
        <div class="col-sm-3 textalign labelalign">  VENDER ADDRESS
			<input type="text" class="form-control"  name="venderadd" id="venderadd" placeholder="Vender Address" maxlength="100"  onkeypress="return checkNum(event)"  value="<?php echo $venderadd; ?>" required/>
		</div>
		
		<div class="col-sm-3 textalign labelalign">  CONTACT NUMBER
			<input type="text" class="form-control"  name="contactno" id="contactno"  placeholder="Contact Number" maxlength="25"     value="<?php echo $contactno; ?>" />            
		</div>
        <div class="col-sm-3 textalign labelalign">  EMAIL ID
			<input type="text" class="form-control"  name="email" id="email"  placeholder="Email Id" maxlength="25"     value="<?php echo $email; ?>" />            
		</div>
        <div class="col-sm-3 textalign labelalign">  CONTACT PERSON NAME
			<input type="text" class="form-control"  name="cpname" id="cpname"  placeholder="Contact Person Name" maxlength="25"     value="<?php echo $cpname; ?>" />            
		</div>
        
        <div class="col-sm-3 textalign labelalign">  STATUS
			<select class="form-control"  name="status" id="status">
			<option value="A" <?php echo $status1; ?>>Active</option>
			<option value="I" <?php echo $status2; ?>>InActive</option>
			</select> 
        </div>
		
		
            <br /><br /><br />
		<div class="col-sm-12" align="center"> 
            <button class="btn1" type="submit" id="submit">Submit</button>
            <button type="reset" class="btn1" >clear</button>
        </div>
    </form>
	</div>
					
 <?php
if(isset($_POST['vname'])) {
	$sid   =   make_safe($_POST['sid']);
	$vname =   make_safe($_POST['vname']);
	$venderadd   =   make_safe($_POST['venderadd']);
	$contactno =   make_safe($_POST['contactno']);
	$email =   make_safe($_POST['email']);
	$cpname =   make_safe($_POST['cpname']);
	$status   =   make_safe($_POST['status']);
	$userid =  htmlentities($_SESSION['c_user']);
   //$sid =  make_safe($_POST['sid']);
 	if ($vname!="" && $venderadd!="") {
	  if(vendername($vname,$venderadd,$contactno,$email,$cpname,$status) ){
			echo $mpass=vendermaster($sid,$vname,$venderadd,$contactno,$email,$cpname,$cdate,$userid,$status);
				//header("location:productmaster.php");
			}
			else{ echo 'This id Name already exits'; }
 	} else {
    	// The correct POST variables were not sent to this page. 
    	echo 'Please enter the fields';
	}
}
 
?>					
					
                    <br />
    <div class="col-sm-12">
        <div class="panel panel-default">
       
            <div class="panel-body ">      <?php echo $sd = vendergrid(); ?>     </div>
            </div></div>
			</div>
				<div class="clearfix"> </div>
			</div>
            </div>
        </div>
	<!-- //choose -->
 
    
 </body>
 
<?php require_once("footer.php"); ?>
</html>