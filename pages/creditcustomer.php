<?php 
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';
include_once 'function/ccustomerfunction.php';
require_once("header.php"); 

sec_session_start();

if (login_check() == true) {
    $logged = 'in';
} else {
    $logged = 'out'; header("Location:../includes/logout.php");
}
$customer="";
$category="cuser";

$icode=$edm="";

if(!empty($_GET["icode"])){  $icode = $_GET["icode"];  }
if(!empty($_GET["edm"])){  $edm = $_GET["edm"];  }
$psno = $cname= $status1= $status2="";
	
if($icode!=""){
	   if((!empty($edm)) && ($edm=="del")){   
		     $del_qry = "DELETE FROM credit_customer_master WHERE trim(credit_customer_code)=trim('".$icode."')";
			 //echo $del_qry;
			 $result = mysql_query($del_qry);
	  	} 
	 
	 
	if((!empty($edm)) && ($edm=="edit")){   
	  $select_query =  "SELECT credit_customer_code,(SELECT `USER_ID` FROM `user_master` WHERE `REFERENCE_CODE` = c.credit_customer_code and USER_CATG='cuser')userid,credit_customer_name,category,cc_address1,cc_address2,cc_agency_name,email_id,cc_credit_limit,cc_register_date,cc_id_proof_type_code,id_proof_image,user_id,cc_mobile_no,role_id,status FROM `credit_customer_master` c  WHERE  credit_customer_code='".$icode."'";
//echo  $select_query;
	  $resultk = mysql_query($select_query);
	//echo $select_query;
    	while ($rowk = mysql_fetch_array($resultk)) {
			if($rowk["status"]=="A") $status1="selected";
			if($rowk["status"]=="I") $status2="selected";
			$psno = $rowk["credit_customer_code"];
			$cname = $rowk["credit_customer_name"];
			//$category = $rowk["category"]; 
			$address = $rowk["cc_address1"];
			$address1 = $rowk["cc_address2"]; 
             $agname = $rowk["cc_agency_name"];
			 $mailid = $rowk["email_id"];
			$crlimit = $rowk["cc_credit_limit"];
			$cell = $rowk["cc_mobile_no"]; 
			//$rgdate = $rowk["date"]; 
			$prcode = $rowk["cc_id_proof_type_code"];
			$simg = $rowk["id_proof_image"]; 
			$sphoto = $rowk["id_proof_image"]; 
				//$roled = $rowk["role_id"]; 
$status = $rowk["status"];
$user = $rowk["userid"]; 
//echo $user;			    	
}
					$customer="readonly";  
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
        $("#rgdate").datepicker({ dateFormat: 'dd/mm/yy', changeYear: true});
		
    });
</script> 

<script>
                 	
function getTimecustomer(mvalue){
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
xmlhttp.open("GET","cuserajax.php?user="+str,true);
xmlhttp.send();

}
</script>
 
</head>
 <body>
 	<!-- about-heading -->
	<div class="about-heading">
		<h2>CREDIT CUSTOMER  <span>MASTER</span></h2>
	</div>
	<!-- //about-heading -->
    
     <!-- choose -->
	<div class="choose jarallax">
  
		<div class="w3-agile-page">
			<div class="container">
              <div class="header">
              	<ul class="breadcrumb">
                	<li><a href="home.php">Home</a> </li>
                	<li class="active">Credit Customer Master</li>
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
                             <form  name="cform" method="post" action="creditcustomer.php"  enctype='multipart/form-data'>
                                    
                                      <div class="col-sm-3 textalign labelalign">CUSTOMER NAME
                                         <input type="text" class="form-control"  name="cuname" id="cuname" placeholder="Credit Customer Name" maxlength="50"  onkeypress="return checkNum(event)"  value="<?php echo $cname; ?>" required/><input type="hidden"   name="sid" id="sid" value="<?php echo $psno; ?>" />
                                           </div>
										    <div class="col-sm-3 textalign labelalign" id="uid">  USER ID
                                          <input type="text" class="form-control"  name="user" id="user" placeholder="Customer User" maxlength="50"  onkeypress="return checkNum(event)" value="<?php echo $user; ?>" <?php echo $customer; ?> <?php if($edm==""){ ?> onblur="getTimecustomer(this.value);" <?php } ?>/>
                                           </div>
										   <!--<div class="col-sm-3 textalign labelalign" >  CATEGORY :
                                          <select class="form-control"  name="category" id="category"  >
                                              <option value="">-- Select --</option>
                                                  <option value="1">cuser</option>
											
											</select></div>-->
                                          <div class="col-sm-3 textalign labelalign"> HOUSE NO.,AREA
                                         <input type="text" class="form-control"  name="address" id="address" placeholder="House Number & Area" maxlength="50"  onkeypress="return pfNumberKey(event)"  value="<?php echo $address; ?>" required/>  </div>
                                          <div class="col-sm-3 textalign labelalign"> CITY AND PINCODE
                         <input type="text" class="form-control"  name="address1" id="address1" placeholder="City & Pincode" maxlength="50"  onkeypress="return pfNumberKey(event)"  value="<?php echo $address1; ?>"required />
                                          </div>
                                           <div class="col-sm-3 textalign labelalign"> MOBILE NUMBER
                                       <input type="text" class="form-control"  name="cell" id="cell" placeholder="Enter Mobile Number" maxlength="10"  onkeypress="return  isNumberKey(event)"  value="<?php echo $cell; ?>" required/> </div>
                                          <div class="col-sm-3 textalign labelalign"> AGENCY NAME
                        <input type="text" class="form-control"  name="agname" id="agname" placeholder="Agency Name" maxlength="50"  onkeypress="return checkNum(event)"  value="<?php echo $agname; ?>" required/>
                                          </div>
                                           <div class="col-sm-3 textalign labelalign">  EMAIL-ID
                                        <input type="text" class="form-control"  name="mailid" id="mailid" placeholder="Enter Your Mail Id" maxlength="50"  onkeypress="return charEmail(event)"  value="<?php echo $mailid; ?>" required/></div>
                                          <div class="col-sm-3 textalign labelalign"> CREDIT LIMIT
                        <input type="text" class="form-control"  name="crlimit" id="crlimit" placeholder="Limit Amount" maxlength="50"  onkeypress="return isNumberKey(event)"  value="<?php echo $crlimit; ?>" required/>
                                          </div>
                                         
                                          <div class="col-sm-3 textalign labelalign"> PROOF NAME
                        <select class="form-control"  name="prcode" id="prcode" required>
                                          <option>--Select--</option>
                                             	  <?php 
				$sqlquery2 = "select `id_proof_type_code`, `id_proof_name` from `id_proof_type_master`";
	        $queryresult2 = mysql_query($sqlquery2) or die("Query failed --1");
			
  			 
								while ($row2 = mysql_fetch_array($queryresult2))
  								{
									if($prcode==$row2["id_proof_type_code"]) $dselval="selected";
									else  $dselval=" ";
									echo  "<option value='".$row2["id_proof_type_code"]."' $dselval >".$row2["id_proof_name"]."</option>" ;
								} 
								?>
                                </select>
                                          </div>
										 <!-- <div class="col-sm-3 textalign labelalign"> Role Name :
                                     <select class="form-control"  name="roled" id="roled" required>
                                             <option value="">--Select--</option>-->
                	  <?php 
				$sqlquery2 = "SELECT `s_id`,`role_name` FROM `role_master` WHERE `status`='A' AND `role_name`='creditcustomer'";
	        $queryresult2 = mysql_query($sqlquery2) or die("Query failed --1");
  			 
								while ($row2 = mysql_fetch_array($queryresult2))
  								{
									$roled=$row2["s_id"] ;
									//echo $roled;
									
								} 
								?>
								<input type="hidden" class="form-control"  name="roled" id="roled"   tabindex="2"  value="<?php echo $roled; ?>" />
								
								
                                <!--</select></div> -->
										  
                                          <div class="col-sm-3 textalign labelalign"> ID PROOF IMAGE
                                         <input type="file" id="simg" name="simg"  class="form-control"  value="<?php echo $simg; ?>" />  <br>
                                        <!-- <input type="hidden"   name="sphoto" id="sphoto"  value="<?php //echo $simg; ?>" /> -->

										  <input type="hidden" class="form-control"  name="sphoto" id="sphoto"   tabindex="2"  value="<?php echo $simg; ?>" />
                                      <?php if($simg!=""){ echo "<img src='".$simg."'  style='width:50px' />" ; } ?>
										  

										  </div>
										  
										   <!--<div class="col-sm-3 textalign labelalign">REGISTRED DATE
                                         <input type="text" class="form-control"  name="rgdate" id="rgdate" placeholder="DD/MM/YYYY" maxlength="10" onBlur="return  ValidateForm()"  value="<?php //echo $rgdate; ?>" required/></div>-->
                                 
                                          <div class="col-sm-3 textalign labelalign">  STATUS
                                           <select class="form-control"  name="status" id="status">
                                                <option value="A" <?php echo $status1; ?>>Active</option>
                                                <option value="I" <?php echo $status2; ?>>InActive</option>
                                               </select> 
                                        </div>
                                          <br /><br />
<br />

                                          <div class="col-sm-12" align="center"> 
                                <button type="submit" id="submit" class="btn1" >submit</button>                                  
                                 <button type="reset" class="btn1" >clear</button>
                                  </div>
                                </form>
                
						</div>
   <?php 
if (isset($_POST['agname'])) {
    
     $cuname =   make_safe($_POST['cuname']);
	 
	 //echo $cuname;
     $user =   make_safe($_POST['user']);
	$status =   make_safe($_POST['status']);
	
	  $address =   make_safe($_POST['address']);
    $address1 =   make_safe($_POST['address1']);
	//$category =   make_safe($_POST['category']);
	 $agname =   make_safe($_POST['agname']);
	 //echo $agname;
	 $mailid =   make_safe($_POST['mailid']);
	//echo $mailid;
	 $cell =   make_safe($_POST['cell']);
    $crlimit =   make_safe($_POST['crlimit']);
	 $roled =   make_safe($_POST['roled']);
	
	  /*$rgdate =   make_safe($_POST['rgdate']);
	  $datee=(explode("^",$rgdate));
	$rgdate=$datee[2]."-".$datee[1]."-".$datee[0];*/
	  
    $prcode =   make_safe($_POST['prcode']);
	$simg =   make_safe($_POST['sphoto']);
	$sphoto =  $_POST['sphoto'];
	 $userid =  htmlentities($_SESSION['USER_ID']);  
   $ccode =  make_safe($_POST['sid']);
 	
	//if ($cuname!="" && $mailid!="" && $agname!="" && $simg!="" ) {
		
		if ($cuname!="" && $mailid!="" && $agname!="" ) {
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
if (in_array($_FILES['simg']['type'], $allowedTypes))
{
   if ($_FILES["simg"]["error"] > 0)
    {
    echo "Return Code: " . $_FILES["simg"]["error"] . "<br>";
    }
  else
    {
	$fileName =  $_FILES["simg"]["name"];
 $kaboom = explode(".", $fileName); // Split file name into an array using the dot
$fileExt = end($kaboom); // Now target the last array element to get the file extension
  $fileName = date().time().rand().".".$fileExt;
 
    if (file_exists("img/".$spath . $_FILES["simg"]["name"]))
      {
      	echo $_FILES["simg"]["name"] . " already exists. ";
      }
    else
      {
		   move_uploaded_file($_FILES["simg"]["tmp_name"],"img/".$spath . $fileName);
	  //    echo "Copy this path : " . "img/".$spath . $_FILES["clogo"]["name"];
		  $title = $_FILES["simg"]["name"];
		  $path = "img/".$spath .$fileName;
		$sphoto = $path;
	    } // image PATH
    } // not empty PATH
  } // not validate type
		
	if(customername($cuname,$address,$address1,$agname,$mailid,$crlimit,$rgdate,$prcode,$sphoto,$userid,$cell,$roled,$status)){
				echo $mpass = customermaster($ccode,$user,$cuname,$category,$address,$address1,$agname,$mailid,$crlimit,$rgdate,$prcode,$sphoto,$userid,$cell,$roled,$status);
				//header("location:creditcustomer.php");
		}
			else{ echo 'This customer Name already exits'; } 
 	}else {
    	// The correct POST variables were not sent to this page. 
    	echo 'Please enter the customer Name';
	}
} 
?>                   
                 
                   <br />
                         <div class="col-sm-12">
        <div class="panel panel-default">
       
                        <div class="panel-body ">    <?php echo $sd = customergrid(); ?>      </div>
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