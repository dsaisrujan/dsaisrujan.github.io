 <?php 
 include_once '../includes/db_connect.php';
include_once '../includes/functions.php';
include_once 'function/idfunction.php';
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
		     $del_qry = "DELETE FROM id_proof_type_master WHERE trim(id_proof_type_code)=trim('".$icode."')";
			 $result = mysql_query($del_qry);
	  	} 
	 
	 
	if((!empty($edm)) && ($edm=="edit")){   
	  $select_query =  "SELECT id_proof_type_code,id_proof_name, `c_user`, `c_date`,status FROM `id_proof_type_master`  WHERE  id_proof_type_code='".$icode."'";
	 //echo $select_query;
	  $resultk = mysql_query($select_query);
	//echo $select_query;
    	while ($rowk = mysql_fetch_array($resultk)) {
			if($rowk["status"]=="A") $status1="selected";
			if($rowk["status"]=="I") $status2="selected";
			$psno = $rowk["id_proof_type_code"];
			$cname = $rowk["id_proof_name"]; 
    	$status=$rowk["status"]; 
		}
	}
	}
 
 ?>
 
 	<!-- about-heading -->
	<div class="about-heading">
		<h2>ID Proof <span>Master </span></h2>
	</div>
	<!-- //about-heading -->
    
     <!-- choose -->
	<div class="choose jarallax">
  
		<div class="w3-agile-page">
			<div class="container">
              <div class="header">
              	<ul class="breadcrumb">
                	<li><a href="home.php">Home</a> </li>
                	<li class="active">ID Proof Master</li>
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
                             <form  name="cform" method="post" action="idproof.php"  >
                                    
                                      <div class="col-sm-3 textalign labelalign">  PROOF NAME
                                           <input type="text" class="form-control"  name="idname" id="idname" placeholder="ENTER PROOF NAME" maxlength="100"  onkeypress="return  checkNum(event)"  value="<?php echo $cname; ?>" /><input type="hidden"   name="sid" id="sid" value="<?php echo $psno; ?>" />
                                           </div>
                                         
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
  if(isset($_POST['idname']))
		 {
     $idname =   make_safe($_POST['idname']);
	 $idcode =   make_safe($_POST['sid']);
    $status =   make_safe($_POST['status']);
 	if ($idname!="" && status!="" ) {
	 
		//if(idproofname($idcode,$idname,$userid,$cdate,$status) ){
				echo $mpass =  idproofmaster($idcode,$idname,$userid,$cdate,$status);
				//header("location:idproofmaster.php");
			/*}
			else{ echo 'This id Name already exits'; }*/
 	} else {
    	// The correct POST variables were not sent to this page. 
    	echo 'Please enter the id Name';
	}
} 
?>                
                 
                   <br />
                         <div class="col-sm-12">
        <div class="panel panel-default">
      
			<div class="panel-body ">      <?php echo $sd = idproofgrid(); ?>      </div>
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