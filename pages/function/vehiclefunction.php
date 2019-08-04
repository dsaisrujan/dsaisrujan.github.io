<?php
include_once '../../includes/db_connect.php';
$pages="";
define('MAX_REC_PER_PAGE',10); 

function vehiclename($vno,$vmodal,$userid,$status) {
$query= "SELECT CREDIT_CUSTOMER_ID  FROM creditcustomer_vechicle_master WHERE   upper(cc_s_id) = trim(upper('$sid')) and upper(CREDIT_CUSTOMER_ID) = trim(upper('$cci')) and upper(`cc_vehicle_no`) = trim(upper('$vno')) and upper(`cc_vehicle_model`) = trim(upper('$vmodal')) and upper(user_id) = trim(upper('$userid')) and upper(status)=upper('$status')" ;
$result=mysql_query($query);
$num=mysql_numrows($result);
if ($result) {
    if ($num > 0) {
        return false;
			} else {
            return true;
			}
}
}
   
function vehiclemaster($sid,$cci,$vno,$vmodal,$userid,$strdte,$status) {
$res = ''; 
$DDate = Date("Y-m-d");
$TTime = Time();
	
$query= "SELECT CREDIT_CUSTOMER_ID FROM creditcustomer_vechicle_master WHERE cc_s_id='$sid'";
$result=mysql_query($query);
$num=mysql_numrows($result);
//$msdate = implode(array_reverse(explode("^" , $strdte)), "-");
//echo  $query;
$query =  "INSERT INTO `creditcustomer_vechicle_master`(`CREDIT_CUSTOMER_ID`, `cc_vehicle_no`, `cc_vehicle_model`, `user_id`, `cc_start_date`, `status`) VALUES ('$cci','$vno','$vmodal','$userid',now(),'$status')" ;
//echo  $query;
$query1 = "UPDATE `creditcustomer_vechicle_master` SET CREDIT_CUSTOMER_ID='$cci',cc_vehicle_no='$vno',cc_vehicle_model='$vmodal',user_id='$userid',cc_start_date=now(),status='$status' where cc_s_id='$sid'";
//echo $query1;
if ($num > 0) {
    $result=mysql_query($query1);
	$res = 'Your Data was updated.'; 
    } else {
    $result=mysql_query($query);
	$res = 'Your Data was created.'; 
    }
  return 	$res; 
}

function vehiclegrid() {
 $res = ''; 

	$rs = mysql_query("SELECT COUNT(*) FROM creditcustomer_vechicle_master") or die("Count query error!");
  list($total) = mysql_fetch_row($rs);
  $total_pages = ceil($total / MAX_REC_PER_PAGE);
  $page = intval(@$_GET["page"]); 
  if (0 == $page){   $page = 1;   }  
  $start = MAX_REC_PER_PAGE * ($page - 1);
  $max = MAX_REC_PER_PAGE;
    
  $res .= '<div class="box box-primary">
                                <div class="box-header">
                                    <i class="ion ion-clipboard"></i>
                                    <h3 class="box-title"> <b>Vehicle List</b></h3>';
									
      $res .= '                               <div class="box-tools pull-right"> ';
	    $res .= '                                 <ul class="pagination pagination-sm inline">';
	   for ($i = 1; $i <= $total_pages; $i++) {
  $txt = $i;
   
 /* if($page>1){   $res .= '   <li><a href="../../../camp/pump/pages/'. $_SERVER["PHP_SELF"] . '?page='.$i-1.'\">&laquo;</a></li>  '; }
   $res .= '  <li><a href="../../../camp/pump/pages/'. $_SERVER["PHP_SELF"] . '?page='.$i.'\">'.$txt.'</a></li>
                                            <li><a href="../../../camp/pump/pages/'. $_SERVER["PHP_SELF"] . '?page='.$i+1.'\">'.$txt+1.'</a></li>
                                            <li><a href="../../../camp/pump/pages/'. $_SERVER["PHP_SELF"] . '?page='.$i+2.'\">'.$txt+2.'</a></li> ';
  
    if($page>1){   $res .= '   <li><a href="../../../camp/pump/pages/'. $_SERVER["PHP_SELF"] . '?page='.$i+3.'\">&raquo;</a></li>  '; }*/
  if ($page != $i)
  $txt = ' <li align="center"><a href="pump/pages/'. $_SERVER["PHP_SELF"] . '?page='.$i.'\">'.$txt.'</a> </li>';
 $insvalue .= '
      <li align="center">'. $txt .'</li> ';
      
  }
  
     $res .= '    </ul> ';
										
     $res .= '                                </div> 
                                </div><!-- /.box-header -->
                                <div class="box-body"> ';
						
		 $res .= '						
                                     <table class="table table-hover">
                                        <tr>
                                         <th>ID</th>
								        <th>CREDIT CUSTOMER NAME</th>
                                            <th>VEHICLE NUMBER</th>
											<th>VEHICLE MODEL</th>
                                             <th>STATUS</th>
											      <th>&nbsp;</th>
                                        </tr> ';
						

	$select_query =  "SELECT `cc_s_id`, (select  `credit_customer_name` from `credit_customer_master` where `credit_customer_code`=c.CREDIT_CUSTOMER_ID)`CREDIT_CUSTOMER_ID1`, `cc_vehicle_no`, `cc_vehicle_model`, `user_id`, `cc_start_date`, `status` FROM `creditcustomer_vechicle_master` c ORDER BY CREDIT_CUSTOMER_ID desc";
	//echo  $select_query; 
	$i=$start + 1;
    $resultk = mysql_query($select_query);
	while ($rowk = mysql_fetch_array($resultk)) {
	if($rowk["status"]=="A") $status="Active";
	if($rowk["status"]=="I") $status="InActive";
	 
 $res .= '<tr><td align="left"> '.$i.'  </td><td align="left">  '.$rowk["CREDIT_CUSTOMER_ID1"].' </td><td align="left">  '.$rowk["cc_vehicle_no"].' </td><td align="left"> '.$rowk["cc_vehicle_model"].'</td> <td align="left">'.$status.'</td> </td> <td align="center"> &nbsp; <a href="vehiclemaster.php?edm=edit&amp;icode='.$rowk["cc_s_id"].'"><img src="img/user_edit.png" /></a> &nbsp; <a href="vehiclemaster.php?edm=del&amp;del=dels&amp;icode='.$rowk["cc_s_id"].'" class="ask"><img src="img/trash.png" /></a></td></tr>';
			$i=$i+1;
    }
 
		               $res .= '                     </table>
                                </div><!-- /.box-body -->
                              <!--  <div class="box-footer clearfix no-border">
                                    <button class="btn btn-default pull-right"><i class="fa fa-plus"></i> Add item</button>
                                </div>-->
                            </div><!-- /.box --> ';
	return $res;
	
	
 // $rs = mysql_query("SELECT name, designation, salary FROM employee ORDER BY salary     ASC LIMIT $start, $max") or die("Employee query error!");
  
return $res;
  
}				
?>
