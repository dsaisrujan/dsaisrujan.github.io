<?php 
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';
include_once 'function/petroldipfunction.php';
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
		     $del_qry = "DELETE FROM petrol_dip WHERE trim(sno)=trim('".$icode."')";
			 $result = mysql_query($del_qry);
	  	} 
	
	if((!empty($edm)) && ($edm=="edit")){   
	  $select_query =  " SELECT `sno`, `dip`, `dip_type`, `pd_tank`, `volume`, `diff`, `c_user`, `c_date`, `status` FROM `petrol_dip` WHERE  sno='".$icode."'";
	 // echo $select_query;
	  $resultk = mysql_query($select_query);
    	while ($rowk = mysql_fetch_array($resultk)) {
			if($rowk["status"]=="A") $status1="selected";
			if($rowk["status"]=="I") $status2="selected";
			if($rowk["dip_type"]=="P") $otype="selected";
			if($rowk["dip_type"]=="D") $otype="selected";
			$psno = $rowk["sno"];
			$dtype = $rowk["dip_type"];
			$pdtank =  $rowk["pd_tank"];
			$dip = $rowk["dip"];
			$volume = $rowk["volume"];
			$diff = $rowk["diff"]; 
    	}
	}
	}
	
	
 ?>
 <!DOCTYPE html>
<html>
<head> 
 <script>
  function calbrmenu(mvalue)
{
	str = document.getElementById("pdtank").value;

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
    	document.getElementById("dtypes").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","calbrsajax.php?pdtank="+str,true);
xmlhttp.send();
}
</script>
 </head>
<body>
 	<!-- about-heading -->
	<div class="about-heading">
		<h2>CALIBRATION  <span>CHART MASTER</span></h2>
	</div>
	<!-- //about-heading -->
    
     <!-- choose -->
	<div class="choose jarallax">
  
		<div class="w3-agile-page">
			<div class="container">
              <div class="header">
              	<ul class="breadcrumb">
                	<li><a href="home.php">Home</a> </li>
                	<li class="active">Calibration Chart Master</li>
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
                             <form  name="cform" method="post" action="petroldip.php" >
                           <div class="col-sm-3 textalign labelalign"> CALIBRATION
                                           <select class="form-control"  name="pdtank" id="pdtank"  onchange="calbrmenu(this.value)">
                                             <option value="">--Select--</option>
                	  <?php 
				$sqlquery2 = "SELECT `calibration_id`,
				(SELECT concat('(DIA)', tank_diameter,',','(LEN)',tank_length,',','(CAP)',capacity)tank FROM `calibration_master` WHERE `s_id`=c.calibration_id)calb FROM `tank_master` c WHERE  `status`='A'";
				//echo $sqlquery2;
	        $queryresult2 = mysql_query($sqlquery2) or die("Query failed --1");
  			 
								while ($row2 = mysql_fetch_array($queryresult2))
  								{
									if($pdtank==$row2["calibration_id"]) $dselval="selected";
									else  $dselval=" ";
									echo  "<option value='".$row2["calibration_id"]."' $dselval >".$row2["calb"]."</option>" ;
									} 
								?>
                                </select  >
								<input type="hidden" name="sid" id="sid" value="<?php echo $psno; ?>" />
						 </div>             
                                     
							<!--<div class="col-sm-3 textalign labelalign"> DIP TYPE 
			<select class="form-control" name="dtype" id="dtype" required>
				<option value="">-- Select --</option>
				<option value="petrol" <?php //echo $dtype1; ?> >Petrol</option>
				<option value="disel" <?php //echo $dtype2; ?> >Disel</option>
				</select>
				
		</div>-->
					
					<div class="col-sm-3 textalign labelalign"> DIP TYPE 
					
					 <span id="dtypes"> <select class="form-control"  name="dtype" id="dtype" >
                                             <option value="">--Select--</option>
                	  <?php 
				$sqlquery2 = "SELECT `oil_type`,(SELECT `produt_name` FROM `product_master` WHERE `s_id`= p.oil_type)oiltype FROM `tank_master` p WHERE `calibration_id`='".$pdtank."' and `status`='A'";
				//echo $sqlquery2;
	        $queryresult2 = mysql_query($sqlquery2) or die("Query failed --1");
  			 
								while ($row2 = mysql_fetch_array($queryresult2))
  								{
									if($dtype==$row2["oil_type"]) $dselval="selected";
									
									else  $dselval=" ";
									
									
									
									
									/*if($row2["oil_type"]=="P") $otype="Petrol"; 
									if($row2["oil_type"]=="D") $otype="Disel" ;*/
									
									
									
									
									echo  "<option value='".$row2["oil_type"]."' $dselval >".$row2["oiltype"]."</option>" ;
									} 
								?>
                                </select ></span>
					
					</div>	 
						  <div class="col-sm-3 textalign labelalign"> DIP ID 
                                            <input type="text" class="form-control"  name="dip" id="dip" placeholder="Dip Id" maxlength="10"  onkeypress="return onlyNumbersWithDot(event)"  value="<?php echo $dip; ?>"required />
                                           </div>
										   
										   
                                          <div class="col-sm-3 textalign labelalign">   VOLUME
                                         <input type="text" class="form-control"  name="volume" id="volume" placeholder="Volume" maxlength="10"  onkeypress="return onlyNumbersWithDot(event)"  value="<?php echo $volume; ?>" required/> </div>
                                          <div class="col-sm-3 textalign labelalign">  DIFFERENCE
                          <input type="text" class="form-control"  name="diff" id="diff"  onkeypress="return onlyNumbersWithDot(event)"  placeholder="Difference" maxlength="10"  value="<?php echo $diff; ?>" required/></div>
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
  if(isset($_POST['dtype']))
		 {
    
	  $dtype =   make_safe($_POST['dtype']);
	  //echo $dtype;
	   $pdtank =   make_safe($_POST['pdtank']);
	   //echo $pdtank;
	   $dip =   make_safe($_POST['dip']);
	     $volume =   make_safe($_POST['volume']);
		  $diff =   make_safe($_POST['diff']);
	     $status =   make_safe($_POST['status']);
		 $sno =   make_safe($_POST['sid']);
	 $userid =  htmlentities($_SESSION['USER_ID']);
   
 	if ($dtype!="" && $pdtank!="") {
	 
		//if(petroldip($sno,$dip,$volume,$diff,$status)){
				echo $mpass=petroldipmaster($sno,$dip,$dtype,$pdtank,$volume,$diff,$userid,$cdate,$status);
				header("location:petroldip.php");
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

			<div class="panel-body ">     <?php echo $sd = petrolgrid(); ?>      </div>
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