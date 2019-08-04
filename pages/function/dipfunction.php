<?php
include_once '../../includes/db_connect.php';

$pages="";
define('MAX_REC_PER_PAGE',10); 

function dipid($did,$tid,$tod,$dopen,$date,$userid,$status) {
 
  $query= "SELECT TANK_ID   FROM dip_tank_trans  WHERE upper(TANK_ID) = trim(upper('$tid') and upper(type_of_dip) = trim(upper('$tod') and upper(dip_reading) = trim(upper('$dopen') and   upper(dip_date) = trim(upper('$dclose') and upper(dip_user_id) = trim(upper('$userid') and   upper(status) = trim(upper('$status'))))))";
  //echo $query;
   $result=mysql_query($query);
$num=mysql_numrows($result);
//echo $num;
    if ($result) {
         
        if ($num > 0) {
            return false;
        } else {
            return true;
        }

    }
}
   

function dmaster($did,$tid,$tod,$dopen,$date,$userid,$cdate,$status) {
$res = ''; 
 $query3= "SELECT tank_id FROM dip_tank_trans WHERE `dip_tank_seqno` ='$did'";
 //echo $query3;
 //$msdate = implode(array_reverse(explode("^" , $dclose)), "-");
 
     $result=mysql_query($query3);
	 $num=mysql_numrows($result);
 $query =  "INSERT INTO `dip_tank_trans`( `tank_id`,`type_of_dip`, `dip_reading`, `dip_date`, `dip_user_id`, `c_date`, `status`) VALUES ('$tid','$tod','$dopen','$date','$userid',now(),'$status')" ;
//echo $query ;
 $query1 = "update dip_tank_trans set  tank_id='$tid', type_of_dip='$tid',dip_reading='$dopen',dip_date='$date',dip_user_id='$userid',c_date=now(),status='$status'  where dip_tank_seqno='$did'";
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

function dgrid() {
 $res = ''; 

  $rs = mysql_query("SELECT COUNT(*) FROM  dip_tank_trans") or die("Count query error!");
  list($total) = mysql_fetch_row($rs);
  $total_pages = ceil($total / MAX_REC_PER_PAGE);
  $page = intval(@$_GET["page"]); 
  if (0 == $page){   $page = 1;   }  
  $start = MAX_REC_PER_PAGE * ($page - 1);
  $max = MAX_REC_PER_PAGE;
    
  $res .= '<div class="box box-primary">
                                <div class="box-header">
                                    <i class="ion ion-clipboard"></i>
                                    <h3 class="box-title"><b>Dip List</b></h3>';
									
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
										  <th>TANK NAME</th>
										   <th>TYPE OF DIP</th>
										    <th>DIP READING</th>
                                               <th>DIP DATE</th>
											    <th>STATUS</th>
											      <th>&nbsp;</th>
                                        </tr> ';
						

										
             $select_query = "SELECT  `dip_tank_seqno`,`tank_id`,(select tank_name from tank_master  where tank_id=t.tank_id)tankname,`type_of_dip`,`dip_reading`, `dip_date`,DATE_FORMAT(dip_date,'%d/%m/%Y %H:%m:%s') AS date, `dip_user_id`, `c_date`, `status` FROM  dip_tank_trans t ORDER BY tank_id desc";
	//echo  $select_query; 
	 $i=$start + 1;
    $resultk = mysql_query($select_query);
		    while ($rowk = mysql_fetch_array($resultk)) {
	if($rowk["status"]=="A") $status="Active";
	if($rowk["status"]=="I") $status="InActive";
	if($rowk["type_of_dip"]=="1") $tod="Before Loading";
	if($rowk["type_of_dip"]=="2") $tod="After Loading";
	if($rowk["type_of_dip"]=="3") $tod="Shift Changing";
	
 $res .= '<tr><td align="left"> '.$i.'  </td><td align="left">  '.$rowk["tankname"].' </td><td align="left">'.$tod.'</td><td align="left">  '.$rowk["dip_reading"].' </td><td align="left"> '.$rowk["date"].' </td><td align="left">'.$status.'</td> 
 
 <td align="center"> &nbsp; <a href="dipentry.php?edm=edit&icode='.$rowk["dip_tank_seqno"].'"><img src="img/user_edit.png" /></a> &nbsp; <a href="dipentry.php?edm=del&del=dels&icode='.$rowk["dip_tank_seqno"].'" class="ask"><img src="img/trash.png" /></a></td></tr>';
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
