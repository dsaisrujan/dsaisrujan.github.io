 <?php 
 include_once '../includes/db_connect.php';
include_once '../includes/functions.php';
include_once 'function/todayccfunction.php';
 require_once("header.php");
 ?>
 
 <!DOCTYPE html>
<html>
    <head> 
 
 <link rel="stylesheet" href="pages/jquery/css/smoothness/jquery-ui-1.8.2.custom.css" /> 
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css">
<script type = "text/javascript">
    $(document).ready(function () {
        $("#todaydate").datepicker({ dateFormat: 'dd/mm/yy', changeYear: true});
		
    });
</script>  
</head>
 <body>
 	<!-- about-heading -->
	<div class="about-heading">
		<h2>Credit Sales <span> Report </span></h2>
	</div>
	<!-- //about-heading -->
    
     <!-- choose -->
	<div class="choose jarallax">
  
		<div class="w3-agile-page">
			<div class="container">
              <div class="header">
              	<ul class="breadcrumb">
                	<li><a href="home.php">Home</a> </li>
                	<li class="active">SALES REPORT</li>
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
                             <form  name="cform" method="post" action="todayccsales.php"  >
                                    
                                      <div class="col-sm-3 textalign labelalign"> Enter Date :  
                                            <input type="text" class="form-control"  name="todaydate" id="todaydate" placeholder="DD/MM/YYYY" maxlength="80"  onkeypress="return onlyAlphabets(event,this)"  value="<?php echo $todaydate; ?>" /><input type="hidden"   name="sid" id="sid" value="<?php echo $psno; ?>" />
                                           </div>
                                         <div class="col-sm-12" align="center"> 
                                   <button class="btn1" type="submit">Submit</button>
                                    <button type="reset" class="btn1" >clear</button>
                                  </div>
                                </form>
                
						</div>
   
                 
                   <br />
               <div class="col-sm-12">
        <div class="panel panel-default">
       <div class="panel-body "> 
<?php 
						
if (isset($_POST['todaydate'])) {
$todaydate =   make_safe($_POST['todaydate']);
// echo $sd = myview($todaydate);
} else{ echo 'Please Select Any One Date'; } 
?>	   <?php  //echo $sd =myview($todaydate); ?>    </div>
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