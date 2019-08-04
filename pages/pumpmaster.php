 <?php 
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';
include_once 'function/pumpfunction.php';
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
$del_qry = "DELETE FROM pump_master WHERE trim(pump_id)=trim('".$icode."')";
$result = mysql_query($del_qry);
} 
if((!empty($edm)) && ($edm=="edit")){   
$select_query =  "SELECT `pump_id`, `pump_name`, `tank_id`, `item_code`, `user_id`, `pump_date`, `status` FROM `pump_master`   WHERE  pump_id='".$icode."'";
//echo $select_query;
$resultk = mysql_query($select_query);
	
while ($rowk = mysql_fetch_array($resultk)) {
if($rowk["STATUS"]=="A") $status1="selected";
if($rowk["STATUS"]=="I") $status2="selected";
$psno = $rowk["pump_id"];
$cname = $rowk["pump_name"]; 
$tankid = $rowk["tank_id"];
$itemcode = $rowk["item_code"];
}
	}
	}
 ?>
  <!DOCTYPE html>
<html>
    <head> 
 
 
</head>
 <body>
 	<!-- about-heading -->
	<div class="about-heading">
		<h2>Pump <span>Master</span></h2>
	</div>
	<!-- //about-heading -->
    
     <!-- choose -->
	<div class="choose jarallax">
  
		<div class="w3-agile-page">
			<div class="container">
              <div class="header">
              	<ul class="breadcrumb">
                	<li><a href="home.php">Home</a> </li>
                	<li class="active">Pump Master</li>
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
                             <form  name="cform" method="post" action="pumpmaster.php"  >
                                    
                                      <div class="col-sm-3 textalign labelalign">  PUMP NAME
                                            <input type="text" class="form-control"  name="pumpname" id="pumpname" placeholder="ENTER Tank Name" maxlength="100"  onkeypress="return pfNumberKey(evt)"  value="<?php echo $cname; ?>" required />
											<input type="hidden"   name="sid" id="sid" value="<?php echo $psno; ?>" />
                                           </div>
                                          <div class="col-sm-3 textalign labelalign">  TANK NAME
                                        <select class="form-control"  name="tankid" id="tankid" required>
                                         <option>--Select--</option>
                                               	  <?php 
				$sqlquery2 = "SELECT `tank_id`,`tank_name` FROM `tank_master` WHERE `status`='A'";
	        $queryresult2 = mysql_query($sqlquery2) or die("Query failed --1");
  			 
								while ($row2 = mysql_fetch_array($queryresult2))
  								{
									if($tankid==$row2["tank_id"]) $dselval="selected";
									else  $dselval=" ";
									echo  "<option value='".$row2["tank_id"]."' $dselval >".$row2["tank_name"]."</option>" ;
								} 
								?></select> </div>
                                          <div class="col-sm-3 textalign labelalign"> PRODUCT NAME 
                         <select class="form-control"  name="itemcode" id="itemcode" required>
                                          <option>--Select--</option>
                                               	  <?php 
				$sqlquery2 = "SELECT `s_id`,`produt_name` FROM `product_master` WHERE `status`='A'";
				
	        $queryresult2 = mysql_query($sqlquery2) or die("Query failed --1");
  			 
								while ($row2 = mysql_fetch_array($queryresult2))
  								{
									if($itemcode==$row2["s_id"]) $dselval="selected";
									else  $dselval=" ";
									echo  "<option value='".$row2["s_id"]."' $dselval >".$row2["produt_name"]."</option>" ;
								} 
								?></select>  
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
  if(isset($_POST['pumpname']))
		 {
     $pumpid =   make_safe($_POST['sid']);
	  $pumpname =   make_safe($_POST['pumpname']);
	   $tankid =   make_safe($_POST['tankid']);
	  $itemcode =   make_safe($_POST['itemcode']);
	     $status =   make_safe($_POST['status']);
		$userid =  htmlentities($_SESSION['USER_ID']);  
	    
		
	 //$userid =  htmlentities($_SESSION['USER_ID']);  
   //$sid =  make_safe($_POST['sid']);
 	if ($pumpname!="" && $tankid!="" && $itemcode!="" ) {
	 
		if(pumpname($pumpid,$pumpname,$tankid,$itemcode,$status) ){
				echo $mpass=pumpmaster($pumpid,$pumpname,$tankid,$itemcode,$userid,$pumpdate,$status);
				//header("location:pumpmaster.php");
			}
		else{ echo 'This id Name already exits'; } 
 	} else {
    	// The correct POST variables were not sent to this page. 
    	echo 'Please enter the id Name';
	}
} 
?>            
                   <br />
                         <div class="col-sm-12">
        <div class="panel panel-default">
     
			<div class="panel-body ">     <?php echo $sd =pumpgrid(); ?>     </div>
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