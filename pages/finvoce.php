<?php
ob_start();
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';
include_once 'function/fpuchesorderfunctions.php';
require_once("header.php");
 
 sec_session_start();

if (login_check() == true) {
    $logged = 'in';
} else {
    $logged = 'out'; header("Location:../includes/logout.php");
}
$counts="0";
?>
<!DOCTYPE html>
<html>
    <head> 
	<link rel="stylesheet" href="datepickertime1/jquery.datetimepicker.css" /> 

 
<script> 
function equalto()
{
	var tamount  = document.getElementById("tamount").value;
	//alert(tamount);
	var count3  = document.getElementById("count3").value;
	//alert(count3);
	 if (tamount == count3)
	 {
		
	 }

else if(tamount != count3 )
{
		alert("Please Equal to the Invoice Amount");
		return false;
}
}

function addbook() {

 var fpid  = document.getElementById("fpid");
// var cat  = document.getElementById("cat");

 var model  = document.getElementById("model");
 var qnty  = document.getElementById("qnty");
 var price  = document.getElementById("price");
 //alert('qnty');
 var product= document.getElementById("product");
  var total  = qnty.value*price.value; 
//alert(total);
  //document.getElementById("total");
 var count3= document.getElementById("count3").value; 
 //alert(count3);
 //alert(total);
 
 var counts=parseInt(count3)+parseInt(total);
 //alert(counts);
 
 if(counts!='0'){
	 
	 document.getElementById("myTablecount").style.display='block';
 }
document.getElementById("countvariable").innerHTML=counts;
document.getElementById("count3").value=counts;
 
    var table = document.getElementById("myTable");
	
    if(fpid.value!=""  && qnty.value!="" && price.value!="") {
    var rowCount = table.rows.length;
    var row = table.insertRow(rowCount);
	var cell1 = row.insertCell(0);
    var element1 = document.createElement("input");
    element1.type = "checkbox";
	element1.checked="true";
    element1.name="chkbox[]";
    cell1.appendChild(element1);
 
   
    row.insertCell(1).innerHTML=' <input type="hidden" name="ifpid[]" value = "'+ fpid.value +'" />' + product.value;  
	//row.insertCell(2).innerHTML='<input type="hidden" name="icat[]" value = "'+  cat.value +'" />' + category.value;   
	
	row.insertCell(2).innerHTML= '<input type="hidden" name="imodel[]" value = "'+ model.value +'" />' + model.value;  
	row.insertCell(3).innerHTML=' <input type="hidden" name="iqnty[]" value = "'+ qnty.value +'" />' + qnty.value;  
	row.insertCell(4).innerHTML=' <input type="hidden" name="iprice[]" value = "'+ price.value +'" />' + price.value;
	row.insertCell(5).innerHTML= total;  	   
	
	  
  
 //<input type="button" value = "Delete"  class="btn-sm btn-danger" onClick="Javacsript:deleteRow(this)">
document.getElementById("fpid").value="";
//document.getElementById("cat").value="";
//document.getElementById("fup").value="";
 document.getElementById("model").value="";
document.getElementById("qnty").value="";
document.getElementById("price").value="";
document.getElementById("product").value="";
//document.getElementById("category").value="";
 }else{ alert ("Please Enter all mandatory fields"); }
 
}
 function deleteRow(myTable) {
            try {
            var table = document.getElementById(myTable);
            var rowCount = table.rows.length;

            for(var i=0; i<rowCount; i++) {
                var row = table.rows[i];
                var chkbox = row.cells[0].childNodes[0];
                if(null != chkbox && true == chkbox.checked) {
					//alert(row.cells[5].value);
					var counted= document.getElementById("count3").value; 
					//alert(counted);
					var rowCount=row.cells[5].innerHTML;
					//alert(rowCount);
					var counts=parseInt(counted)-parseInt(rowCount);
					//alert(counts);
					 document.getElementById("countvariable").innerHTML=counts;
					document.getElementById("count3").value=counts;
                    table.deleteRow(i);
                    rowCount--;
                    i--;
                }

            }
            }catch(e) {
                //alert("");
            }
        }

</script>

<script>
  function showpro(mvalue)
{
	str = mvalue;
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
    	document.getElementById("pros").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","calbrsajax.php?fpid="+str,true);
xmlhttp.send();
}
</script>

<script>
 /* function products(mvalue)
{
	str = document.getElementById("price").value;
	str1 = document.getElementById("count3").value;
	str2 = document.getElementById("qnty").value;
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
    	document.getElementById("propri").innerHTML=xmlhttp.responseText;
		
    }
  }
xmlhttp.open("GET","calbrsajax.php?price="+str+"&count3="+str1+"&qnty="+str2,true);
xmlhttp.send();
}*/
</script>
</head>
<body> 
   
 <!-- about-heading -->
	<div class="about-heading">
		<h2>PURCHASE  <span>MASTER</span></h2>
	</div>
	<!-- //about-heading -->
    
     <!-- choose -->
	<div class="choose jarallax">
  
		<div class="w3-agile-page">
			<div class="container">
              <div class="header">
              	<ul class="breadcrumb">
                	<li><a href="home.php">Home</a> </li>
                	<li class="active">Purchase Master</li>
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
        
        
              <form  name="cform" method="post" action="finvoce.php"  onsubmit="equalto();">
                           
                   <div class="col-sm-3 textalign labelalign">VENDER NAME 
                                           <select class="form-control"  name="vname"  id="vname" required >
                                         <option value="0">-- Select --</option>
                                      <?php 
				$sqlquery2 = "SELECT `s_id`,`vender_name` FROM `vender_master` WHERE status='A' order by vender_name";
	        $queryresult2 = mysql_query($sqlquery2) or die("Query failed --delars");
  			 
								while ($row2 = mysql_fetch_array($queryresult2))
  								{
									if($vname==$row2["s_id"]) $dselval="selected";
									else  $dselval=" ";
									echo  "<option value='".$row2["s_id"]."' $dselval >".$row2["vender_name"]."</option>" ;
								} 
								?>   
                                         
                     </select>
					 </div>
					 <div class="col-sm-3 textalign labelalign">INVOICE ID 
                       <input type="text" class="form-control" name="invoiceid" id="invoiceid" placeholder="Invoice Id" maxlength="50" required onKeyPress="return pfNumberKey(event)"  value="<?php echo $invoiceid; ?>" /><input type="hidden"   name="sid" id="sid" value="<?php echo $psno; ?>" />
                      </div>
                               
                       <div class="col-sm-3 textalign labelalign">AUTHORIZED BY
                           <input type="text" class="form-control"   name="authorized_by" id="authorized_by" placeholder="Authorized by" maxlength="50" required  onkeypress="return pfNumberKey(event)"  value="<?php echo $authorized_by; ?>" /> 
                       </div>           
                          
 <div class="col-sm-3 textalign labelalign">INVOICE AMOUNT
                        <input type="text" class="form-control"  name="tamount" id="tamount" placeholder="Invoice Amount" maxlength="50" required onKeyPress="return pfNumberKey(event)"  value="<?php echo $tamount; ?>" />  </div>                 
                     <div class="col-sm-3 textalign labelalign"> PROCURED DATE (or) TRANSFERED DATE 
                      <input type="text" class="form-control"  name="invcedate"  id="invcedate"   placeholder="DD/MM/YYYY" maxlength="10"  onkeypress="return datecheckNum(event)" onKeyUp="addSlashes(this)" onBlur="isDate(this.value)" value="<?php echo $invcedate; ?>" required />  </div>
                                 
                      <div class="col-sm-3 textalign labelalign"> DATE OF AUTHORIZED 
                      <input type="text" class="form-control"  name="recivdate" id="recivdate"   placeholder=" DD/MM/YYYY" maxlength="10"  onkeypress="return datecheckNum(event)" onKeyUp="addSlashes(this)" onBlur="isDate(this.value)" value="<?php echo $recivdate; ?>" required />  </div>
					  
					  
					  
                   <div class="col-sm-12 textalign labelalign"> DESCRIPTION 
                     <textarea class="form-control"  name="desc" id="desc" rows="2" ><?php echo $desc;?></textarea>	
                </div>                                                  
				<div class="col-sm-3 textalign labelalign">PRODUCT ID
                                         <select class="form-control"   name="fpid"  id="fpid" onChange="showpro(this.value)">
                                                                       <option value="">--Select--</option>
                                                  <?php 
                                            $sqlquerym = "SELECT `s_id`,`produt_name` FROM `product_master` WHERE  status='A' order by produt_name";	        	
                                           
											$queryresultm = mysql_query($sqlquerym) or die("Query failed --Category Menu");
                                         
                                                            while ($rowm = mysql_fetch_array($queryresultm))
                                                            {
                                                                if($fpid==$rowm["s_id"]) $dselval="selected";
                                                                else  $dselval=" ";
                                                                echo  "<option value='".$rowm["s_id"]."' $dselval >".$rowm["produt_name"]."</option>" ;
                                                            } 
                                                            ?>
                                   </select><span id="pros"></span>
                           	  </div>                
                          
                                 
                                 
                            <div class="col-sm-3 textalign labelalign">QUANTITY
                                 <input type="text" class="form-control"    name="qnty" id="qnty" placeholder="Quantity" maxlength="50"  onkeypress="return isNumberKey(event)"  value="<?php echo $qnty; ?>"/>
								   <input type="hidden" class="form-control"    name="count3" id="count3"   value="<?php echo $counts; ?>"/> 
								 </div> 
                                     
                                 
                                <div class="col-sm-3 textalign labelalign"> PRODUCT PRICE
                                 <input type="text" class="form-control"  name="price"   id="price" placeholder="Price" maxlength="50"  onkeypress="return isNumberKey(event)"  value="<?php echo $price; ?>" />
								 </div>
                                  
								   <div class="col-sm-3 textalign labelalign">MODEL
                                <input type="text" class="form-control"  name="model" id="model" placeholder="Model Name" maxlength="80"  onkeypress="return pfNumberKey(event)"  value="<?php echo $model; ?>" /></div> 
								  
								  <div class="col-sm-3 textalign labelalign">  STATUS
                                           <select class="form-control"  name="status" id="status">
										   
                                                <option value="A" <?php echo $status1; ?>>Active</option>
                                                <option value="I" <?php echo $status2; ?>>InActive</option>
                                               </select> 
                                        </div>
                                  
                        
       <div class="col-sm-12" align="center">
       <input type="button" id="add" value="Add"  class="btn-sm btn-primary" onClick="addbook()">
       <input type="button" id="delete" value="Delete"  class="btn-sm btn-primary"  onClick="deleteRow('myTable')"/>
         </div>
         
        <br /><br />
<br />
  <table id="myTable"  class="form" border="1" width="100%">
                  <tbody>
                  <tr>
       
          <td  width="5%">S.No</td>
		<td  width="30%"> Product Name</td>
          <td  width="20%"> Model</td>
          <td  width="15%"> Quantity</td>
          <td  width="15%"> Product Price</td>
          <td  width="15%"> Total</td>
          </tr>
      </tbody>
    </table>
    <table id="myTablecount"  class="form" border="0" width="100%" align="right" style="display:none;float:right">
                  <tbody>
                  <tr>
       
          <td  width="5%"></td>
		<td  width="30%"> </td>
          <td  width="20%"> </td>
         
          <td  width="15%" > Totals</td> <td  width="15%">&nbsp; </td>
          <td  width="15%"  id="countvariable"></td>
          </tr>
      </tbody>
    </table>
                            
                                          <div class="col-sm-12" align="center"> 
                                   <button class="btn1" id="submit" type="submit" >Submit</button>
                                   </div>
                 </form>
						</div>
						
						
						<?php
  if(isset($_POST['vname']))
		 {
	 $DDate = Date("Y-m-d");   
	$TTime = Time();
	
	//$status='A';
	 
	if($error==""){
	 $userid = $_SESSION['USER_ID'];
	
			if ((isset($_POST['ifpid']))  && (isset($_POST['iqnty']))  && (isset($_POST['iprice']))) {
					
					 $arrMyCheckbox = $_POST['ifpid'];
					 $arrMyCheckbox1  = $_POST['imodel'];
					 $arrMyCheckbox2  = $_POST['iqnty'];
					 $arrMyCheckbox3  = $_POST['iprice'];
					
			$count3 =$_POST[count3]	;	
			$vname =$_POST['vname'];
			$invoiceid =$_POST['invoiceid'];
			
			$invcedate= $_POST['invcedate'];
			$datem=(explode(" ",$invcedate ));
			$msdate=implode(array_reverse(explode("/",$datem[0])),"-");
			$invcedate=$msdate." ".$datem[1];
			
			$recivdate= $_POST['recivdate'];
			$datem=(explode(" ",$recivdate ));
			$msdate=implode(array_reverse(explode("/",$datem[0])),"-");
			$recivdate=$msdate." ".$datem[1];
			
			$authorized_by =$_POST['authorized_by'];
			$tamount =$_POST['tamount'];
			$desc = $_POST['desc'];
			 $status   =  $_POST['status'];
			$userid =  htmlentities($_SESSION['USER_ID']);
			//$sid =  $_POST['sid'];
					
					if ($vname!="" && $invoiceid!="" && $invcedate!="" && $recivdate!="" &&$tamount!="" &&$authorized_by!="" ) {  
					/*$total  = 0;
					echo 'hfjdhfj'.$username;
			$totals=0;	*/	

				if ($tamount == $count3)
	 {
			
					 
		 $sql_inser1= "INSERT INTO `purches_master`(`invoice_id`, `procure_date`, `date_of_authorised`, `authorized_by`, `invoice_amount`, `description`, `USER_ID`, `created_date`, `status`) VALUES ('$invoiceid','$invcedate','$recivdate','$authorized_by','$tamount','$desc','$userid',now(),'$status')";
	
	//echo $sql_inser1;
	$resultsa = mysql_query($sql_inser1);
			if($resultsa)	{
				$query4= "SELECT s_id FROM purches_master where invoice_id='$invoiceid'";
//echo $query4;
 $resultf=mysql_query($query4);
 $rowk = mysql_fetch_array($resultf);
 $pno1=$rowk["s_id"];
		
			for ($i=0; $i<count($arrMyCheckbox); $i++) {
				
 					if(($arrMyCheckbox[$i]!="")&&($arrMyCheckbox2[$i]!="")&&($arrMyCheckbox3[$i]!=""))
					{
				
				/*$sdate = $arrMyCheckbox2[$i];
		$datem=(explode(" ",$sdate ));
		$msdate=implode(array_reverse(explode("/",$datem[0])),"-");
		$sdate=$msdate." ".$datem[1];*/
				$mydress=$arrMyCheckbox2[$i];
			
				$sql_inser= "INSERT INTO `purches_master_items`(`purch_mast_id`, `product_id`, `vender_id`, `product_qty`, `model`, `product_price`, `USER_ID`, `created_date`, `status`) VALUES ('$pno1','".$arrMyCheckbox[$i]."','$vname','".$arrMyCheckbox2[$i]."','".$arrMyCheckbox1[$i]."','".$arrMyCheckbox3[$i]."','$userid',now(),'$status')";
					//echo $sql_inser;	
					$resultsa = mysql_query($sql_inser);
					if($resultsa){
						//$totals=$totals+$arrMyCheckbox6[$i];
						//echo $totals."==".$arrMyCheckbox6[$i]."<br>";
						$skmi="update product_master set product_quantity=product_quantity+".$mydress." where `s_id`='".$arrMyCheckbox[$i]."'";
						//echo $skmi;
						$resultse = mysql_query($skmi);

					}
			
					}
			}
				/*$sqlqurr="update bill_entry set bill_amount=".$totals." where `bill_no`='".$bno1."'";
				//echo $sqlqurr;
						$results = mysql_query($sqlqurr);*/
			
			}else{  echo 'Please Enter All Mandatory';}
	 }
					
		else if ($tamount != $count3)
	 {				
	 }	
					
				else {
					
					$sql_inser1= "INSERT INTO `purches_master`(`invoice_id`, `procure_date`, `date_of_authorised`, `authorized_by`, `invoice_amount`, `description`, `USER_ID`, `created_date`, `status`) VALUES ('$invoiceid','$invcedate','$recivdate','$authorized_by','$tamount','$desc','$userid',now(),'$status')";
	
	//echo $sql_inser1;
	$resultsa = mysql_query($sql_inser1);
			if($resultsa)	{
				$query4= "SELECT s_id FROM purches_master where invoice_id='$invoiceid'";
//echo $query4;
 $resultf=mysql_query($query4);
 $rowk = mysql_fetch_array($resultf);
 $pno1=$rowk["s_id"];
		
			for ($i=0; $i<count($arrMyCheckbox); $i++) {
				
 					if(($arrMyCheckbox[$i]!="")&&($arrMyCheckbox2[$i]!="")&&($arrMyCheckbox3[$i]!=""))
					{
				
				/*$sdate = $arrMyCheckbox2[$i];
		$datem=(explode(" ",$sdate ));
		$msdate=implode(array_reverse(explode("/",$datem[0])),"-");
		$sdate=$msdate." ".$datem[1];*/
				$mydress=$arrMyCheckbox2[$i];
			
				$sql_inser= "INSERT INTO `purches_master_items`(`purch_mast_id`, `product_id`, `vender_id`, `product_qty`, `model`, `product_price`, `USER_ID`, `created_date`, `status`) VALUES ('$pno1','".$arrMyCheckbox[$i]."','$vname','".$arrMyCheckbox2[$i]."','".$arrMyCheckbox1[$i]."','".$arrMyCheckbox3[$i]."','$userid',now(),'$status')";
					//echo $sql_inser;	
					$resultsa = mysql_query($sql_inser);
					if($resultsa){
						//$totals=$totals+$arrMyCheckbox6[$i];
						//echo $totals."==".$arrMyCheckbox6[$i]."<br>";
						$skmi="update product_master set product_quantity=product_quantity+".$mydress." where `s_id`='".$arrMyCheckbox[$i]."'";
						//echo $skmi;
						$resultse = mysql_query($skmi);

					}
			
					}
			}
				/*$sqlqurr="update bill_entry set bill_amount=".$totals." where `bill_no`='".$bno1."'";
				//echo $sqlqurr;
						$results = mysql_query($sqlqurr);*/
			
			}
					
					
				}	}			
			}///if 
	}else{  echo 'Please Enter All Mandatory';}//if error
					
            }
			?>
						
						
						
						
          
 <br />
                         <div class="col-sm-12">
        <div class="panel panel-default">
      
                      <div class="panel-body ">   <?php echo $sd = frachpurchesgrid(); ?> </div>
               </div></div>
					</div>
					<div class="clearfix"> </div>
				</div>
                
			</div>
         
	</div>
 
  
                     
    </body>                 
  <script src="datepickertime1/jquery.js"></script>
<script src="datepickertime1/jquery.datetimepicker.full.js"></script>
<script type = "text/javascript">

$.datetimepicker.setLocale('en');
$('#invcedate').datetimepicker({
dayOfWeekStart : 1,
lang:'en', 
startDate:	'1986/01/05'
});
$('#invcedate').datetimepicker({ step:1});

$('#recivdate').datetimepicker({
dayOfWeekStart : 1,
lang:'en', 
startDate:	'1986/01/05'
});
$('#recivdate').datetimepicker({ step:1});


</script>
 <?php require_once("footer.php"); ?>
</html>
