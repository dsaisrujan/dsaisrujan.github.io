<?php 
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';
include_once 'function/vehiclefunction.php';
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
$del_qry = "DELETE FROM creditcustomer_vechicle_master WHERE trim(cc_s_id)=trim('".$icode."')";
$result = mysql_query($del_qry);
} 

if((!empty($edm)) && ($edm=="edit")){   
$select_query =  "SELECT `cc_s_id`, `CREDIT_CUSTOMER_ID`, `cc_vehicle_no`, `cc_vehicle_model`,`cc_start_date`, , `user_id`, `status` FROM `creditcustomer_vechicle_master` WHERE  cc_s_id='".$icode."'";
$resultk = mysql_query($select_query);
//echo  $select_query ;
while ($rowk = mysql_fetch_array($resultk)) {
	if($rowk["status"]=="A") $status1="selected";
	if($rowk["status"]=="I") $status2="selected";
			
	$psno = $rowk["cc_s_id"]; 
	$cci = $rowk["CREDIT_CUSTOMER_ID"]; 
	$vno = $rowk["cc_vehicle_no"]; 
	$vmodal = $rowk["cc_vehicle_model"]; 
	$userid = $rowk["user_id"]; 
	//$strdte = $rowk["date"]; 
			
}
}
}
?>
 
<!DOCTYPE html>
<html>
<head> 
<!-- <link rel="stylesheet" type="text/css" href="backdate/datepickertime/jquery.datetimepicker.css"/>
 <script src="backdate/datepickertime/jquery.js"></script>
<script src="backdate/datepickertime/jquery.datetimepicker.full.js"></script>
 
 
 
<link rel="stylesheet" href="pages/jquery/css/smoothness/jquery-ui-1.8.2.custom.css" /> 
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css">
<script type = "text/javascript">
$(document).ready(function () {
    $("#strdte").datepicker({ dateFormat: 'dd/mm/yy', changeYear: true});
	 });
	$('#strdte').datetimepicker({dateFormat: 'dd/mm/yy',step:1});

$.datetimepicker.setLocale('en');
 
$('#strdte').datetimepicker({
dayOfWeekStart : 1,
lang:'en' 
});

$('#strdte').datetimepicker({value:'2015/04/15 05:03',step:1});
//alert ("hai");
$('.some_class').datetimepicker();-->

</script>  
</head>
<body>
<!-- about-heading -->
<div class="about-heading">
	<h2>VEHICLE  <span>MASTER</span></h2>
</div>
<!-- //about-heading -->
<!-- choose -->
<div class="choose jarallax">
	<div class="w3-agile-page">
		<div class="container">
            <div class="header">
              	<ul class="breadcrumb">
                	<li><a href="home.php">Home</a> </li>
                	<li class="active">Vehicle Master</li>
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
    <form  name="cform" method="post" action="vehiclemaster.php"  >
        <div class="col-sm-3 textalign labelalign">  CUSTOMER NAME
            <select class="form-control"  name="cci" id="cci">
            <option>--Select--</option>
            <?php 
			$sqlquery2 = "select `credit_customer_code`, `credit_customer_name` from `credit_customer_master`";
	        $queryresult2 = mysql_query($sqlquery2) or die("Query failed --1");
				while ($row2 = mysql_fetch_array($queryresult2))
  					{
						if($cci==$row2["credit_customer_code"]) $dselval="selected";
						else  $dselval=" ";
						echo  "<option value='".$row2["credit_customer_code"]."' $dselval >".$row2["credit_customer_name"]."</option>" ;
					} 
			?></select>
			<input type="hidden"   name="sid" id="sid" value="<?php echo $psno; ?>" />
        </div>
        <div class="col-sm-3 textalign labelalign">  VEHICLE NUMBER 
			<input type="text" class="form-control"  name="vno" id="vno" placeholder="VEHICLE NUMBER" maxlength="50"  onkeypress="return pfNumberKey(event)"  value="<?php echo $vno; ?>" /> 
		</div>
        <div class="col-sm-3 textalign labelalign">  VEHICLE MODEL
            <input type="text" class="form-control"  name="vmodal" id="vmodal" placeholder="VEHICLE MODEL" maxlength="50"  onkeypress="return pfNumberKey(event)"  value="<?php echo $vmodal; ?>" />    
		</div>
        <!--<div class="col-sm-3 textalign labelalign"> START DATE 
            <input type="text" class="form-control"  name="strdte"  id="strdte"  placeholder="DD/MM/YYYY" maxlength="10"  onBlur="return ValidateForm()"   value="<?php// echo $strdte; ?>" />   
		</div>-->
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
if (isset($_POST['vmodal'])) {  
	$cci    =  make_safe($_POST['cci']);
    $vno    =  make_safe($_POST['vno']);
	$vmodal =  make_safe($_POST['vmodal']);
    /*$strdte =  make_safe($_POST['strdte']);
	$datee=(explode("^",$strdte));
	$strdte=$datee[2]."-".$datee[1]."-".$datee[0];*/
    $sid    =  make_safe($_POST['sid']);
    $userid =  htmlentities($_SESSION['USER_ID']); 
	$status =   make_safe($_POST['status']);
// echo $cci;
 	if ( $vno!="" && $vmodal!="" ) {
	if(vehiclename($vno,$vmodal,$vdname,$status)){
		echo $mpass = vehiclemaster($sid,$cci,$vno,$vmodal,$userid,$strdte,$status);
			header("location:vehiclemaster.php");
			} 
		else{ echo 'This User already exits'; } 
 	} else {
// The correct POST variables were not sent to this page. 
    echo 'Please enter all the mandatory fields';
	}
} 
?>                  
<br />
    <div class="col-sm-12">
        <div class="panel panel-default">
			
                <div class="panel-body "><?php echo $sd = vehiclegrid(); ?></div>
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