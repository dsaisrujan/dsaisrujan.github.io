 <?php 
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';
include_once 'function/calimasterfunction.php';
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
 $psno = $status1= $status2="";
	
	 if($icode!=""){
	   if((!empty($edm)) && ($edm=="del")){   
		     $del_qry = "DELETE FROM calibration_master WHERE trim(s_id)=trim('".$icode."')";
			 //echo $del_qry;
			 $result = mysql_query($del_qry);
	  	} 
	 
	 
	if((!empty($edm)) && ($edm=="edit")){   
	  $select_query ="SELECT `s_id`, `tank_diameter`, `tank_length`, `capacity`, `oil_type`, `c_user`, `c_date`, `status` FROM `calibration_master`  WHERE  s_id='".$icode."'";
	  //echo $select_query;
	  $resultk = mysql_query($select_query);
    	while ($rowk = mysql_fetch_array($resultk)) {
			if($rowk["Status"]=="A") $status1="selected";
			if($rowk["Status"]=="I") $status2="selected";
			/*if($rowk["oil_type"]=="P") $otype1="selected";
			if($rowk["oil_type"]=="D") $otype2="selected";*/
			
			$psno = $rowk["s_id"];
			 $tdiameter = $rowk["tank_diameter"];
			
			$tlength = $rowk["tank_length"];
			$capacity = $rowk["capacity"];
			$otype = $rowk["oil_type"];
			//$userid = $rowk["tank_created_user_id"];
			//$cdate = $rowk["date"]; 
    	}
	}
	}
	
 
 ?>
 <!DOCTYPE html>
<html>
<head> 
<link rel="stylesheet" href="pages/jquery/css/smoothness/jquery-ui-1.8.2.custom.css" /> 
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css">
<script type = "text/javascript">
$(document).ready(function () {
	$("#cdate").datepicker({ dateFormat: 'dd/mm/yy', changeYear: true});
});
</script>  
</head>
<body>
<!-- about-heading -->
	<div class="about-heading">
		<h2>CALIBRATION  <span>MASTER</span></h2>
	</div>
<!-- //about-heading -->
<!-- choose -->
<div class="choose jarallax">
	<div class="w3-agile-page">
		<div class="container">
            <div class="header">
              	<ul class="breadcrumb">
                	<li><a href="home.php">Home</a> </li>
                	<li class="active">Calibration Master</li>
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
    <form  name="cform" method="post" action="calibrationmaster.php" >
       
            
       
		<!--<div class="col-sm-3 textalign labelalign">  OIL TYPE
			<select class="form-control" name="otype" id="otype" required>
				<option value="">-- Select --</option>
				<option value="P" <?php // echo $otype1; ?> >Petrol</option>
				<option value="D" <?php // echo $otype2; ?> >Disel</option>
				</select>
		</div>-->
		
		<div class="col-sm-3 textalign labelalign"> OIL TYPE
                         <select class="form-control"  name="otype" id="otype" required>
                                          <option>--Select--</option>
                                               	  <?php 
				$sqlquery2 = "SELECT `s_id`,`produt_name` FROM `product_master` WHERE `order_level`='0'";
				
	        $queryresult2 = mysql_query($sqlquery2) or die("Query failed --1");
  			 
								while ($row2 = mysql_fetch_array($queryresult2))
  								{
									if($otype==$row2["s_id"]) $dselval="selected";
									else  $dselval=" ";
									echo  "<option value='".$row2["s_id"]."' $dselval >".$row2["produt_name"]."</option>" ;
								} 
								?></select>  
                                          </div>
		
		
		<div class="col-sm-3 textalign labelalign"> TANK DIAMETER
			<input type="text" class="form-control"  name="tdiameter" id="tdiameter" placeholder="Diameter" maxlength="100"  onkeypress="return checkNum(event)"  value="<?php echo $tdiameter; ?>" required/>
			<input type="hidden" class="form-control"  name="sid" id="sid"  value="<?php echo $psno; ?>" />
		</div>
		<div class="col-sm-3 textalign labelalign">  TANK LENGTH
			<input type="text" class="form-control"  name="tlength" id="tlength" placeholder="Tank Length" maxlength="100"  onkeypress="return checkNum(event)"  value="<?php echo $tlength; ?>" required/>
		</div>
		
		
		<div class="col-sm-3 textalign labelalign">  CAPACITY(Litres)
			<input type="text" class="form-control"  name="capacity" id="capacity" placeholder="Capacity" maxlength="100"  onkeypress="return checkNum(event)"  value="<?php echo $capacity; ?>" required/>
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
if(isset($_POST['tdiameter'])) {
	
	$tdiameter   =   make_safe($_POST['tdiameter']);
	
	$tlength =   make_safe($_POST['tlength']);
	$capacity =   make_safe($_POST['capacity']);
	$otype =   make_safe($_POST['otype']);
	$status   =   make_safe($_POST['status']);
	$userid =  htmlentities($_SESSION['USER_ID']);
  $sid =  make_safe($_POST['sid']);
 	if ($tdiameter!="" && $tlength!="" && $capacity!="" && $otype!="") {
	  //if(calibrationidname($tdiameter,$tlength,$capacity,$otype,$status) ){
			echo $mpass=calibrationidmaster($sid,$tdiameter,$tlength,$capacity,$otype,$userid,$cdate,$status);
				header("location:calibrationmaster.php");
		/*}
			else{ echo 'This id Name already exits'; } */
 	} else {
    	// The correct POST variables were not sent to this page. 
    	echo 'Please enter the id Name';
	}
} 
?>					
					
                    <br />
    <div class="col-sm-12">
        <div class="panel panel-default">
       
            <div class="panel-body ">      <?php echo $sd = calibrationidgrid(); ?>     </div>
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