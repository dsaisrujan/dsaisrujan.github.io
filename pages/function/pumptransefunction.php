<?php
include_once '../../includes/db_connect.php';
$pages="";
define('MAX_REC_PER_PAGE',10); 

function pumptransename($sid,$pname,$strread,$date,$status) {
 
   $query= "SELECT `pump_id`, `pump_reading`, `pump_date`, `status`  FROM pump_trans WHERE  upper(pump_id) = trim(upper('$pname')) and upper(pump_reading) = trim(upper('$strread')) and upper(pump_date) = trim(upper('$date')) and upper(status) = trim(upper('$status'))" ;

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
   
function pumptransemaster($sid,$pname,$strread,$date,$userid,$cdate,$status){
$res = ''; 
$DDate = Date("Y-m-d");
		$TTime = Time();
	
	 $query= "SELECT `pump_id` FROM `pump_trans` WHERE s_id='$sid'";
	//echo $query;
     $result=mysql_query($query);
	 $num=mysql_numrows($result);
	 
/*$da = date_create($pdate);
$mgdate=date_format($da, 'Y-m-d H:i:s');
*/
 
 $query =  "INSERT INTO `pump_trans`(`pump_id`, `pump_reading`, `pump_date`, `user_id`,`c_date`, `status`) VALUES('$pname','$strread','$date','$userid',now(),'$status')" ;
 //echo  $query;
 $query1 = "UPDATE `pump_trans` SET pump_id='$pname',pump_reading='$strread',pump_date='$date',user_id='$userid',c_date=now(), status='$status' where s_id='$sid'";
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

function pumptransegrid() {
 $res = ''; 

	 $rs = mysql_query("SELECT COUNT(*) FROM pump_trans") or die("Count query error!");
  list($total) = mysql_fetch_row($rs);
  $total_pages = ceil($total / MAX_REC_PER_PAGE);
  $page = intval(@$_GET["page"]); 
  if (0 == $page){   $page = 1;   }  
  $start = MAX_REC_PER_PAGE * ($page - 1);
  $max = MAX_REC_PER_PAGE;
    
  $res .= '<div class="box box-primary">
                                <div class="box-header">
                                    <i class="ion ion-clipboard"></i>
                                    <h3 class="box-title"><b>Pump Trans List</b></h3>';
									
      $res .= '                               <div class="box-tools pull-right"> ';
	    $res .= '                                 <ul class="pagination pagination-sm inline">';
	   for ($i = 1; $i <= $total_pages; $i++) {
  $txt = $i;
   
 /* if($page>1){   $res .= '   <li><a href="../'. $_SERVER["PHP_SELF"] . '?page='.$i-1.'\">&laquo;</a></li>  '; }
   $res .= '  <li><a href="../'. $_SERVER["PHP_SELF"] . '?page='.$i.'\">'.$txt.'</a></li>
                                            <li><a href="../'. $_SERVER["PHP_SELF"] . '?page='.$i+1.'\">'.$txt+1.'</a></li>
                                            <li><a href="../'. $_SERVER["PHP_SELF"] . '?page='.$i+2.'\">'.$txt+2.'</a></li> ';
  
    if($page>1){   $res .= '   <li><a href="../'. $_SERVER["PHP_SELF"] . '?page='.$i+3.'\">&raquo;</a></li>  '; }*/
  if ($page != $i)
  $txt = ' <li align="center"><a href="../'. $_SERVER["PHP_SELF"] . '?page='.$i.'\">'.$txt.'</a> </li>';
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
								        <th>PUMP NAME</th>
										<th>PUMP READING</th>
										<th>DATE</th>
                                        <th>STATUS</th>
											      <th>&nbsp;</th>
                                        </tr> ';
						

										
             $select_query =  "SELECT `s_id`,(select pump_name from pump_master where pump_id=k.pump_id)pumpname, `pump_reading`,`pump_date`,DATE_FORMAT(pump_date,'%d/%m/%Y %H:%m:%s') as pumpdate,`user_id`, `c_date`, `status` FROM `pump_trans` k ORDER BY pump_id desc";
//echo  $select_query; 
	 $i=$start + 1;
    $resultk = mysql_query($select_query);
		    while ($rowk = mysql_fetch_array($resultk)) {
	if($rowk["status"]=="A") $status="Active";
	if($rowk["status"]=="I") $status="InActive";
	 
 $res .= '<tr><td align="left"> '.$i.'  </td><td align="left">  '.$rowk["pumpname"].' </td><td align="left">  '.$rowk["pump_reading"].' </td><td align="left">  '.$rowk["pumpdate"].' </td><td align="left">'.$status.'</td> <td align="center"> &nbsp; <a href="pumptransemaster.php?edm=edit&icode='.$rowk["s_id"].'"><img src="img/user_edit.png" /></a> &nbsp; <a href="pumptransemaster.php?edm=del&del=dels&icode='.$rowk["s_id"].'" class="ask"><img src="img/trash.png" /></a></td></tr>';
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
