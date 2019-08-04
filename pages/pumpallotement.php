<?php 
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';
include_once 'function/pumpallotementfunction.php';
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
		     $del_qry = "DELETE FROM daily_pump_allotment WHERE trim(s_id)=trim('".$icode."')";
			 $result = mysql_query($del_qry);
	  	} 
	 
	 
	if((!empty($edm)) && ($edm=="edit")){   
	  $select_query =  "SELECT `s_id`,`emp_code`,`shift_code`,`allotment_date`,DATE_FORMAT(allotment_date,'%d/%m/%Y %H:%m:%s') as date,allotment_pumps,`user_id`,`c_date`,`status` FROM `daily_pump_allotment` WHERE  s_id='".$icode."'";
	  $resultk = mysql_query($select_query);
	//echo $select_query;
    	while ($rowk = mysql_fetch_array($resultk)) {
			if($rowk["status"]=="A") $status1="selected";
			if($rowk["status"]=="I") $status2="selected";
			$psno = $rowk["s_id"];
			$empname = $rowk["emp_code"]; 
			$scode = $rowk["shift_code"];
					$cbox = $rowk["allotment_pumps"]; 
				$pdate = $rowk["date"]; 
					  //echo ';;;;;'.$pdate;
					
    	}
	}
	}
 ?>
 <!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="datepickertime/jquery.datetimepicker.css" /> 
</head>
 <body>
 
 	<!-- about-heading -->
	<div class="about-heading">
		<h2>DAILY PUMP <span>ALLOTEMENT </span></h2>
	</div>
	<!-- //about-heading -->
    
     <!-- choose -->
	<div class="choose jarallax">
  
		<div class="w3-agile-page">
			<div class="container">
              <div class="header">
              	<ul class="breadcrumb">
                	<li><a href="home.php">Home</a> </li>
                	<li class="active">Pump Daily Allotment </li>
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
                             <form  name="cform" method="post" action="pumpallotement.php">
                                    
                                      <div class="col-sm-3 textalign labelalign">  EMPLOYEE NAME 
                                            <select class="form-control"  name="empname" id="empname">
                                             <option value="">--Select--</option>
                	  <?php 
				$sqlquery2 = "select `emp_code`, `emp_name` from `employee_master` where status='A'";
	        $queryresult2 = mysql_query($sqlquery2) or die("Query failed --1");
  			 
								while ($row2 = mysql_fetch_array($queryresult2))
  								{
									if($empname==$row2["emp_code"]) $dselval="selected";
									else  $dselval=" ";
									echo  "<option value='".$row2["emp_code"]."' $dselval >".$row2["emp_name"]."</option>" ;
								} 
								?>
                                </select value=" ><?php echo $cname; ?>" />
								<input type="hidden"   name="sid" id="sid" value="<?php echo $psno; ?>" />
                                           </div>
                                         <div class="col-sm-3 textalign labelalign">  SHIFT CODE 
                                            <select class="form-control"  name="scode" id="scode">
                                             <option value="">--Select--</option>
                	  <?php 
				$sqlquery2 = "select `shift_code`,  shift_name from `shift_master` where status='A'";
				
	        $queryresult2 = mysql_query($sqlquery2) or die("Query failed --1");
  			 
								while ($row2 = mysql_fetch_array($queryresult2))
  								{
									if($scode==$row2["shift_code"]) $dselval="selected";
									else  $dselval=" ";
									echo  "<option value='".$row2["shift_code"]."' $dselval >".$row2["shift_name"]."</option>" ;
								} 
								?>
                                </select>  
								
                                           </div>
                                         
             <div class="col-sm-12 textalign labelalign">  Pump List </br>
                                          <?php echo $sd =  menulist($cbox); ?> <br> </div>
                                           <div class="col-sm-3 textalign labelalign">  ALLOTEMENT DATE  
                                           <input type="text" class="form-control"  name="pdate" id="pdate" placeholder="DD/MM/YYYY" maxlength="10" onBlur="return  ValidateForm()"  value="<?php echo $pdate; ?>" /></div>
										   
                                          <div class="col-sm-3 textalign labelalign">  STATUS 
                                           <select class="form-control"  name="status" id="status">
                                                <option value="A" <?php echo $status1; ?>>Active</option>
                                                <option value="I" <?php echo $status2; ?>>InActive</option>
                                               </select> 
                                        </div>
                                          <br /><br />
<br />

                                          <div class="col-sm-12" align="center"> 
                                   <button class="btn1" type="submit">Submit</button>
                                    <button type="reset" class="btn1" >clear</button>
                                  </div>
                                </form>
                
						</div>
                       
   <?php 
if (isset($_POST['empname'])) {
    
     $empname =   make_safe($_POST['empname']);
	 $scode =   make_safe($_POST['scode']);
	 $pdate =   $_POST['pdate'];
	  $datem=(explode(" ",$pdate ));
	   $msdate=implode(array_reverse(explode("/",$datem[0])),"-");
	   $pdate=$msdate." ".$datem[1];
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
  	if ($empname!="" && $cbox!="") {

		//if(pumpallote($empname,$scode,$cbox,$pdate,$status)){
		
				echo $mpass = pumpallotementmaster($sid,$empname,$scode,$cbox,$pdate,$userid,$cdate,$status);
		 	//header("location:pumpallotement.php");
			//}
			//else{ echo 'This employee Name already exits'; } 
 	} else {
    	// The correct POST variables were not sent to this page. 
    	echo 'Please enter the employee Name And Select any one check Box';
	}
} 
?>               
                   <br />
                         <div class="col-sm-12">
        <div class="panel panel-default">
        
			<div class="panel-body ">    <?php echo $sd = pumpallgrid(); ?>      </div>
               </div></div>
					</div>
					<div class="clearfix"> </div>
				</div>
                
			</div>
         
	</div>
	<!-- //choose -->
 
   
 </body>
<script src="datepickertime/jquery.js"></script>
<script src="datepickertime/jquery.datetimepicker.full.js"></script>
<script type = "text/javascript">

$.datetimepicker.setLocale('en');
$('#pdate').datetimepicker({
dayOfWeekStart : 1,
lang:'en', 
startDate:	'1986/01/05'
});
$('#pdate').datetimepicker({ step:1});


</script>
 <?php require_once("footer.php"); ?>
 </html>