 <?php 
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';
include_once 'function/productfunction.php';
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
 $psno = $pname= $status1= $status2="";
	
	 if($icode!=""){
	   if((!empty($edm)) && ($edm=="del")){   
		     $del_qry = "DELETE FROM product_master WHERE trim(s_id)=trim('".$icode."')";
			 //echo $del_qry;
			 $result = mysql_query($del_qry);
	  	} 
	 
	 
	if((!empty($edm)) && ($edm=="edit")){ 

$select_query ="SELECT `s_id`, `produt_name`, `product_quantity`, `description`, `order_level`, `user_id`, `c_date`, `status` FROM `product_master` WHERE  s_id='".$icode."'";
	  //echo $select_query;
	  $resultk = mysql_query($select_query);
    	while ($rowk = mysql_fetch_array($resultk)) {
			if($rowk["Status"]=="A") $status1="selected";
			if($rowk["Status"]=="I") $status2="selected";
			$psno = $rowk["s_id"];
			$pname = $rowk["produt_name"]; 
			$pquantity = $rowk["product_quantity"];
			$desc = $rowk["description"];
			$olevel = $rowk["order_level"];
			
			
			
    	}
	}
	}
	
 
 ?>
 <!DOCTYPE html>
<html>

<body>
<!-- about-heading -->
	<div class="about-heading">
		<h2>PRODUCT  <span>MASTER</span></h2>
	</div>
<!-- //about-heading -->
<!-- choose -->
<div class="choose jarallax">
	<div class="w3-agile-page">
		<div class="container">
            <div class="header">
              	<ul class="breadcrumb">
                	<li><a href="home.php">Home</a> </li>
                	<li class="active">Product Master</li>
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
    <form  name="cform" method="post" action="productmaster.php" >
       
            
       
		<div class="col-sm-3 textalign labelalign">  PRODUCT NAME
			<input type="text" class="form-control"  name="pname" id="pname" placeholder="Product Name" maxlength="100"  onkeypress="return checkNum(event)"  value="<?php echo $pname; ?>" required/><input type="hidden" class="form-control"  name="sid" id="sid"  value="<?php echo $psno; ?>" />
			
		</div>
        <div class="col-sm-3 textalign labelalign">  PRODUCT QUANTITY
			<input type="text" class="form-control"  name="pquantity" id="pquantity" placeholder="Product Quantity" maxlength="100"  onkeypress="return checkNum(event)"  value="<?php echo $pquantity; ?>" required/>
		</div>
		
		<div class="col-sm-3 textalign labelalign">   ORDER LEVEL
			<input type="text" class="form-control"  name="olevel" id="olevel"  placeholder="Order Level" maxlength="25"     value="<?php echo $olevel; ?>" />            
		</div>
        <div class="col-sm-3 textalign labelalign">  STATUS
			<select class="form-control"  name="status" id="status">
			<option value="A" <?php echo $status1; ?>>Active</option>
			<option value="I" <?php echo $status2; ?>>InActive</option>
			</select> 
        </div>
		<div class="col-sm-12 textalign labelalign">  DESCRIPTION
		<textarea class="form-control"  name="desc" id="desc" rows="2" ><?php echo $desc;?></textarea>	
		</div>
		
            <br /><br /><br />
		<div class="col-sm-12" align="center"> 
            <button class="btn1" type="submit" id="submit">Submit</button>
            <button type="reset" class="btn1" >clear</button>
        </div>
    </form>
	</div>
					
 <?php
if(isset($_POST['pname'])) {
	$sid   =   make_safe($_POST['sid']);
	$pname =   make_safe($_POST['pname']);
	$pquantity   =   make_safe($_POST['pquantity']);
	$desc =   make_safe($_POST['desc']);
	$olevel =   make_safe($_POST['olevel']);
	$status   =   make_safe($_POST['status']);
	$userid =  htmlentities($_SESSION['USER_ID']);
   //$sid =  make_safe($_POST['sid']);
 	if ($pname!="" && $pquantity!="") {
	  if(productname($pname,$pquantity,$desc,$olevel,$status) ){
			echo $mpass=productmaster($sid,$pname,$pquantity,$desc,$olevel,$userid,$cdate,$status);
				//header("location:productmaster.php");
			}
			else{ echo 'This id Name already exits'; }
 	} else {
    	// The correct POST variables were not sent to this page. 
    	echo 'Please enter the fields';
	}
}
 
?>					
					
                    <br />
    <div class="col-sm-12">
        <div class="panel panel-default">
       
            <div class="panel-body ">      <?php echo $sd = productgrid(); ?>     </div>
            </div></div>
			</div>
				<div class="clearfix"> </div>
			</div>
            </div>
        </div>
	<!-- //choose -->
 
    
 </body>
 
<?php require_once("footer.php"); ?>
</html>