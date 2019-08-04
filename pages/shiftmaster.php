 <?php 
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';
include_once 'function/shiftfunction.php';
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
 $psno = $cname= $status1= $status2="";
	
	 if($icode!=""){
	   if((!empty($edm)) && ($edm=="del")){   
		     $del_qry = "DELETE FROM shift_master WHERE trim(shift_code)=trim('".$icode."')";
			 $result = mysql_query($del_qry);
	  	}
	 
	 if((!empty($edm)) && ($edm=="edit")){   
	  $select_query = "SELECT `shift_code`,shift_name, `shift_start_time`,DATE_FORMAT(shift_start_time,'%H:%m:%s') as shift_start_time1,`shift_end_time`,DATE_FORMAT(shift_end_time,'%H:%m:%s') as shift_end_time1, `shift_created_user_id`,`shift_created_date`,`status` FROM `shift_master`  WHERE  shift_code='".$icode."'";
	  $resultk = mysql_query($select_query);
	// echo  $select_query;
    	while ($rowk = mysql_fetch_array($resultk)) {
			if($rowk["status"]=="A") $status1="selected";
			if($rowk["status"]=="I") $status2="selected";
			$psno = $rowk["shift_code"];
			$sname= $rowk["shift_name"];
			$cname = $rowk["shift_start_time1"];
			$etime= $rowk["shift_end_time1"];
			$status=$rowk["status"];
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
<h2>Shift <span>Master</span></h2>
</div>
<!-- //about-heading -->
<!-- choose -->
<div class="choose jarallax">
  <div class="w3-agile-page">
	<div class="container">
       <div class="header">
        <ul class="breadcrumb">
           <li><a href="home.php">Home</a> </li>
            <li class="active">Shift Master</li>
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
                             <form  name="cform" method="post" action="shiftmaster.php"  >
                                    <div class="col-sm-3 textalign labelalign"> SHIFT NAME
                                            <input type="text" name="sname" id="sname"    placeholder="Shift Name" onKeyPress="return timeKey(event)"  class="form-control"    maxlength="50" value="<?php echo $sname; ?>" /><input type="hidden"   name="sid" id="sid" value="<?php echo $psno; ?>" />
                                           </div>
                                      <div class="col-sm-3 textalign labelalign"> SHIFT START TIME
                                            <input type="text" name="stime" id="stime"    placeholder="HH/MM/SS" onKeyPress="return timeKey(event)"  class="form-control"    maxlength="50" value="<?php echo $cname; ?>" />
                                           </div>
                                          <div class="col-sm-3 textalign labelalign"> SHIFT END TIME
                                         <input type="text" name="etime" id="etime"  value="<?php echo $etime; ?>"  placeholder="HH/MM/SS " onKeyPress="return timeKey(event)"  class="form-control"    maxlength="50"/> </div>
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
  if(isset($_POST['stime']))
		 {
		$sname = make_safe($_POST['sname']);
    //echo  $stime = $_POST['stime'];
	/* $datem=(explode(" ",$stime ));
	   $msdate=implode(array_reverse(explode("/",$datem[0])),"-");
	   $stime=$msdate." ".$datem[1];*/
	
	$etime =  $_POST['etime'];
	 /*$datem=(explode(" ",$etime ));
	   $msdate=implode(array_reverse(explode("/",$datem[0])),"-");
	   $etime=$msdate." ".$datem[1];*/

	   
	 $scode = make_safe($_POST['sid']);
	 $userid =  htmlentities($_SESSION['USER_ID']); 
	 $sdate = make_safe($_POST['sdate']);
	 $status =  make_safe($_POST['status']);
//echo $stime;
 	if ($stime!="" && $etime!="" && $status!="") 
	{
	 
		//if(shft($scode,$sname,$stime,$etime,$status)){
				echo $mpass =shiftmaster($scode,$sname,$stime,$etime,$userid,$sdate,$status);
				//header("location:shiftmaster.php");
			
	//else{ echo 'This id Name already exits'; } 
}else {
    	// The correct POST variables were not sent to this page. 
    	echo 'Please enter the id Name';
	//}
}}
?>                
                 
                   <br />
                         <div class="col-sm-12">
        <div class="panel panel-default">
       <div class="panel-body ">   <?php echo $sd = sgrid(); ?>      </div>
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

//$('#stime').datetimepicker({ datepicker:false, step:1});

$('#stime').datetimepicker({
	datepicker:false,
	format:'H:i:s',
	step:1
});

$('#etime').datetimepicker({
	datepicker:false,
	format:'H:i:s',
	step:1
});
//$('#etime').datetimepicker({step:1});

</script>
    <?php  require_once("footer.php"); ?>
 
 </html>