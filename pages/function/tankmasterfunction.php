<?php
include_once '../../includes/db_connect.php';

$pages="";
define('MAX_REC_PER_PAGE',10); 


function tankidname($tankid,$tankname,$otype,$calbr,$status) {
 
   $query= "SELECT tank_id  FROM  tank_master 
                             WHERE upper(tank_id) = trim(upper('$tankid')) and upper(tank_name) = trim(upper('$tankname')) and upper(status) = trim(upper('$status'))";
   $result=mysql_query($query);
$num=mysql_numrows($result);

    if ($result) {
         
        if ($num >0) {
            return false;
        } else {
            return true;
        }

    }
}
   

function tankidmaster($tankid,$tankname,$otype,$calbr,$userid,$cdate,$status) {
$res = ''; 
$DDate = Date("Y-m-d");
$TTime = Time();

 $query3= "SELECT tank_id  FROM tank_master WHERE tank_id ='$tankid'";
 //echo $query3;
     $result=mysql_query($query3);
	 $num=mysql_numrows($result);
	  //$msdate = implode(array_reverse(explode("^" , $cdate)), "-");
 $query = "INSERT INTO `tank_master`(`tank_name`, `oil_type`, `calibration_id`, `tank_created_user_id`, `tank_created_date`, `status`) VALUES ('$tankname','$otype','$calbr','$userid',now(),'$status')";
 //echo $query;
 $query1 = "update tank_master set tank_name='$tankname',oil_type='$otype',calibration_id='$calbr',tank_created_user_id='$userid',tank_created_date = now(),status='$status' where tank_id='$tankid'";
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

function tankidgrid() {
 $res = ''; 

	 $rs = mysql_query("SELECT COUNT(*) FROM tank_master") or die("Count query error!");
  list($total) = mysql_fetch_row($rs);
  $total_pages = ceil($total / MAX_REC_PER_PAGE);
  $page = intval(@$_GET["page"]); 
  if (0 == $page){   $page = 1;   }  
  $start = MAX_REC_PER_PAGE * ($page - 1);
  $max = MAX_REC_PER_PAGE;
    
 $res .= '<div class="box box-primary">
                                <div class="box-header">
                                    <i class="ion ion-clipboard"></i>
                                    <h3 class="box-title"><b>Tank List</b></h3>';
									
      $res .= '                               <div class="box-tools pull-right"> ';
	    $res .= '                                 <ul class="pagination pagination-sm inline">';
	   for ($i = 1; $i <= $total_pages; $i++) {
  $txt = $i;
   
 /* if($page>1){   $res .= '   <li><a href="'. $_SERVER["PHP_SELF"] . '?page='.$i-1.'\">&laquo;</a></li>  '; }
   $res .= '  <li><a href="'. $_SERVER["PHP_SELF"] . '?page='.$i.'\">'.$txt.'</a></li>
                                            <li><a href="'. $_SERVER["PHP_SELF"] . '?page='.$i+1.'\">'.$txt+1.'</a></li>
                                            <li><a href="'. $_SERVER["PHP_SELF"] . '?page='.$i+2.'\">'.$txt+2.'</a></li> ';
  
    if($page>1){   $res .= '   <li><a href="'. $_SERVER["PHP_SELF"] . '?page='.$i+3.'\">&raquo;</a></li>  '; }*/
  if ($page != $i)
  $txt = ' <li align="center"><a href="'. $_SERVER["PHP_SELF"] . '?page='.$i.'\">'.$txt.'</a> </li>';
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
                                            <th>TANK NAME</th>
											<th>OIL TYPE</th>
											
											 <th>CALIBRATION</th>
                                             <th>STATUS</th>
											  <th>&nbsp;</th>
                                        </tr> ';
										
             $select_query =  "SELECT `tank_id`, `tank_name`, `oil_type`,(SELECT `produt_name` FROM `product_master` WHERE   `s_id`=c.oil_type)oiltype, `calibration_id`,
			 (SELECT concat('(DIA)', tank_diameter,',','(LEN)',tank_length,',','(CAP)',capacity)tank FROM `calibration_master` WHERE `s_id`=c.calibration_id)calb,
			 `tank_created_user_id`, `tank_created_date`, `status`  FROM `tank_master` c ORDER BY tank_name desc";
	   //echo $select_query;
	 $i=$start + 1;
    $resultk = mysql_query($select_query);
		    while ($rowk = mysql_fetch_array($resultk)) {
	if($rowk["status"]=="A") $status="Active";
	if($rowk["status"]=="I") $status="InActive";
	
    $res .= '<tr><td align="left"> '.$i.'  </td><td align="left">  '.$rowk["tank_name"].'   </td> <td align="left">  '.$rowk["oiltype"].'   </td> <td align="left">  '.$rowk["calb"].'   </td><td align="left"> '.$status.'  </td><td align="center"> &nbsp; <a href="tankmaster.php?edm=edit&icode='.$rowk["tank_id"].'" class="ask"><img src="img/user_edit.png" /></a> &nbsp; <a href="tankmaster.php?edm=del&del=dels&icode='.$rowk["tank_id"].'" class="ask"><img src="img/trash.png" /></a></td></tr>';
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
  
return res;
  
}				

function tanknameedit($icode,$edm){

$sal = '';

}		
 ?>