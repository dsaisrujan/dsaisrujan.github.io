 <?php 
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';
include_once 'function/tankmasterfunction.php';
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
		     $del_qry = "DELETE FROM tank_master WHERE trim(tank_id)=trim('".$icode."')";
			 //echo $del_qry;
			 $result = mysql_query($del_qry);
	  	} 
	 
	 
	if((!empty($edm)) && ($edm=="edit")){   
	  $select_query ="SELECT `tank_id`, `tank_name`, `oil_type`, `calibration_id`, `tank_created_user_id`, `tank_created_date`, `status` FROM `tank_master` WHERE  tank_id='".$icode."'";
	 //echo $select_query;
	  $resultk = mysql_query($select_query);
    	while ($rowk = mysql_fetch_array($resultk)) {
			if($rowk["Status"]=="A") $status1="selected";
			if($rowk["Status"]=="I") $status2="selected";
			if($rowk["oil_type"]=="P") $otype1="selected";
			if($rowk["oil_type"]=="D") $otype2="selected";
			$psno = $rowk["tank_id"];
			$cname = $rowk["tank_name"]; 
			$calbr = $rowk["calibration_id"];
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

<script>
  function calbrmenu(mvalue)
{
	str = document.getElementById("otype").value;

//alert(str);
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  	xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
	xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    	document.getElementById("calbrs").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","calbrsajax.php?otype="+str,true);
xmlhttp.send();
}
</script>

  
</head>
<body>
<!-- about-heading -->
	<div class="about-heading">
		<h2>TANK  <span>MASTER</span></h2>
	</div>
<!-- //about-heading -->
<!-- choose -->
<div class="choose jarallax">
	<div class="w3-agile-page">
		<div class="container">
            <div class="header">
              	<ul class="breadcrumb">
                	<li><a href="home.php">Home</a> </li>
                	<li class="active">Tank Master</li>
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
    <form  name="cform" method="post" action="tankmaster.php" >
       
            
       
		<div class="col-sm-3 textalign labelalign">  TANK NAME
			<input type="text" class="form-control"  name="tankname" id="tankname" placeholder="Tank Name" maxlength="100"  onkeypress="return checkNum(event)"  value="<?php echo $cname; ?>" required/><input type="hidden" class="form-control"  name="tankid" id="tankid"  value="<?php echo $psno; ?>" />
			
		</div>
		<!--<div class="col-sm-3 textalign labelalign">  OIL TYPE
			<select class="form-control" name="otype" id="otype" onchange="calbrmenu(this.value)" required>
				<option value="">-- Select --</option>
				<option value="P" <?php //echo $otype1; ?> >Petrol</option>
				<option value="D" <?php //echo $otype2; ?> >Disel</option>
				</select>
		</div>-->
		
		<div class="col-sm-3 textalign labelalign"> OIL TYPE
                         <select class="form-control"  name="otype" id="otype" onchange="calbrmenu(this.value)" required>
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
		
		 <div class="col-sm-3 textalign labelalign" >  CALIBRATION(Dia,Len,Cap)
		 
            <span id="calbrs"><select class="form-control"  name="calbr" id="calbr">
            <option>--Select--</option>
            <?php 
			$sqlquery2 = "SELECT `s_id`, `tank_diameter`, `tank_length`, `capacity` FROM `calibration_master` WHERE `oil_type`='".$otype."' and `status`='A'";
			//echo $sqlquery2;
	        $queryresult2 = mysql_query($sqlquery2) or die("Query failed --1");
				while ($row2 = mysql_fetch_array($queryresult2))
  					{
						if($calbr==$row2["s_id"]) $dselval="selected";
						else  $dselval=" ";
						echo  "<option value='".$row2["s_id"]."' $dselval >(DIA)".$row2["tank_diameter"].",(LEN)".$row2["tank_length"].",(CAP)".$row2["capacity"]."</option>" ;
					} 
			?></select></span>
			
        </div>
		
        <!--<div class="col-sm-3 textalign labelalign"> TANK DIAMETER
			<input type="text" class="form-control"  name="tdiameter" id="tdiameter" placeholder="Diameter" maxlength="100"  onkeypress="return checkNum(event)"  value="<?php //echo $tdiameter; ?>" required/>
		</div>
		<div class="col-sm-3 textalign labelalign">  TANK LENGTH
			<input type="text" class="form-control"  name="tlength" id="tlength" placeholder="Tank Length" maxlength="100"  onkeypress="return checkNum(event)"  value="<?php //echo $tlength; ?>" required/>
		</div>
		
		
		<div class="col-sm-3 textalign labelalign">  CAPACITY(Litres)
			<input type="text" class="form-control"  name="capacity" id="capacity" placeholder="Capacity" maxlength="100"  onkeypress="return checkNum(event)"  value="<?php //echo $capacity; ?>" required/>
		</div>-->
		
		
        <!--<div class="col-sm-3 textalign labelalign">   Date
			<input type="text" class="form-control"  name="cdate" id="cdate"  placeholder="DD/MM/YYYY" maxlength="10"  onBlur="return ValidateForm()"   value="<?php // echo $cdate; ?>" required/>            
		</div>-->
		
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
if(isset($_POST['tankname'])) {
	$tankid   =   make_safe($_POST['tankid']);
	$tankname =   make_safe($_POST['tankname']);
	//echo $tankname;
	$calbr   =   make_safe($_POST['calbr']);
	$otype =   make_safe($_POST['otype']);
	
	//$user     =   make_safe($_POST['user']);
	/*$cdate 	  =   make_safe($_POST['cdate']);
	$datee=(explode("^",$cdate));
	$cdate=$datee[2]."-".$datee[1]."-".$datee[0];*/
	$status   =   make_safe($_POST['status']);
	$userid =  htmlentities($_SESSION['USER_ID']);
   //$sid =  make_safe($_POST['sid']);
 	if ($tankname!=""  && $otype!="" && $calbr!="") {
	  //if(tankidname($tankid,$tankname,$otype,$calbr,$status) ){
			echo $mpass=tankidmaster($tankid,$tankname,$otype,$calbr,$userid,$cdate,$status);
				header("location:tankmaster.php");
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
       
            <div class="panel-body ">      <?php echo $sd = tankidgrid(); ?>     </div>
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