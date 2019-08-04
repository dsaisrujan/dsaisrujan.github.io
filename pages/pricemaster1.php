 <?php 
 include_once '../includes/db_connect.php';
include_once '../includes/functions.php';
//include_once 'function/pricefunction1.php';
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
$psno=$product= $status1= $status2="";
	
	 if($icode!=""){
	   if((!empty($edm)) && ($edm=="del")){   
		     $del_qry = "DELETE FROM price_master WHERE trim(`s_id`)=trim('".$icode."')";
		      $result = mysql_query($del_qry);
	
		} 

	if((!empty($edm)) && ($edm=="edit")){   
	  $select_query =  "SELECT `s_id`, `item_code`, `price`, `price_date`,DATE_FORMAT(price_date,'%d/%m/%Y %H:%m:%s') as pdate, `c_user`, `c_date`, `status` FROM `price_master` WHERE s_id='".$icode."'";
	  //echo   $select_query; 
	  $resultk = mysql_query($select_query);
	
    	while ($rowk = mysql_fetch_array($resultk)) {
			if($rowk["status"]=="A") $status1="selected";
			if($rowk["status"]=="I") $status2="selected";
			$psno = $rowk["s_id"];
			$product = $rowk["item_code"];
			$price = $rowk["price"]; 
			$pricedate = $rowk["pdate"]; 
    	  
		}
	}
	}
	
 ?>
 
<!DOCTYPE html>
<html>
<head> 
<link rel="stylesheet" href="datepickertime1/jquery.datetimepicker.css" /> 
</head>
 <body>
 
 	<!-- about-heading -->
	<div class="about-heading">
		<h2>PRICE ENTRY<span> MASTER </span></h2>
	</div>
	<!-- //about-heading -->
    
     <!-- choose -->
	<div class="choose jarallax">
  
		<div class="w3-agile-page">
			<div class="container">
              <div class="header">
              	<ul class="breadcrumb">
                	<li><a href="home.php">Home</a> </li>
                	<li class="active">Price Entry Master</li>
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
                             <form  name="cform" method="post" action="pricemaster.php">
                             
  <div class="col-sm-3 textalign labelalign"> PRODUCT NAME
                         <select class="form-control"  name="product" id="product" onchange="calbrmenu(this.value)" required>
                                          <option>--Select--</option>
                                               	  <?php 
				$sqlquery2 = "SELECT `s_id`,`produt_name` FROM `product_master` WHERE `status`='A'";
				
	        $queryresult2 = mysql_query($sqlquery2) or die("Query failed --1");
  			 
								while ($row2 = mysql_fetch_array($queryresult2))
  								{
									if($product==$row2["s_id"]) $dselval="selected";
									else  $dselval=" ";
									echo  "<option value='".$row2["s_id"]."' $dselval >".$row2["produt_name"]."</option>" ;
								} 
								?></select>  
                                          <input type="hidden" class="form-control"  name="sid" id="sid" value="<?php echo $psno; ?>" />
     
  </div>
 <div class="col-sm-3 textalign labelalign"> PRICE
  <input type="text" class="form-control"  name="price" id="price" placeholder="Price" maxlength="100"  onkeypress="return isNumberKey(event)"  value="<?php echo $price; ?>" /></div>
<div class="col-sm-3 textalign labelalign">  PRICE DATE
  <input type="text" class="form-control"  name="pricedate" id="pricedate" placeholder="DD/MM/YYYY" maxlength="10"  onBlur="return  ValidateForm()"   value="<?php echo $pricedate; ?>" /> </div>
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
  if(isset($_POST['product']))
		 {
		$product =  make_safe($_POST['product']);
		$price = make_safe($_POST['price']);
		$pricedate =  $_POST['pricedate'];
		$datem=(explode(" ",$pricedate ));
		$msdate=implode(array_reverse(explode("/",$datem[0])),"-");
		$pricedate=$msdate." ".$datem[1];
		$status =  make_safe($_POST['status']);
		$userid =  htmlentities($_SESSION['USER_ID']);
		$sid = make_safe($_POST['sid']);
 	if ($product!="" && $price!="" && $pricedate!="") {
	 
		//if(priceid($product,$price,$pricedate,$userid,$cdate,$status)){
				echo $sd =pricemaster($sid,$product,$price,$pricedate,$userid,$cdate,$status);
				//header("location:pricemaster.php");
		/*}
	else{ echo 'This id Name already exits'; }*/
} else {
    	echo 'Please enter the id Name';// The correct POST variables were not sent to this page. 
   }	
	}

?>          
                   <br />
                         <div class="col-sm-12">
        <div class="panel panel-default">
       
                    <div class="panel-body ">   <?php //echo  $sd = pricegrid(); ?>       </div>
               </div></div>
					</div>
					<div class="clearfix"> </div>
				</div>
                
			</div>
         
	</div>
	<!-- //choose -->
 
    
 </body>
 <script src="datepickertime1/jquery.js"></script>
<script src="datepickertime1/jquery.datetimepicker.full.js"></script>
<script type = "text/javascript">

$.datetimepicker.setLocale('en');
$('#pricedate').datetimepicker({
dayOfWeekStart : 1,
lang:'en', 
startDate:	'1986/01/05'
});
$('#pricedate').datetimepicker({ step:1});


</script>
 <?php require_once("footer.php"); ?>
 </html>