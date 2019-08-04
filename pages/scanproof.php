 <?php 
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';
include_once 'function/scanprooffunction.php';
require_once("header.php");
 ?>
 
 	<!-- about-heading -->
	<div class="about-heading">
		<h2>Scan Proof <span>Master </span></h2>
	</div>
	<!-- //about-heading -->
    
     <!-- choose -->
	<div class="choose jarallax">
  
		<div class="w3-agile-page">
			<div class="container">
              <div class="header">
              	<ul class="breadcrumb">
                	<li><a href="home.php">Home</a> </li>
                	<li class="active">Scan Proof</li>
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
                             <form  name="cform" method="post" action="scanproof.php"  >
                                    
                                      <div class="col-sm-3 textalign labelalign">Customer NAME* 
                                           <select class="form-control"  name="idname" id="idname">
                                         <option>--select--</option>
                                               	  <?php 
				$sqlquery2 = "select `credit_customer_code`, `credit_customer_name` from `credit_customer_master`";
	        $queryresult2 = mysql_query($sqlquery2) or die("Query failed --1");
  			 
								while ($row2 = mysql_fetch_array($queryresult2))
  								{
									if($idname==$row2["credit_customer_code"]) $dselval="selected";
									else  $dselval=" ";
									echo  "<option value='".$row2["credit_customer_code"]."' $dselval >".$row2["credit_customer_name"]."</option>" ;
								} 
								?></select><input type="hidden"   name="sid" id="sid" value="<?php echo $psno; ?>" />
                                           </div>
                                          <div class="col-sm-3 textalign labelalign">  image:
                                         <input type="file" id="simg" name="files[]" multiple   class="form-control"  />  <br>
                                          <input type="hidden"   name="sphoto" id="sphoto"  value="<?php echo $photo; ?>" />  </div>
                                         
                                          <div class="col-sm-3 textalign labelalign">  Status 
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
                       
                 
                   <br />
                         <div class="col-sm-12">
        <div class="panel panel-default">
        <?php
				/*$select_query =  "SELECT count(`s_id`) as count  FROM `menu_master`";
		 		$resultk = mysql_query($select_query);
		    	while ($rowk = mysql_fetch_array($resultk)) {  $count = $rowk["count"];  }*/
        
		?>
            <!--<div class="no-collapse" align="right"> <span class="label label-warning"><?php  //echo $count ?> </span></div>-->
                 <div class="panel-body ">    <?php echo $sd = scangrid(); ?>       </div>
               </div></div>
					</div>
					<div class="clearfix"> </div>
				</div>
                
			</div>
         
	</div>
	<!-- //choose -->
 
    <?php require_once("footer.php"); ?>
 