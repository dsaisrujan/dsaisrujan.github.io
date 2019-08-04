 <?php 
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';
include_once 'function/employeefunction.php';
require_once("header.php");

sec_session_start();

if (login_check() == true) {
    $logged = 'in';
} else {
    $logged = 'out'; header("Location:../includes/logout.php");
}


$emp="";
$category="emp";
$icode=$edm=$add1=$add2=$cno=$eid=	$iptc=$ipsic=$idm1=$idm2="";
if(!empty($_GET["icode"])){  $icode = $_GET["icode"];  }
if(!empty($_GET["edm"])){  $edm = $_GET["edm"];  }
$psno = $cname= $status1= $status2="";
	
/*if($icode!=""){
if((!empty($edm)) && ($edm=="del")){   
$del_qry = "DELETE FROM employee_master WHERE trim(emp_code)=trim('".$icode."')";
echo $del_qry ;
$result = mysql_query($del_qry);
} */

 if($icode!=""){
	   if((!empty($edm)) && ($edm=="del")){   
		     $del_qry = "DELETE FROM employee_master WHERE trim(emp_code)=trim('".$icode."')";
			 //echo $del_qry ;
			 $result = mysql_query($del_qry);
	  	}
	 
if((!empty($edm)) && ($edm=="edit")){   
	$select_query =  "SELECT `emp_code`,(SELECT `USER_ID` FROM `user_master` WHERE `REFERENCE_CODE` = e.emp_code and USER_CATG='emp')userid, `emp_name`, `address1`, `address2`,`category`, `contact_no`, `email_id`, `id_proof_type_code`, `id_proof_image`, `id_marks1`, `id_marks2`, `role_id`, `s_id_user`,`c_date`, `status` FROM `employee_master` e  WHERE  emp_code='".$icode."'";
	//echo  $select_query ;
	$resultk = mysql_query($select_query);

	while ($rowk = mysql_fetch_array($resultk)) {
			if($rowk["status"]=="A") $status1="selected";
			if($rowk["status"]=="I") $status2="selected";
			
			$psno = $rowk["emp_code"]; 
			$cname = $rowk["emp_name"]; 
			$add1 = $rowk["address1"]; 
			$add2 = $rowk["address2"]; 
			//$category = $rowk["category"]; 
		   $cno = $rowk["contact_no"]; 
		   $eid = $rowk["email_id"];
			$iptc = $rowk["id_proof_type_code"]; 
			$eimg = $rowk["id_proof_image"]; 
			$sphoto = $rowk["id_proof_image"]; 
			//echo $eimg;
			$idm1 = $rowk["id_marks1"]; 
		   $idm2 = $rowk["id_marks2"];
		   $roleid = $rowk["role_id"]; 
		     $user = $rowk["userid"]; 
		  }
		$emp="readonly";  
	}
	}
	
	
	?>
	
	
 <!DOCTYPE html>
<html>
<head> 

<script>
                 	
function getTimeemp(mvalue){
	str = mvalue;
	
 // alert(str);
 
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
    	document.getElementById("uid").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","userajax.php?user="+str,true);
xmlhttp.send();

}
</script>

</head>
<body>
 	<!-- about-heading -->
	<div class="about-heading">
		<h2>EMPLOYEE  <span>MASTER</span></h2>
	</div>
	<!-- //about-heading -->
    
     <!-- choose -->
	<div class="choose jarallax">
  
		<div class="w3-agile-page">
			<div class="container">
              <div class="header">
              	<ul class="breadcrumb">
                	<li><a href="home.php">Home</a> </li>
                	<li class="active">Employee Master</li>
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
                             <form  name="cform" method="post" action="employeemaster.php"  enctype='multipart/form-data'>
                                    
                                      <div class="col-sm-3 textalign labelalign">  EMPLOYEE NAME
                                          <input type="text" class="form-control"  name="ename" id="ename" placeholder="Employee Name" maxlength="50"  onkeypress="return checkNum(event)"   value="<?php echo $cname; ?>" /><input type="hidden"   name="ecode" id="ecode" value="<?php echo $psno; ?>" />
                                           </div>
										   <div class="col-sm-3 textalign labelalign" id="uid">  USER ID
                                          <input type="text" class="form-control"  name="user" id="user" placeholder="Employee user" maxlength="50"  onkeypress="return checkNum(event)" value="<?php echo $user; ?>" <?php echo $emp; ?>  <?php if($edm==""){ ?> onblur="getTimeemp(this.value);"  <?php } ?> />
                                           </div>
										  <!--<div class="col-sm-3 textalign labelalign" >  Category :
                                          <select class="form-control"  name="category" id="category"   >
                                           <option value="">-- Select --</option>
                                                  <option value="1">emp</option>
											</select></div>-->
											
											
                                          <div class="col-sm-3 textalign labelalign">  HOUSE NO.,AREA
                                         <input type="text" class="form-control"  name="add1" id="add1" placeholder="House Number & Area" maxlength="50"  onkeypress="return pfNumberKey(event)"  value="<?php echo $add1; ?>" />  </div>
                                          <div class="col-sm-3 textalign labelalign">  CITY AND PINCODE
                          <input type="text" class="form-control"  name="add2" id="add2" placeholder="City & Pincode" maxlength="50"  onkeypress="return pfNumberKey(this.value)"  value="<?php echo $add2; ?>" />
                                          </div> 
										  
                                           <div class="col-sm-3 textalign labelalign">   CONTACT NUMBER
                                         <input type="text" class="form-control"  name="cno" id="cno" placeholder="Contact Number" maxlength="10"  onkeypress="return isNumberKey(event)"  value="<?php echo $cno ; ?>" /> </div>
                                          <div class="col-sm-3 textalign labelalign"> EMAIL ID
                         <input type="charemail" class="form-control"  name="eid" id="eid" placeholder="Email Id" maxlength="80"  onkeypress="return charEmail(event)" value="<?php echo $eid; ?>" />
                                          </div>
                                           
                                          
										
                                         
                                          <div class="col-sm-3 textalign labelalign">  ID MARKS1
                                          <input type="text" class="form-control"  name="idm1" id="idm1" placeholder="Id Marks1" maxlength="40"  onkeypress="return checkNum(event)"  value="<?php echo $idm1; ?>" /> </div>
										  
										  
										  
                                          <div class="col-sm-3 textalign labelalign"> ID MARKS2
                         <input type="text" class="form-control"  name="idm2" id="idm2" placeholder="Id Marks2" maxlength="40"  onkeypress="return checkNum(event)"  value="<?php echo $idm2; ?>" />
                                          </div>
										  
										  <div class="col-sm-3 textalign labelalign">ID PROOF NAME
                                        <select class="form-control"  name="iptc" id="iptc">
                                             <option value="">--Select--</option>
                	  <?php 
				$sqlquery2 = "select `id_proof_type_code`, `id_proof_name` from `id_proof_type_master` where status='A'";
	        $queryresult2 = mysql_query($sqlquery2) or die("Query failed --1");
  			 
								while ($row2 = mysql_fetch_array($queryresult2))
  								{
									if($iptc==$row2["id_proof_type_code"]) $dselval="selected";
									else  $dselval=" ";
									echo  "<option value='".$row2["id_proof_type_code"]."' $dselval >".$row2["id_proof_name"]."</option>" ;
								} 
								?>
                                </select> </div>
										  
										  <div class="col-sm-3 textalign labelalign"> ROLE NAME :
                                        <select class="form-control"  name="roleid" id="roleid">
                                             <option value="">--Select--</option>
                	  <?php 
				$sqlquery2 = "select `s_id`, `role_name` from `role_master` where status='A' and `s_id`<>'4'";
				
	        $queryresult2 = mysql_query($sqlquery2) or die("Query failed --1");
  			 
								while ($row2 = mysql_fetch_array($queryresult2))
  								{
									if($roleid==$row2["s_id"]) $dselval="selected";
									else  $dselval=" ";
									echo  "<option value='".$row2["s_id"]."' $dselval >".$row2["role_name"]."</option>" ;
								} 
								?>
                                </select></div>
										  <div class="col-sm-3 textalign labelalign"> ID PROOF IMAGE
                                         <input type="file" id="eimg" name="eimg"  class="form-control" value="<?php echo $eimg; ?>"  />  <br>
                                        <!-- <input type="hidden"   name="sphoto" id="sphoto"  value="<?php //echo $simg; ?>" /> -->

										  <input type="hidden" class="form-control"  name="sphoto" id="sphoto"   tabindex="2"  value="<?php echo $eimg; ?>" />
                                      <?php if($eimg!=""){ echo "<img src='".$eimg."'  style='width:50px' />" ; } ?>
										  

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
if (isset($_POST['ename'])) {  
 
 
     $ecode =   make_safe($_POST['ecode']);
	  $user =   make_safe($_POST['user']);
    $ename =   make_safe($_POST['ename']);
	$add1 =   make_safe($_POST['add1']);
    $add2 =   make_safe($_POST['add2']);
	 //$category =   make_safe($_POST['category']);
   $cno =   make_safe($_POST['cno']);
   $eid =   make_safe($_POST['eid']);
    $iptc =   make_safe($_POST['iptc']);
	$eimg =   make_safe($_POST['sphoto']);
	$sphoto =  $_POST['sphoto'];
    $idm1 =   make_safe($_POST['idm1']);
   $idm2 =   make_safe($_POST['idm2']);
    $roleid =   make_safe($_POST['roleid']);
   $status =   make_safe($_POST['status']);
	 $userid =  htmlentities($_SESSION['USER_ID']); 
  
   


 	if ($ename!="" && $add1!="" && $cno!="" && $eid!="" && $idm1!="") {
		
		$allowedTypes = array('image/JPG','image/jpg', 'image/jpeg','image/png', 'image/pjpeg', 'image/gif', 'application/pdf', 'application/doc');
 $path = "";
 $ftype = "user_data";
 $spath="";
 if($ftype!=""){  $spath=$ftype."/"; 	 }
	 $path="img/".$ftype;
	 if(!is_dir($path)){
                if(!mkdir($path)){
					echo "problem to create folder(".$ftype.")";
				}
		}

	 
// $extension = end(explode(".", $_FILES["file"]["name"]));
if (in_array($_FILES['eimg']['type'], $allowedTypes))
{
   if ($_FILES["eimg"]["error"] > 0)
    {
    echo "Return Code: " . $_FILES["eimg"]["error"] . "<br>";
    }
  else
    {
	$fileName =  $_FILES["eimg"]["name"];
 $kaboom = explode(".", $fileName); // Split file name into an array using the dot
$fileExt = end($kaboom); // Now target the last array element to get the file extension
  $fileName = date().time().rand().".".$fileExt;
 
    if (file_exists("img/".$spath . $_FILES["eimg"]["name"]))
      {
      	echo $_FILES["eimg"]["name"] . " already exists. ";
      }
    else
      {
		   move_uploaded_file($_FILES["eimg"]["tmp_name"],"img/".$spath . $fileName);
	  //    echo "Copy this path : " . "img/".$spath . $_FILES["clogo"]["name"];
		  $title = $_FILES["eimg"]["name"];
		  $path = "img/".$spath .$fileName;
		$sphoto = $path;
	    } // image PATH
    } // not empty PATH
  } // not validate type
		
		
	 
		if(eemployeename($ename,$add1,$add2,$category,$cno,$eid,$iptc,$sphoto,$idm1,$idm2,$roleid,$userid,$status)){
				echo $mpass = eemployeemaster($ecode,$user,$ename,$add1,$add2,$category,$cno,$eid,$iptc,$sphoto,$idm1,$idm2,$roleid,$userid,$cdate,$status);
				//header("location:employeemaster.php");
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
      
                      <div class="panel-body ">     <?php echo $sd = eemployeegrid(); ?>       </div>
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