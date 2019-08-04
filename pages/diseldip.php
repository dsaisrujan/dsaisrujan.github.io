 <?php 
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';
include_once 'function/diseldipfunction.php';
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
		     $del_qry = "DELETE FROM disel_dip WHERE trim(sno)=trim('".$icode."')";
			 $result = mysql_query($del_qry);
	  	} 
	
	if((!empty($edm)) && ($edm=="edit")){   
	  $select_query =  " SELECT `sno`, `dip`, `volume`, `diff`, `status` FROM `disel_dip` WHERE  sno='".$icode."'";
	  echo $select_query;
	  $resultk = mysql_query($select_query);
    	while ($rowk = mysql_fetch_array($resultk)) {
			if($rowk["STATUS"]=="A") $status1="selected";
			if($rowk["STATUS"]=="I") $status2="selected";
			$psno = $rowk["sno"];
			$cname = $rowk["dip"]; 
			$volume = $rowk["volume"];
			$diff = $rowk["diff"]; 
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
		<h2>Disel Dip  <span> Master</span></h2>
	</div>
	<!-- //about-heading -->
    
     <!-- choose -->
	<div class="choose jarallax">
  
		<div class="w3-agile-page">
			<div class="container">
              <div class="header">
              	<ul class="breadcrumb">
                	<li><a href="home.php">Home</a> </li>
                	<li class="active">Disel DipMaster</li>
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
                             <form  name="cform" method="post" action="diseldip.php">
                                    
                                      <div class="col-sm-3 textalign labelalign">  dip  
                                           <input type="text" class="form-control"  name="dip" id="dip" placeholder="ENTER dip" maxlength="10"  onkeypress="return onlyNumbersWithDot(event)"  value="<?php echo $cname; ?>" /><input type="hidden"   name="sid" id="sid" value="<?php echo $psno; ?>" />
                                           </div>
                                          <div class="col-sm-3 textalign labelalign">  volume
                                         <input type="text" class="form-control"  name="volume" id="volume" placeholder="ENTER volume" maxlength="10"  onkeypress="return onlyNumbersWithDot(event)"  value="<?php echo $volume; ?>" /> </div>
                                          <div class="col-sm-3 textalign labelalign">   diff 
                          <input type="text" class="form-control"  name="diff" id="diff"  onkeypress="return onlyNumbersWithDot(event)"  placeholder="Diff" maxlength="10"  value="<?php echo $diff; ?>" /></div>
                                          <div class="col-sm-3 textalign labelalign">  Status 
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
  if(isset($_POST['dip']))
		 {
     $dip =   make_safe($_POST['dip']);
	  $sno =   make_safe($_POST['sid']);
	     $volume =   make_safe($_POST['volume']);
		  $diff =   make_safe($_POST['diff']);
	     $status =   make_safe($_POST['status']);
	 
   //$sid =  make_safe($_POST['sid']);
 	if ($dip!="") {
	 
		if(petroldip($sno,$dip,$volume,$diff,$status)){
				echo $mpass=petroldipmaster($sno,$dip,$volume,$diff,$status);
				//header("location:tankmaster.php");
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
     <?php
				 $select_query =  "SELECT count(`dip`) as count  FROM `disel_dip`";
		 $resultk = mysql_query($select_query);
		    while ($rowk = mysql_fetch_array($resultk)) {
         $count = $rowk["count"];} 
		?>
            <div class="panel-heading no-collapse">NUMBER OF RECORDS<span class="label label-warning"><?php  echo $count ?> </span></div>
			<div class="panel-body ">     <?php echo $sd = petrolgrid();?>       </div>
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
 