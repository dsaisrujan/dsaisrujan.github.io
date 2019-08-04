 <?php 
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';
include_once 'function/pumptransefunction.php';
 require_once("header.php");
 
 sec_session_start();

if (login_check() == true) {
    $logged = 'in';
} else {
    $logged = 'out'; header("Location:../includes/logout.php");
}
 
$icode=$edm=$add1=$add2=$cno=$eid=	$iptc=$ipsic=$idm1=$idm2="";
if(!empty($_GET["icode"])){  $icode = $_GET["icode"];  }
if(!empty($_GET["edm"])){  $edm = $_GET["edm"];  }
 $psno = $cname= $status1= $status2="";
	
	 if($icode!=""){
	   if((!empty($edm)) && ($edm=="del")){   
		     $del_qry = "DELETE FROM pump_trans WHERE trim(s_id)=trim('".$icode."')";
			 $result = mysql_query($del_qry);
	  	} 
	 
	 
	if((!empty($edm)) && ($edm=="edit")){   
	
	
	  $select_query =  "SELECT `s_id`, `pump_id`, `pump_reading`,  `pump_date`,DATE_FORMAT(pump_date,'%d/%m/%Y %H:%m:%s') as pump_date1, `user_id`,`c_date`,`status`  FROM `pump_trans` WHERE  s_id='".$icode."'";
	  //echo $select_query;
	  $resultk = mysql_query($select_query);
	
	while ($rowk = mysql_fetch_array($resultk)) {
			if($rowk["status"]=="A") $status1="selected";
			if($rowk["status"]=="I") $status2="selected";
			$psno = $rowk["s_id"]; 
			$pname = $rowk["pump_id"];
			$date = $rowk["pump_date"];
			$strread = $rowk["pump_reading"]; 
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
		<h2>PUMP <span>TRANSACTION</span></h2>
	</div>
	<!-- //about-heading -->
    
     <!-- choose -->
	<div class="choose jarallax">
  
		<div class="w3-agile-page">
			<div class="container">
              <div class="header">
              	<ul class="breadcrumb">
                	<li><a href="home.php">Home</a> </li>
                	<li class="active">Pump Transaction</li>
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
                             <form  name="cform" method="post" action="pumptransemaster.php" >
                                    <div class="col-sm-3 textalign labelalign"> PUMP NAME
                                           <select class="form-control"  name="pname" id="pname"  maxlength="80"  onkeypress="return pfNumberKey(event)" required>
                            <option value="">--Select--</option>
                           <?php 
                           $sqlquery2 = "select `pump_id`,`pump_name`  from `pump_master`";
                           $queryresult2 = mysql_query($sqlquery2) or die("Query failed --1");
                           while ($row2 = mysql_fetch_array($queryresult2))
                         {
                        if($pname==$row2["pump_id"]) $dselval="selected";
                           else  $dselval=" ";
                       echo  "<option value='".$row2["pump_id"]."' $dselval >".$row2["pump_name"]."</option>" ;
                       } 
                      ?> 
                        </select><input type="hidden"   name="sid" id="sid" value="<?php echo $psno; ?>" />
                                           </div>
										
										<div class="col-sm-3 textalign labelalign">  PUMP READING
                                        <input type="text" class="form-control"  name="strread" id="strread" placeholder="Pump Reading" maxlength="50"  onkeypress="return pfNumberKey(event)"  value="<?php echo $strread; ?>" required/> </div>
                                          
										  <div class="col-sm-3 textalign labelalign">   DATE  
                        <input type="text" class="form-control"  name="date" id="date"  placeholder="DD/MM/YYYY" maxlength="10"  onBlur="return ValidateForm()"  value="<?php echo $date; ?>" required />
                    </div>
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
if (isset($_POST['strread'])) {  
 
 
     $strread =   make_safe($_POST['strread']);
    $date =   $_POST['date'];
	$datem=(explode(" ",$date ));
	   $msdate=implode(array_reverse(explode("/",$datem[0])),"-");
	   $date=$msdate." ".$datem[1];
	$pname =   make_safe($_POST['pname']);
  
     $sid =   make_safe($_POST['sid']);
  
   $status =   make_safe($_POST['status']);
	$userid =  htmlentities($_SESSION['USER_ID']);  
  
  // echo ';;;;;'.$pname;


 	if ($pname!="" && $date!="" && $strread!="" ) {
	 
	//if(pumptransename($sid,$pname,$strread,$date,$status)){
				echo $mpass =  pumptransemaster($sid,$pname,$strread,$date,$userid,$cdate,$status);
				//header("location:pumptransemaster.php");
		/*}
			else{ echo 'This User already exits'; } */
 	} else {
    	// The correct POST variables were not sent to this page. 
    	echo 'Please enter all the mandatory fields';
	}
} 
?>                       
                 
                   <br />
                       <div class="col-sm-12">
        <div class="panel panel-default">
       <div class="panel-body ">  <?php echo $sd =pumptransegrid(); ?>    </div>
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
$('#date').datetimepicker({
dayOfWeekStart : 1,
lang:'en', 
startDate:	'1986/01/05'
});
$('#date').datetimepicker({ step:1});



</script>
  <?php require_once("footer.php"); ?>
 
 </html>