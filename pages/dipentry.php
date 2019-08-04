 <?php 
 include_once '../includes/db_connect.php';
include_once '../includes/functions.php';
include_once 'function/dipfunction.php';
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
$psno=$tid =$dread= $status1= $status2="";
	
	 if($icode!=""){
	   if((!empty($edm)) && ($edm=="del")){   
		     $del_qry = "DELETE FROM dip_tank_trans WHERE trim(`dip_tank_seqno`)=trim('".$icode."')";
		      $result = mysql_query($del_qry);
	
		} 

	if((!empty($edm)) && ($edm=="edit")){   
	  $select_query =  "SELECT `dip_tank_seqno`, `tank_id`,`type_of_dip`, `dip_reading`, `dip_date`,DATE_FORMAT(dip_date,'%d/%m/%Y %H:%m:%s') as date, `dip_user_id`, `c_date`, `status` FROM `dip_tank_trans` WHERE dip_tank_seqno='".$icode."'";
	  //echo   $select_query; 
	  $resultk = mysql_query($select_query);
	
    	while ($rowk = mysql_fetch_array($resultk)) {
			if($rowk["status"]=="A") $status1="selected";
			if($rowk["status"]=="I") $status2="selected";
			$psno = $rowk["dip_tank_seqno"];
			$tid = $rowk["tank_id"];
			$tod = $rowk["type_of_dip"];
			$dread = $rowk["dip_reading"]; 
			$date = $rowk["date"]; 
    	  
		}
	}
	}
	
 ?>
 
 <!DOCTYPE html>
<html>
    <head> 
 
<link rel="stylesheet" href="datepickertime/jquery.datetimepicker.css" /> 

</head>
 <body>
 
 	<!-- about-heading -->
	<div class="about-heading">
		<h2>DIP <span> ENTRY </span></h2>
	</div>
	<!-- //about-heading -->
    
     <!-- choose -->
	<div class="choose jarallax">
  
		<div class="w3-agile-page">
			<div class="container">
              <div class="header">
              	<ul class="breadcrumb">
                	<li><a href="home.php">Home</a> </li>
                	<li class="active">Dip Entry</li>
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
                             <form  name="cform" method="post" action="dipentry.php">
                             
  <div class="col-sm-3 textalign labelalign"> TANK ID
     <select class="form-control"  name="tid" id="tid"  maxlength="80"  onkeypress="return pfNumberKey(event)"/>
     <option value="">--Select--</option>
        <?php 
            $sqlquery2 = "select `TANK_ID`,`tank_name`  from `tank_master`";
            $queryresult2 = mysql_query($sqlquery2) or die("Query failed --1");
            while ($row2 = mysql_fetch_array($queryresult2))
            {
             if($tid==$row2["TANK_ID"]) $dselval="selected";
              else  $dselval=" ";
              echo  "<option value='".$row2["TANK_ID"]."' $dselval >".$row2["tank_name"]."</option>" ;
            } 
        ?> 
      </select> <input type="hidden" class="form-control"  name="did" id="did" value="<?php echo $psno; ?>" />
     
  </div>
  <div class="col-sm-3 textalign labelalign"> TYPE OF DIP
       <select class="form-control"  name="tod" id="tod" >
                            <option value="">--Select--</option>
		<option value="1" <?php if($tod=="1") echo "selected";?>>Before Loading.</option>	
		<option value="2" <?php if($tod=="2") echo "selected";?>>After Loading</option>
		<option value="3" <?php if($tod=="3") echo "selected";?>>Shift Changing</option>
		</select>
        </div>
  
 <div class="col-sm-3 textalign labelalign"> DIP READING
  <input type="text" class="form-control"  name="dopen" id="dopen" placeholder="Dip Reading" maxlength="100"  onkeypress="return isNumberKey(event)"  value="<?php echo $dread; ?>" /></div>
<div class="col-sm-3 textalign labelalign">  DATE
  <input type="text" class="form-control"  name="date" id="date" placeholder="DD/MM/YYYY" maxlength="10"  onBlur="return  ValidateForm()"   value="<?php echo $date; ?>" /> </div>
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
  if(isset($_POST['tid']))
		 {
     $tid = make_safe($_POST['tid']);
	   $tod = make_safe($_POST['tod']);
	  $dopen =  make_safe($_POST['dopen']);
	     $date =  $_POST['date'];
		 $datem=(explode(" ",$date ));
	   $msdate=implode(array_reverse(explode("/",$datem[0])),"-");
	   $date=$msdate." ".$datem[1];
		  $status =  make_safe($_POST['status']);
 $userid =  htmlentities($_SESSION['USER_ID']);
 $did = make_safe($_POST['did']);
 	if ($tid!="") {
	 
		//if(dipid($tid,$tod,$dopen,$date,$userid,$status)){
				echo $sd =dmaster($did,$tid,$tod,$dopen,$date,$userid,$cdate,$status);
				//header("location:dipentry.php");
			/*}
	else{ echo 'This id Name already exits'; } */

 
   } else {
    	echo 'Please enter the id Name';
		// The correct POST variables were not sent to this page. 
   }	
	}

?>          
                   <br />
                         <div class="col-sm-12">
        <div class="panel panel-default">
       
                    <div class="panel-body ">   <?php echo  $sd = dgrid(); ?>       </div>
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


</script>
 <?php require_once("footer.php"); ?>
 </html>