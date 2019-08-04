 <?php 
 include_once '../includes/db_connect.php';
include_once '../includes/functions.php';
include_once 'function/ccbillfunction.php';
require_once("header.php");
 
 sec_session_start();

if (login_check() == true) {
    $logged = 'in';
} else {
    $logged = 'out'; header("Location:../includes/logout.php");
}
?>
 
<!DOCTYPE html>
<html>
    <head> 
	<link rel="stylesheet" href="datepickertime1/jquery.datetimepicker.css" /> 
	<script language="javascript">
	 /*function multiplay() {
        var txtFirstNumberValue = document.getElementById('price1').value;
        var txtSecondNumberValue = document.getElementById('nou').value;
		alert(txtFirstNumberValue);
		alert(txtSecondNumberValue);
		//var add = document.getElementById('ta').value;
        var result = txtFirstNumberValue * txtSecondNumberValue;
       alert(result);
	   if(!isNaN(result)){
            document.getElementById('amount').value = result;
			        
			
        }
}
function sum(mvalue) {
     str = document.getElementById("amount").value;
      var ta=document.getElementById('ta').value;
	  
	  alert(str);
	  alert(ta);
        var result = str + parseInt(ta);

	
	
        if(!isNaN(result)){
            document.getElementById('ta').value = result;
			
			
        }
}*/
 function addproduct() {
          
   // var username = document.getElementById("username");
    var pid = document.getElementById("pid");
    var price = document.getElementById("price");
	 var amount = document.getElementById("amount");
   var total1= document.getElementById("total1");
 
	  var nou = document.getElementById("nou");
	   var dname = document.getElementById("dname");
    var vno = document.getElementById("vno");
    var sdate = document.getElementById("sdate");
	  
	  
	 // var customer = document.getElementById("customer");
	   var vehicle = document.getElementById("vehicle");
	  var product = document.getElementById("product");
	  var price1 = document.getElementById("price1");
 //alert(price1);
 //str = parseInt(amount) + parseInt(total1);
 
 
 
	var table = document.getElementById("myTableData");
 if(pid.value!="" && price.value!="" && amount.value!="" && nou.value!=""  && dname.value!="" && vno.value !="" &&  sdate.value!="" ) {
    var rowCount = table.rows.length;
    var row = table.insertRow(rowCount);
	   var cell1 = row.insertCell(0);
            var element1 = document.createElement("input");
            element1.type = "checkbox";
            element1.name="chkbox[]";
            cell1.appendChild(element1);
   
  
   
    //row.insertCell(1).innerHTML='<input type="hidden" name="myname[]" value = "'+ username.value +'"  />' + customer.value;
	row.insertCell(1).innerHTML='<input type="hidden" name="dname[]" value = "'+ dname.value +'"  />' + dname.value;
    row.insertCell(2).innerHTML= '<input type="hidden" name="vno[]" value = "'+ vno.value +'"  />' + vehicle.value;
	row.insertCell(3).innerHTML= '<input type="hidden" name="sdate[]" value = "'+ sdate.value +'"  />' + sdate.value;
	row.insertCell(4).innerHTML='<input type="hidden" name="product[]" value = "'+ pid.value +'"  />' + product.value;
    row.insertCell(5).innerHTML= '<input type="hidden" name="pno[]" value = "'+ price.value +'"  />' + price1.value;
	row.insertCell(6).innerHTML= '<input type="hidden" name="units[]" value = "'+ nou.value +'"  />' + nou.value;
	row.insertCell(7).innerHTML= '<input type="hidden" name="amt[]" value = "'+ amount.value +'"  />' + amount.value;
row.insertCell(8).innerHTML= '<input type="hidden" name="total1[]" value = "'+ total1.value +'"  />' + total1.value;
    //row.insertCell(9).innerHTML= total1.value;
   
    //document.getElementById("username").value="";
  document.getElementById("pid").value="";
  document.getElementById("price").value="";
  document.getElementById("nou").value="";
  document.getElementById("amount").value="";
   document.getElementById("dname").value="";
 document.getElementById("vno").value="";
 //document.getElementById("sdate").value="";
 
 //<input type="button" value = "Delete"  class="btn-sm btn-danger" onClick="Javacsript:deleteRow(this)">
    
 }else{ alert ("Please enter the All Fields "); }
 
}
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
    	document.getElementById("billid").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","calbrsajax.php?bnumber="+str,true);
xmlhttp.send();

}
</script>

<script>
  function showCust1(mvalue)
{
	str = document.getElementById("vno").value;
	
	//alert(str);

if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  	xmlhttp1=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  	xmlhttp1=new ActiveXObject("Microsoft.XMLHTTP");
  }
	
	xmlhttp1.onreadystatechange=function()
  {
  if (xmlhttp1.readyState==4 && xmlhttp1.status==200)
    {
    	document.getElementById("vehicles").innerHTML=xmlhttp1.responseText;
    }
  }

xmlhttp1.open("GET","calbrsajax.php?vno="+str,true);
xmlhttp1.send();
//}

}
</script>

 <script>
  function calbrmenus(mvalue)
{
	str = document.getElementById("price").value;
	str1 = document.getElementById("nou").value;
	str2 = document.getElementById("count3").value;
//if (str!="" && str1!=""){
	//alert(str2);
//alert(str1);
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  	xmlhttp1=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  	xmlhttp1=new ActiveXObject("Microsoft.XMLHTTP");
  }
	
	xmlhttp1.onreadystatechange=function()
  {
  if (xmlhttp1.readyState==4 && xmlhttp1.status==200)
    {
    	document.getElementById("amounts").innerHTML=xmlhttp1.responseText;
    }
  }

xmlhttp1.open("GET","calbrsajax.php?price="+str+"&nou="+str1+"&count3="+str2,true);
xmlhttp1.send();
//}

}
</script>

  <script>
  function calbrmenu(mvalue)
{
	str = document.getElementById("pid").value;
	str1 = document.getElementById("sdate").value;
if (str!="" && str1!=""){
	

if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  	xmlhttp1=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  	xmlhttp1=new ActiveXObject("Microsoft.XMLHTTP");
  }
	
	xmlhttp1.onreadystatechange=function()
  {
  if (xmlhttp1.readyState==4 && xmlhttp1.status==200)
    {
    	document.getElementById("prices").innerHTML=xmlhttp1.responseText;
    }
  }

xmlhttp1.open("GET","calbrsajax.php?pid="+str+"&sdate="+str1,true);
xmlhttp1.send();
}

}
</script>
 <script>
  function nounits(mvalue)
{
	str = document.getElementById("pid").value;
	str1 = document.getElementById("nou").value;
if (str!="" && str1!=""){
	

if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  	xmlhttp2=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  	xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
  }
	
	xmlhttp2.onreadystatechange=function()
  {
  if (xmlhttp2.readyState==4 && xmlhttp2.status==200)
    {
    	document.getElementById("units").innerHTML=xmlhttp2.responseText;
    }
  }

xmlhttp2.open("GET","calbrsajax.php?pid="+str+"&nou="+str1,true);
xmlhttp2.send();
}

}
</script> 
</head>
 <body>
 	<!-- about-heading -->
	<div class="about-heading">
		<h2>BILL  <span>ENTRY</span></h2>
	</div>
	<!-- //about-heading -->
    
     <!-- choose -->
	<div class="choose jarallax">
  
		<div class="w3-agile-page">
			<div class="container">
              <div class="header">
              	<ul class="breadcrumb">
                	<li><a href="home.php">Home</a> </li>
                	<li class="active">Bill Entry</li>
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
                             <form  name="cform" method="post" action="creditcustomerbill.php" >
                                    
                                      <div class="col-sm-12 textalign labelalign"> BILL TYPE
                                       <Input type = 'Radio' Name='btype' value= 'CREDIT' <?php if($btype=="creditcustomer") { echo "checked"; } ?>>creditcustomer 
                                            <Input type = 'Radio' Name ='btype' value= 'CARD' <?php if($btype=="cardcustomer") { echo "checked"; } ?>>cardcustomer <input type="hidden"   name="sid" id="sid" value="<?php echo $psno; ?>" /></div>
                                          
                                          <div class="col-sm-3 textalign labelalign" >BILL NUMBER
										  <br>
										  <span id="billid">
                                       <input type= "text" class="form-control"  name="bnumber" id="bnumber" placeholder="Bill Number"  maxlength="100"  onkeypress="return isNumberKey(event)"  value="<?php echo $bnumber; ?>" onblur="getTimecustomer(this.value);"/> </span> </div>
                                          <div class="col-sm-3 textalign labelalign">CARD HOLDER NAME
                        <input type= "text" class="form-control"  name="chname" id="chname" placeholder="Card Holder Name"  maxlength="100"  onkeypress="return checkNum(event)"  value="<?php echo $chname; ?>" />
                                          </div>
                                           <div class="col-sm-3 textalign labelalign"> CUSTOMER NAME
                                      <select class="form-control"  name="username" id="username"  maxlength="80"  onkeypress="return pfNumberKey(event)" > 
                                         
                                              <option value="">--Select--</option>
                           <?php 
                           $sqlquery2 = "select `credit_customer_code`,`credit_customer_name` from `credit_customer_master`";
                           $queryresult2 = mysql_query($sqlquery2) or die("Query failed --1");
                           while ($row2 = mysql_fetch_array($queryresult2))
                         {
                        if($username==$row2["credit_customer_code"]) $dselval="selected";
                           else  $dselval=" ";
                       echo  "<option value='".$row2["credit_customer_code"]."' $dselval >".$row2["credit_customer_name"]."</option>" ;
                       } 
                      ?> </select> </div>
					  <div class="col-sm-3 textalign labelalign">BILL DATE
                                     <input type= "text" class="form-control"  name="sdate"  id="sdate"  placeholder="DD/MM/YYYY" maxlength="25"  onBlur="return ValidateForm()"  value="<?php echo $sdate; ?>" /></div>
                                      					  
					  
					   <div class="col-sm-3 textalign labelalign"> DRIVER NAME
                       <input type= "text" class="form-control"  name="dname" id="dname" placeholder="Driver Name"   maxlength="100"  onkeypress="return checkNum(event)"  value="<?php echo $dname; ?>" /> 
                                          </div>
					  
						<div class="col-sm-3 textalign labelalign"> VEHICLE NUMBER
                                      <select class="form-control"  name="vno" id="vno"  maxlength="80"  onkeypress="return pfNumberKey(event)" onchange="showCust1(this.value);">
                          <option value="">--Select--</option>
                           <?php 
                           $sqlquery2 = "select `cc_s_id`,`cc_vehicle_no`  from `creditcustomer_vechicle_master`";
                           $queryresult2 = mysql_query($sqlquery2) or die("Query failed --1");
                           while ($row2 = mysql_fetch_array($queryresult2))
                         {
                        if($vno==$row2["cc_s_id"]) $dselval="selected";
                           else  $dselval=" ";
                       echo  "<option value='".$row2["cc_s_id"]."' $dselval >".$row2["cc_vehicle_no"]."</option>" ;
                       } 
                      ?>  </select></div>   

							

										 <div class="col-sm-3 textalign labelalign"> CHOOSE PRODUCT
                        <select class="form-control"  name="pid" id="pid"  maxlength="80"  onkeypress="return pfNumberKey(event)"  onchange="calbrmenu(this.value)" >
                          <option value="">--Select--</option>
                           <?php 
                           $sqlquery2 = "SELECT `s_id`,`produt_name` FROM `product_master` WHERE `status`='A'";
						   
                           $queryresult2 = mysql_query($sqlquery2) or die("Query failed --1");
                           while ($row2 = mysql_fetch_array($queryresult2))
                         {
                        if($pid==$row2["s_id"]) $dselval="selected";
                           else  $dselval=" ";
                       echo  "<option value='".$row2["s_id"]."' $dselval >".$row2["produt_name"]."</option>" ;
                       } 
                      ?>  </select></div>
					  
                          
                                         
                                          <div class="col-sm-3 textalign labelalign">PRICE
                                        <span id="prices"> <select class="form-control"  name="price" id="price"  maxlength="80"  onkeypress="return pfNumberKey(event)" ><br>
                          <option value="">--Select--</option>
                           <?php 
                           $sqlquery2 = "SELECT `s_id`,`price` FROM `price_master` WHERE `item_code`='".$pid."' and `price_date`<='".$sdate."' and `status`='A'  ORDER BY `price_date` DESC LIMIT 1";
						   //echo $sqlquery2;
                           $queryresult2 = mysql_query($sqlquery2) or die("Query failed --1");
                           while ($row2 = mysql_fetch_array($queryresult2))
                         {
                        if($price==$row2["s_id"]) $dselval="selected";
                           else  $dselval=" ";
                       echo  "<option value='".$row2["s_id"]."' $dselval >".$row2["price"]."</option>" ;
					   //echo '<input type="hidden" class="form-control"  name="price1" id="price1" value="'. $row2["price"] .'"';
                        }
						
						
                      ?></select> 
					  <input type="hidden" class="form-control"  name="pqty" id="pqty" value="" />
					  </span>
					  </div>
                                          <div class="col-sm-3 textalign labelalign"> NUMBER OF UNITS
                       <span id="units"> <input type="text" class="form-control"  name="nou" id="nou" placeholder="Quantity" maxlength="100" onblur="calbrmenus(this.value);nounits(this.value);"  onKeyPress="return isNumberKey(event)"  value="<?php echo $nou; ?>" /> 
                                      </span>    
										  </div>
                                           <div class="col-sm-3 textalign labelalign"> AMOUNT
                                    <span id="amounts"><input type= "text" class="form-control"  name="amount" id="amount" placeholder=" Amount"   maxlength="100"  onkeypress="return pfNumberKey(event)"  value="<?php echo $amount; ?>" /> </span>
                              <?php if ($amount==""){?>  <input type= "hidden" class="form-control"  name="count3" id="count3"  value="<?php echo $counts; ?>" /><?php }?>
                                     <!--<input type= "hidden" name="ta" id="ta" value="<?php //echo $amount; ?>" /> -->
									</div>
									<div class="col-sm-3 textalign labelalign">  STATUS
                                           <select class="form-control"  name="status" id="status">
                                                <option value="A" <?php echo $status1; ?>>Active</option>
                                                <option value="I" <?php echo $status2; ?>>InActive</option>
                                               </select> 
                                        </div>
										 <div class="col-sm-12" align="center"> 
										<input type="button"  id="add" value="Add" class="btn-sm btn-primary" onClick="javascript:addproduct()">
<button type="reset" class="btn-sm btn-primary">clear</button></div>
                               <span id="vehicles"> </span>           <br /><br />
<br />
  <table id="myTableData"  class="form" border="1" width="100%">
                  <tbody>
                  <tr>
              		<td  width="3%">S.No</td>
					
					<td  width="13%">DRIVER NAME</td>
					<td  width="8%">VEHICLE NO</td>
					<td  width="14%">BILL DATE</td>
						 <td  width="9%">PRODUCT </td>
						 <td  width="7%"> PRICE </td>
						 <td  width="7%"> NOOFUNITS </td>
                        <td  width="7%">AMOUNT </td>
						<td  width="15%"> TOTAL AMOUNT </td>
                         </tr>
                
                     </tbody>
                </table>

                                          <div class="col-sm-12" align="center"> 
                                   <button class="btn1" id="submit" type="submit">Submit</button>
                                   </div>
                 </form>
						</div>
 <?php
  if(isset($_POST['product']))
		 {
	 
          
		
		 	
			$DDate = Date("Y-m-d");   
	$TTime = Time();
	
	//$status='A';
	 
	
    if($error==""){
	 $userid = $_SESSION['USER_ID'];
	
			if ((isset($_POST['product'])) && (isset($_POST['pno'])) && (isset($_POST['amt']))  && (isset($_POST['units']))) {
					
					$arrMyCheckbox  = $_POST['dname'];
					$arrMyCheckbox1  = $_POST['vno'];
					$arrMyCheckbox2  = $_POST['sdate'];
		 			$arrMyCheckbox3  = $_POST['product'];
					$arrMyCheckbox4  = $_POST['pno'];
					$arrMyCheckbox5  = $_POST['units'];
					$arrMyCheckbox6  = $_POST['amt'];
					$arrMyCheckbox7  = $_POST['total1'];
					
					$username  = $_POST['username'];
					$btype  = $_POST['btype'];
					$chname  = $_POST['chname'];
						$bnumber  = $_POST['bnumber'];
						$status   =  $_POST['status'];
					 $userid =  htmlentities($_SESSION['USER_ID']);  
					$total  = 0;
					//echo 'hfjdhfj'.$username;
			$totals=0;			
					 
		 $sql_inser1= "insert into bill_entry(bill_number,bill_type,cardholder_name,credit_customer_code,bill_amount,bill_created_user_id,`c_date`, `status`) values('$bnumber','$btype','$chname','$username','$total','$userid',now(),'$status')";
	
	//echo $sql_inser1;
	$resultsa = mysql_query($sql_inser1);
			if($resultsa)	{
				$query4= "SELECT bill_no FROM bill_entry where bill_number='$bnumber'";
//echo $query4;
 $resultf=mysql_query($query4);
 $rowk = mysql_fetch_array($resultf);
 $bno1=$rowk["bill_no"];
		
			for ($i=0; $i<count($arrMyCheckbox); $i++) {
				
 					if(($arrMyCheckbox[$i]!="")&&($arrMyCheckbox1[$i]!="")&&($arrMyCheckbox2[$i]!="")&&($arrMyCheckbox3[$i]!="")&&($arrMyCheckbox4[$i]!="")&&($arrMyCheckbox5[$i]!="")&&($arrMyCheckbox6[$i]!=""))
					{
				
				$sdate = $arrMyCheckbox2[$i];
		$datem=(explode(" ",$sdate ));
		$msdate=implode(array_reverse(explode("/",$datem[0])),"-");
		$sdate=$msdate." ".$datem[1];
				$mydress=$arrMyCheckbox5[$i];
			
				$sql_inser= "insert into bill_detail_entry( bill_no,vehicle_code,vehicle_driver_name,bill_date,item_code,price,item_quantity,amount,c_user,c_date,status) values('$bno1','".$arrMyCheckbox1[$i]."','".$arrMyCheckbox[$i]."','$sdate','".$arrMyCheckbox3[$i]."','".$arrMyCheckbox4[$i]."','".$arrMyCheckbox5[$i]."','".$arrMyCheckbox6[$i]."','$userid',now(),'$status')";
					//echo $sql_inser;	
					$resultsa = mysql_query($sql_inser);
					if($resultsa){
						$totals=$totals+$arrMyCheckbox6[$i];
						//echo $totals."==".$arrMyCheckbox6[$i]."<br>";
						$skmi="update product_master set product_quantity=product_quantity-".$mydress." where `s_id`='".$arrMyCheckbox3[$i]."'";
						$resultse = mysql_query($skmi);

					}
			
					}
			}
				$sqlqurr="update bill_entry set bill_amount=".$totals." where `bill_no`='".$bno1."'";
				//echo $sqlqurr;
						$results = mysql_query($sqlqurr);
			
			}	
				
				
		
		 
			}///if 
	}else{  echo 'Please Enter All Mandatory';}//if error
					
            }
			?>
                                  
                 
                   <br />
                         <div class="col-sm-12">
        <div class="panel panel-default">
        <div class="panel-body ">    <?php echo $sd = ccustomerbillgrid(); ?>      </div>
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
$('#sdate').datetimepicker({
dayOfWeekStart : 1,
lang:'en', 
startDate:	'1986/01/05'
});
$('#sdate').datetimepicker({ step:1});


</script>
 <?php require_once("footer.php"); ?>
 </html>