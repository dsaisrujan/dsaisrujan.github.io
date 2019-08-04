<?php
ob_start();
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';
 

 if(!session_id()) { session_start(); }
 
 if(isset($_GET["cat"]))
{
	 $main_name=$_GET['cat']; ?>
          <select class="form-control" style="width:80%;" name="fpid"  id="fpid" onchange="showpro(this.value)" > 
                                             <option value="">--Select--</option>
                                            
                	 <?php 
                                            $sqlquerym = "select `s_id`, `product_name` from `product_master` where  status='A' and product_head='".$main_name."' order by product_name";	        	
											 echo   $sqlquerym;
                                            $queryresultm = mysql_query($sqlquerym) or die("Query failed --Category Menu");
                                         
                                                            while ($rowm = mysql_fetch_array($queryresultm))
                                                            {
                                                                if($fpid==$rowm["s_id"]) $dselval="selected";
                                                                else  $dselval=" ";
                                                                echo  "<option value='".$rowm["s_id"]."' $dselval >".$rowm["product_name"]."</option>" ;
                                                            } 
                                                            ?>
                                </select> 
<?php

	$sqlquery = "select `s_id`, `title` from `category_master` where  s_id='".$main_name."' ";
$queryresult = mysql_query($sqlquery) or die("Query failed --Category Menu");
 while ($rowk = mysql_fetch_array($queryresult))
                                                            {
                                                                
                                                                
                                                                 $category=$rowk["title"];
                                                            } ?>
															 <input type="hidden" name="category" id="category" value="<?php echo  $category; ?>"/>
 <?php
}
 if(isset($_GET["fpid"]))
{
	 $main_name=$_GET['fpid']; 
	$sqlquerym = "select `s_id`, `product_name` from `product_master` where  status='A' and s_id='".$main_name."' ";
$queryresultm = mysql_query($sqlquerym) or die("Query failed --Category Menu");
 while ($rowm = mysql_fetch_array($queryresultm))
                                                            {
                                                                
                                                                
                                                                 $product=$rowm["product_name"];
                                                            } ?>
															 <input type="hidden" name="product" id="product" value="<?php echo  $product; ?>"/>
<?php
}

if(isset($_GET["delar_id"]))
{
	 $main_name=$_GET['delar_id']; 
	$sqlquerym = "SELECT `S_NO`,`ORGANISATION` FROM `registration_details` WHERE S_NO='".$main_name."' ";
$queryresultm = mysql_query($sqlquerym) or die("Query failed --Category Menu");
 while ($rowm = mysql_fetch_array($queryresultm))
                                                            {
                                                                
                                                                
                                                                 $delr=$rowm["S_NO"];
																 $dname=$rowm["ORGANISATION"];
                                                            } ?>
                                                           
															 <input type="hidden" name="delr" id="delr" value="<?php echo  $delr; ?>"/>
                                                             <input type="hidden" name="dname" id="dname" value="<?php echo  $dname; ?>"/>
<?php

}


if(isset($_GET["productqty"]))
{
$productqty=$_GET['productqty'];
$packageqty=$_GET['packageqty'];
$tqty= $productqty*$packageqty;
if($tqty!=""){
?>
<input type="hidden" name="tqty" id="tqty" value="<?php echo  $tqty; ?>"/>

<input type="button" id="add" value="Add"  class="plusbtn"   onClick="addbook()">
       <input type="button" id="delete" value="delete"  class="minusbtn"  onClick="deleteRow('myTable')"/>
       <?php
	   }
	   }


if(isset($_GET["amount"]) && isset($_GET["tt"]))
{
		$amount=$_GET['amount'];
		$tt=$_GET['tt'];
		if($tt!="" && $amount!=""){
			$sqlquerym = "SELECT `balance_total` FROM `transaction_stock` WHERE `transation_type`='".$tt."' ";
			$queryresultm = mysql_query($sqlquerym) or die("Query failed --Category Menu");
 				while ($rowm = mysql_fetch_array($queryresultm))
                          {
							$blncet=$rowm["balance_total"];
						}
						$bt=$blncet+$amount;						
?>

<input type="text" class="form-control" name="bt" id="bt" placeholder="Balance Total" maxlength="80" onkeypress="return isNumberKey(event)" value="<?php echo $bt; ?>" <?php echo $var="readonly"; ?>/>

<?php 
}
else{ echo $rs= "please select transaction type and amount";
}
}



if(isset($_GET["fcity"]))
{
  $city=$_GET["fcity"];
  $fpincode=$_GET["fpincode"];
  
  $franch_id="";
  $select_qry="SELECT franch_id,`franch_name`,`mobile_no`,`pincode`, `email`,`city`, `office_address`, `company_email`,`status` FROM `franchisee_master` WHERE  city='". $city."'";
  //echo  $select_qry;
  $queryresult = mysql_query($select_qry) or die("Query failed --Category Menu");
 while ($rowk = mysql_fetch_array($queryresult))
                                                            {
																$city=$rowk["city"];
																$pincode=$rowk["pincode"]; 
																 $pincodes = explode("-", $pincode);
																//echo $pincodes[0]; 
																  for($i = 0; $i < $pincodes[$i]; $i++) {
																if ( strcmp($pincodes[$i], $fpincode) == 0) 
																{
			 	$franch_id .= ",".$rowk["franch_id"];
			}
                                         }             }
										 
										  $franch_id=trim($franch_id,',');
										  //echo $franch_id;
										  
										  ?>
										  
										  <select class="form-control"  name="fname" id="fname" style="width:60%" required> 
                                             <option value="">--Select--</option>
                	  <?php if($franch_id!=""){
				$sqlquery4 = "SELECT `franch_id`, `franch_name`,`status` FROM `franchisee_master` WHERE `franch_id` in (".$franch_id.") ";
				echo $sqlquery4;
	        $queryresult4 = mysql_query($sqlquery4) or die("Query failed --role");
  			 
								while ($row4 = mysql_fetch_array($queryresult4))
  								{
									if($fname==$row4["franch_id"]) $dselval="selected";
									else  $dselval=" ";
									echo  "<option value='".$row4["franch_id"]."' $dselval >".$row4["franch_name"]."</option>" ;
								} }
								?>
                                </select> 
														<?php	}
															
?>