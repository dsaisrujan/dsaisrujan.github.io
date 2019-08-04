<?php
ob_start();
include_once '../includes/db_connect.php';
if(isset($_GET["otype"]))
{
	$otype=$_GET['otype'];
	?>
	<select class="form-control"  name="calbr" id="calbr">
            <option>--Select--</option>
            <?php 
			$sqlquery2 = "SELECT `s_id`, `tank_diameter`, `tank_length`, `capacity` FROM `calibration_master` WHERE `oil_type`='".$otype."' and `status`='A'";
			//echo $sqlquery2;
	        $queryresult2 = mysql_query($sqlquery2) or die("Query failed --1");
				while ($row2 = mysql_fetch_array($queryresult2))
  					{
						if($calbr==$row2["s_id"]) $dselval="selected";
						else  $dselval=" ";
						echo  "<option value='".$row2["s_id"]."' $dselval >(DIA)".$row2["tank_diameter"].",(LEN)".$row2["tank_length"].",(CAP)".$row2["capacity"]."</option>" ;
					} 
			?></select>
			
<?php } 

////////////////////////////

if(isset($_GET["pdtank"]))
{
	$pdtank=$_GET['pdtank'];
	?>
	<select class="form-control"  name="dtype" id="dtype" >
       <?php 
					  
					  if($pdtank==""){echo  "<option >--Select--</option>" ;}
					  else {
					  
				$sqlquery2 = "SELECT `oil_type`,(SELECT `produt_name` FROM `product_master` WHERE `s_id`= p.oil_type)oiltype FROM `tank_master` p WHERE `calibration_id`='".$pdtank."' and `status`='A'";
				//echo $sqlquery2;
	        $queryresult2 = mysql_query($sqlquery2) or die("Query failed --1");
  			 
								while ($row2 = mysql_fetch_array($queryresult2))
  								{
									if($dtype==$row2["oil_type"]) $dselval="selected";
									else  $dselval=" ";
									echo  "<option value='".$row2["oil_type"]."' $dselval >".$row2["oiltype"]."</option>" ;
									}
					 }
					  
						?> 
						 </select  >
			
<?php } 

////////////////////////////
if(isset($_GET["pid"]) && isset($_GET["sdate"]) )
{
	$pid=$_GET['pid'];
	$sdate=$_GET['sdate'];
	
		$datem=(explode(" ",$sdate ));
		$msdate=implode(array_reverse(explode("/",$datem[0])),"-");
		$sdate=$msdate." ".$datem[1];
	?>
	<select class="form-control"  name="price" id="price" >
       <?php 
					  
					  if($pid==""){echo  "<option >--Select--</option>" ;}
					  else {
					  
				$sqlquery2 = "SELECT `s_id`,(SELECT `produt_name` FROM `product_master` WHERE `s_id`=p.item_code)product,`price` FROM `price_master` p WHERE `item_code`='".$pid."'and `price_date`<='".$sdate."' and `status`='A'  ORDER BY `price_date` DESC LIMIT 1";
				//echo $sqlquery2;
                           $queryresult2 = mysql_query($sqlquery2) or die("Query failed --1");
                           while ($row2 = mysql_fetch_array($queryresult2))
                         {
							$product=$row2['product']; 
							 $prices=$row2['price']; 
                        if($price==$row2["s_id"]) $dselval="selected";
                           else  $dselval=" ";
                       echo  "<option value='".$row2["s_id"]."' $dselval >".$prices."</option>" ;
                       }
					  }
					  
					  
						?>
						
						 </select>
						 
						 <?php 
$sqlquery1 = "SELECT `product_quantity` FROM `product_master` WHERE `s_id`='".$pid."'";
$queryresult = mysql_query($sqlquery1) or die("Query failed --1");
	$row2 = mysql_fetch_array($queryresult);
	$pqty1=$row2['product_quantity']; ?>
						 <input type= "hidden" class="form-control"  name="product" id="product"  value="<?php echo $product; ?>" /> 
						 <input type= "hidden" class="form-control"  name="price1" id="price1"  value="<?php echo $prices; ?>" /> 
 <input type="hidden" class="form-control"  name="pqty" id="pqty" value="<?php echo $pqty1; ?>" />
						

<?php }
/////////////
if(isset($_GET["price"]) && isset($_GET["nou"]) )
{
	$price=$_GET['price'];
	$nou=$_GET['nou'];
	$count3=$_GET['count3'];
	
?><?php	

                         
                           $sqlquery2 = "SELECT `s_id`,`price` FROM `price_master` WHERE `s_id`='".$price."'";
						//echo $sqlquery2;
                           $queryresult2 = mysql_query($sqlquery2) or die("Query failed --1");
                           while ($row2 = mysql_fetch_array($queryresult2))
                         {
						$price1= $row2["price"];
						
                        }
						$amount=$nou*$price1;
						if($count3==""){ $count="0";
						$counts	=	$count	+	$amount; }
						else{$counts	=	$count3	+	$amount;
							
						}
						
						?>
						
                 <input type= "text" class="form-control"  name="amount" id="amount" placeholder=" Amount"   maxlength="100"  onkeypress="return pfNumberKey(event)"  value="<?php echo $amount; ?>" />  

				<input type= "hidden" class="form-control"  name="total1" id="total1"  value="<?php echo $counts; ?>" />
				<input type= "hidden" class="form-control"  name="count3" id="count3"  value="<?php echo $counts; ?>" />
									
<?php	
}
 /////////////
if(isset($_GET["fpid"]))
{
	$proid=$_GET['fpid'];
?><?php	 
				$sqlquery2 = "SELECT `produt_name` FROM `product_master` WHERE `s_id`='".$proid."'";
  $queryresult2 = mysql_query($sqlquery2) or die("Query failed --1");
                          $row2 = mysql_fetch_array($queryresult2);
                       
								$product= $row2["produt_name"]; 
						
 ?>
  <input type= "hidden" class="form-control"  name="product" id="product"  value="<?php echo $product; ?>" />
<?php } 
/////////////
if(isset($_GET["vno"]))
{
	$vehicle=$_GET['vno'];
?><?php	 
				$sqlquery2 = "SELECT `cc_vehicle_no` FROM `creditcustomer_vechicle_master` WHERE `cc_s_id`='".$vehicle."'";
  $queryresult2 = mysql_query($sqlquery2) or die("Query failed --1");
                         $row2 = mysql_fetch_array($queryresult2);
                         
								$vehicle= $row2["cc_vehicle_no"]; 
						
 ?>
 <input type= "hidden" class="form-control"  name="vehicle" id="vehicle"  value="<?php echo $vehicle; ?>" /> 


<?php }

//////////

if(isset($_GET["bnumber"]))
{
	$bnumber=$_GET['bnumber'];
	 	
	
	  $sqlquery2 = "SELECT `bill_number` FROM `bill_entry` WHERE `bill_number`='".$bnumber."'";
//echo $sqlquery2;
	  $result = mysql_query($sqlquery2) or die("Query failed -----1");
  	  $num=mysql_numrows($result);
	 if ($num > 0) {
	 
	   echo $res='<strong style="color:#FF0000">This Bill number already Exists</strong> ';  
	  
                              ?>  <input type="text" class="form-control"  name="bnumber" id="bnumber" placeholder="Bill Number" maxlength="50"  onkeypress="return checkNum(event)"   onblur="getTimecustomer(this.value);" />  
										   <?php 
										   
	
	 } else {
		?>   <input type="text" class="form-control"  name="bnumber" id="bnumber" placeholder="Bill Number" maxlength="50"  onkeypress="return checkNum(event)" value="<?php echo $bnumber; ?>"  onblur="getTimecustomer(this.value);" />
	<?php }
	 
} 

//////////////
if(isset($_GET["price"]) && isset($_GET["count3"]) &&isset($_GET["qnty"]) )
{
	$price=$_GET['price'];
	$qnty=$_GET['qnty'];
	 	$count3=$_GET['count3'];
		
		$amount=$qnty*$price;
		if($count3==""){ $count="0";
						$counts	=	$count	+	$amount; }
						else{$counts	=	$count3	+	$amount;
							
						} ?>
						<input type= "hidden" class="form-control"  name="total" id="total"  value="<?php echo $counts; ?>" /> 
						<input type="hidden" class="form-control"    name="count3" id="count3"   value="<?php echo $counts; ?>"/>
						<?php
}


//////////////
if(isset($_GET["pid"]) && isset($_GET["nou"]))
{
	$pid=$_GET['pid'];
	 	$nou=$_GET['nou'];
 
			$sqlquery2 = "SELECT `product_quantity` FROM `product_master` WHERE `s_id`=	'".$pid."'"	;
			//echo $sqlquery2;
	  $result = mysql_query($sqlquery2) or die("Query failed -----1");
  	  $row2 = mysql_fetch_array($result);
	  
	  $qty=$row2["product_quantity"];
	  
	   //echo $res='<strong style="color:#FF0000">This Bill number already Exists</strong> ';  
			if ( strcmp($nou, $qty) <= 0) {
			?>
  <input type="text" class="form-control"  name="nou" id="nou" placeholder="Quantity" maxlength="100" onchange="calbrmenus(this.value);"  onKeyPress="return isNumberKey(event)"  value="<?php echo $nou; ?>" onblur="nounits(this.value);"/> 
			<?php }	
else {
	?><?php echo $rs='<strong style="color:#FF0000">This oil quantity not available from oil tank</strong> ';$nou="";	?> 
	
	 <input type="text" class="form-control"  name="nou" id="nou" placeholder="Quantity" maxlength="100" onchange="calbrmenus(this.value);"  onKeyPress="return isNumberKey(event)"  value="<?php echo $nou; ?>" onblur="nounits(this.value);"/> 
<?php }			
}
?> 
