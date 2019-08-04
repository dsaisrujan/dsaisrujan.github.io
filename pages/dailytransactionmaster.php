<?php 
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';
include_once 'function/dailytransfunction.php';
require_once("header.php");

sec_session_start();

if (login_check() == true) {
    $logged = 'in';
} else {
    $logged = 'out'; header("Location:../includes/logout.php");
}

if(!empty($_GET["icode"])){  $icode = $_GET["icode"];  }
if(!empty($_GET["edm"])){  $edm = $_GET["edm"];  }
$psno = $desc= $status1= $status2="";
	
if($icode!=""){
	   if((!empty($edm)) && ($edm=="del")){   
		     $del_qry = "DELETE FROM daily_transactions WHERE trim(s_id)=trim('".$icode."')";
			 //echo $del_qry ;
			 $result = mysql_query($del_qry);
	  	}
	 
if((!empty($edm)) && ($edm=="edit")){   
	$select_query =  "SELECT `s_id`, `description`, `amount`, `amount_type`, `date_of_received`,DATE_FORMAT(date_of_received,'%d/%m/%Y %H:%m:%s') as date_of_received1, `type_of_customer`, `credit_customer_no`, `payment_mode`, `dd_cq_date`,DATE_FORMAT(dd_cq_date,'%d/%m/%Y %H:%m:%s') as dd_cq_date1, `bank`, `branch`, `ifsc_code`, `cc_no`, `user_id`, `c_date`, `status` FROM `daily_transactions` WHERE `s_id`='".$icode."'";
//echo  $select_query ;
	$resultk = mysql_query($select_query);

	while ($rowk = mysql_fetch_array($resultk)) {
			if($rowk["status"]=="A") $status1="selected";
			if($rowk["status"]=="I") $status2="selected";
			$psno = $rowk["s_id"];
			$desc = $rowk["description"]; 
			$amount = $rowk["amount"];
			$amtype = $rowk["amount_type"];
			$date = $rowk["date_of_received1"];
			$toc = $rowk["type_of_customer"];
			$ccno = $rowk["credit_customer_no"];
			$pm = $rowk["payment_mode"];
			$dcdate= $rowk["dd_cq_date1"];
			//echo $dcdate;
			 $bank = $rowk["bank"];
			 $branch = $rowk["branch"];
			 $ifsc = $rowk["ifsc_code"];
			 $ccno1 = $rowk["cc_no"];
		  }
		
	}
	}
	
	
	?>
	
	
 <!DOCTYPE html>
<html>
<head> 

<script type="text/javascript" language="javascript">
  function onCustomer() {
 var customer = document.getElementById("toc").value;
// alert (reason);
 if (customer == "CC" ) {
	document.getElementById("customer1").style.display = 'block';
	
	}
 else {
	document.getElementById("customer1").style.display = 'none';
	
}

 }
 
 
 function onReasonSelected() {
 var reason = document.getElementById("pm").value;
// alert (reason);
 if (reason == "2" || reason == "3" || reason == "4") {
	document.getElementById("dd_cheque").style.display = 'block';
	
	}
 else {
	document.getElementById("dd_cheque").style.display = 'none';
	
}

 }
 
 
function functionrequired() {
	var pm = document.getElementById("pm").value;

 var reason = document.getElementById("dcdate").value;
 var reason1 = document.getElementById("bank").value;
 var reason2 = document.getElementById("branch").value;
 var reason3 = document.getElementById("ifsc").value;
 var reason4 = document.getElementById("ccno1").value;

 if (pm == "2")
 {
	 if(reason=="" ){
		 alert("please enter the dd and cheque date");
 return false;
	 }
	 if(reason1=="" ){
		 alert("please enter the bank name");
 return false;
	 }
	 if(reason2=="" ){
		 alert("please enter the branch name");
 return false;
	 }
	 if(reason3=="" ){
		 alert("please enter the IFSC code");
 return false;
	 }
	 if(reason4=="" ){
		 alert("please enter the check Number");
 return false;
	 }
	 
 }
else if(pm == "3" ) {
	if(reason=="" ){
		 alert("please enter the dd and cheque date");
 return false;
	 }
	 if(reason1=="" ){
		 alert("please enter the bank name");
 return false;
	 }
	 if(reason2=="" ){
		 alert("please enter the branch name");
 return false;
	 }
	 if(reason3=="" ){
		 alert("please enter the IFSC code");
 return false;
	 }
	 if(reason4=="" ){
		 alert("please enter the check Number");
 return false;
	 }
		
		
}
else if ( pm == "4") {
	
	if(reason=="" ){
		
	 }
	 if(reason1=="" ){
		
	 }
	 if(reason2=="" ){
		 
	 }
	 if(reason3=="" ){
		
	 }
	 if(reason4=="" ){
		 alert("please enter the check Number");
 return false;
	 }
}
}
  
</script>

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
 
<link rel="stylesheet" href="datepickertime/jquery.datetimepicker.css" /> 

</head>
<body>
 	<!-- about-heading -->
	<div class="about-heading">
		<h2>DAILY TRANSACTION  <span>MASTER</span></h2>
	</div>
	<!-- //about-heading -->
    
     <!-- choose -->
	<div class="choose jarallax">
  
		<div class="w3-agile-page">
			<div class="container">
              <div class="header">
              	<ul class="breadcrumb">
                	<li><a href="home.php">Home</a> </li>
                	<li class="active">Daily Transaction Master</li>
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
                             <form  name="cform" method="post" action="dailytransactionmaster.php"  enctype='multipart/form-data'>
                                    
                                      <div class="col-sm-12 textalign labelalign">  DESCRIPTION
		<textarea class="form-control"  name="desc" id="desc" rows="2" ><?php echo $desc;?></textarea>	
		<input type="hidden"   name="sid" id="sid" value="<?php echo $psno; ?>" />
                                           </div>
										   <div class="col-sm-3 textalign labelalign" id="uid">AMOUNT
                                          <input type="text" class="form-control"  name="amount" id="amount" placeholder="Amount" maxlength="50"  onkeypress="return checkNum(event)" value="<?php echo $amount; ?>"  />
                                           </div>
										  <div class="col-sm-3 textalign labelalign" > AMOUNT TYPE 
                                          <select class="form-control"  name="amtype" id="amtype"   >
                                           <option value="0">--Select--</option>
		<option value="Credit" <?php if($amtype=="Credit") echo "selected";?>>Credit</option>
		<option value="Debit" <?php if($amtype=="Debit") echo "selected";?>>Debit</option>	
									</select></div>
											
											<div class="col-sm-3 textalign labelalign" onChange="onCustomer();">  TYPE OF CUSTOMER
											<select class="form-control"  name="toc" id="toc" >
                                           <option value="0">--Select--</option>
				<option value="CC" <?php if($toc=="CC") echo "selected";?>>Credit Customer</option>
				<option value="G" <?php if($toc=="G") echo "selected";?>>General</option>	
											</select>
                                          </div> 
                                          <div class="col-sm-3 textalign labelalign">  DATE OF RECEIVED
                                         <input type="text" class="form-control"  name="date" id="date" placeholder="DD/MM/YYYY HH/MM/SS" maxlength="50"  onkeypress="return pfNumberKey(event)"  value="<?php echo $date; ?>" />  </div>
                                          
										  <div class="col-sm-3 textalign labelalign" id="customer1" <?php if($toc=="CC"){ echo "style='display:block;'"; }else{  echo "style='display:none ;'";}?>> CREDIT CUSTOMER NUMBER
                                      <select class="form-control"  name="ccno" id="ccno"  maxlength="80"  onkeypress="return pfNumberKey(event)" > 
                                         
                                              <option value="">--Select--</option>
                           <?php 
                           $sqlquery2 = "select `credit_customer_code`,`credit_customer_name` from `credit_customer_master`";
                           $queryresult2 = mysql_query($sqlquery2) or die("Query failed --1");
                           while ($row2 = mysql_fetch_array($queryresult2))
                         {
                        if($ccno==$row2["credit_customer_code"]) $dselval="selected";
                           else  $dselval=" ";
                       echo  "<option value='".$row2["credit_customer_code"]."' $dselval >".$row2["credit_customer_name"]."</option>" ;
                       } 
                      ?> </select> </div>
										 
                                          <div class="col-sm-3 textalign labelalign"> PAYMENT MODE
                           <select class="form-control"  name="pm" id="pm" onChange="onReasonSelected();">
                                           <option value="">--Select--</option>
		<option value="1" <?php if($pm=="1") echo "selected";?>>Cash</option>
		<option value="2" <?php if($pm=="2") echo "selected";?>>DD/Cheque No.</option>	
		<option value="3" <?php if($pm=="3") echo "selected";?>>Credit/Debit</option>
		<option value="4" <?php if($pm=="4") echo "selected";?>>Fleet Card</option>	
								</select>
                                          </div>
										 
                                         <div id="dd_cheque"  <?php if($pm!="2"&& $pm!="3" && $pm!="4" ){ echo "style='display:none;'"; }else{  echo "style='display:block;'";} ?>>  
                                          <div class="col-sm-3 textalign labelalign">  DD/CHEQUE DATE  
                                          <input type="text" class="form-control"  name="dcdate" id="dcdate" placeholder="DD/MM/YYYY HH/MM/SS" maxlength="40"  onkeypress="return checkNum(event)"  value="<?php echo $dcdate; ?>" />
										  </div>
										  
										   <div class="col-sm-3 textalign labelalign"> BANK
                         <input type="text" class="form-control"  name="bank" id="bank" placeholder="Bank" maxlength="40"  onkeypress="return checkNum(event)"  value="<?php echo $bank; ?>" />
                                          </div>
										  
                                           <div class="col-sm-3 textalign labelalign"> BRANCH
                         <input type="text" class="form-control"  name="branch" id="branch" placeholder="Branch" maxlength="40"  onkeypress="return checkNum(event)"  value="<?php echo $branch; ?>" />
                                          </div>
                                          
                                          <div class="col-sm-3 textalign labelalign"> IFSC CODE
                         <input type="text" class="form-control"  name="ifsc" id="ifsc" placeholder="Ifsc Code" maxlength="40"  onkeypress="return checkNum(event)"  value="<?php echo $ifsc; ?>" />
                                          </div>
										  
                        <div class="col-sm-3 textalign labelalign"> CCNO
                         <input type="text" class="form-control"  name="ccno1" id="ccno1" placeholder="CC Number" maxlength="16"  onkeypress="return checkNum(event)"  value="<?php echo $ccno1; ?>" />
                         </div>
                              </div>            
										   <div class="col-sm-3 textalign labelalign">  STATUS
                                           <select class="form-control"  name="status" id="status">
                                                <option value="A" <?php echo $status1; ?>>Active</option>
                                                <option value="I" <?php echo $status2; ?>>InActive</option>
                                               </select> 
                                        </div>
  <br /><br /><br />

                                          <div class="col-sm-12" align="center"> 
                                   <button class="btn1" type="submit" onClick="functionrequired();">Submit</button>
                                    <button type="reset" class="btn1" >clear</button>
                                  </div>
                                </form>
                
						</div>
  <?php  
if (isset($_POST['desc'])) {  
 
  $desc =   make_safe($_POST['desc']);
     $amount =   make_safe($_POST['amount']);
	  $amtype =   make_safe($_POST['amtype']);
    
	$date =   $_POST['date'];
	$datem=(explode(" ",$date ));
		$msdate=implode(array_reverse(explode("/",$datem[0])),"-");
		$date=$msdate." ".$datem[1];
		
	$toc =   make_safe($_POST['toc']);
    $ccno =   make_safe($_POST['ccno']);
	 //$category =   make_safe($_POST['category']);
   $pm =   make_safe($_POST['pm']);
   
   $dcdate =   $_POST['dcdate'];
   $datem=(explode(" ",$dcdate ));
		$msdate=implode(array_reverse(explode("/",$datem[0])),"-");
	 $dcdate=$msdate." ".$datem[1];
  $bank =   make_safe($_POST['bank']);
	 $branch =   make_safe($_POST['branch']);
 $ifsc =  make_safe($_POST['ifsc']);
    $ccno1 =   make_safe($_POST['ccno1']);
  $status =   make_safe($_POST['status']);
	 $userid =  htmlentities($_SESSION['USER_ID']); 
	 $sid =  make_safe($_POST['sid']); 
  
   
		   
	
   

if ($amount!="" && $amtype!="" && $date!="" && $toc!="" ) {
		if($pm == "2" || $pm == "3"){
			if($dcdate!="" &&  $bank!="" && $branch!="" && $ifsc!="" &&$ccno1 !=""){
				if(dailytransname($desc,$amount,$amtype,$date,$toc,$ccno,$pm,$dcdate,$bank,$branch,$ifsc,$ccno1,$userid,$cdate,$status)){
				echo $mpass = dailytransmaster($sid,$desc,$amount,$amtype,$date,$toc,$ccno,$pm,$dcdate,$bank,$branch,$ifsc,$ccno1,$userid,$cdate,$status);
				//header("location:dailytransactionmaster.php");
				}else{ echo 'This User already exits'; } 
			}else {echo 'Please enter all the mandatory fields';}
    	}
		
		else if($pm == "4"){
			if($ccno1 !=""){
				if(dailytransname($desc,$amount,$amtype,$date,$toc,$ccno,$pm,$dcdate,$bank,$branch,$ifsc,$ccno1,$userid,$cdate,$status)){
				echo $mpass = dailytransmaster($sid,$desc,$amount,$amtype,$date,$toc,$ccno,$pm,$dcdate,$bank,$branch,$ifsc,$ccno1,$userid,$cdate,$status);
				//header("location:dailytransactionmaster.php");
				}else{ echo 'This User already exits'; }
			}else {echo 'Please enter all the mandatory fields';} 
		}

		else{
				if(dailytransname($desc,$amount,$amtype,$date,$toc,$ccno,$pm,$dcdate,$bank,$branch,$ifsc,$ccno1,$userid,$cdate,$status)){
				echo $mpass = dailytransmaster($sid,$desc,$amount,$amtype,$date,$toc,$ccno,$pm,$dcdate,$bank,$branch,$ifsc,$ccno1,$userid,$cdate,$status);
				//header("location:dailytransactionmaster.php");
				}else{ echo 'This User already exits'; } 
			}
} else {echo 'Please enter all the mandatory fields';}
} 
?>                       
                 
                   <br />
                         <div class="col-sm-12">
        <div class="panel panel-default">
      
                      <div class="panel-body ">     <?php echo $sd = dailytransgrid(); ?>       </div>
               </div></div>
					</div>
					<div class="clearfix"> </div>
				</div>
                
			</div>
         
	</div>
	<!-- //choose -->
 
  
 </body>
 <script src="datepickertime/jquery.js"></script>
<script src="datepickertime/jquery.datetimepicker.full.js"></script>
 

<script type = "text/javascript">

$.datetimepicker.setLocale('en');
 
$('#date').datetimepicker({
dayOfWeekStart : 1,
lang:'en', 
startDate:	'1986/01/05'
});
$('#date').datetimepicker({ step:1});
$('#dcdate').datetimepicker({
dayOfWeekStart : 1,
lang:'en', 
startDate:	'1986/01/05'
});
$('#dcdate').datetimepicker({ step:1});
</script>
 <?php require_once("footer.php"); ?>
 </html>  