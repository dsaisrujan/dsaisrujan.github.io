<?php
include_once '../../includes/db_connect.php';
$pages="";
define('MAX_REC_PER_PAGE',10); 

function shft($scode,$sname,$stime,$etime,$status) {
 
  $query= "SELECT shift_code FROM shift_master  WHERE  upper(shift_code) = trim(upper('$scode')  and upper(shift_name) = trim(upper('$sname') and upper(shift_start_time) = trim(upper('$stime')  and  upper(shift_end_time) = trim(upper('$etime')  and   upper(status) = trim(upper('$status'))))";
   
   //echo $query;
   
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
   
function shiftmaster($scode,$sname,$stime,$etime,$userid,$sdate,$status) {
$res = ''; 
 $query3="SELECT shift_code FROM shift_master WHERE shift_code ='$scode'";
 //echo $query3;
     $result=mysql_query($query3);
	 $num=mysql_numrows($result);
	 
	/* $stime1=implode(array_reverse(explode("^",$stime)),"-");
	$etime1=implode(array_reverse(explode("^",$etime)),"-");
	$sdate1=implode(array_reverse(explode("^",$sdate)),"-");*/
	 
 $query =  "insert into shift_master(shift_name,shift_start_time,shift_end_time,shift_created_user_id,shift_created_date,status) values('$sname','$stime','$etime','$userid',now(),'$status')" ;
//echo $query;
 $query1 = "UPDATE shift_master SET shift_name = '$sname',`shift_start_time`='$stime',`shift_end_time`='$etime',`shift_created_user_id`='$userid',`shift_created_date`=now(),`status`='$status' WHERE shift_code='$scode'";
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


function sgrid() {
 $res = '';
 $rs = mysql_query("SELECT COUNT(*) FROM shift_master") or die("Count query error!");
  list($total) = mysql_fetch_row($rs);
  $total_pages = ceil($total / MAX_REC_PER_PAGE);
  $page = intval(@$_GET["page"]); 
  if (0 == $page){   $page = 1;   }  
  $start = MAX_REC_PER_PAGE * ($page - 1);
  $max = MAX_REC_PER_PAGE;
  

  $res .= '<div class="box box-primary">
                                <div class="box-header">

									<i class="ion ion-clipboard"></i>
                                  
								    <h3 class="box-title"><b>Shift List</b></h3>';
									
      $res .= '                               <div class="box-tools pull-right"> ';
	    $res .= '                                 <ul class="pagination pagination-sm inline">';
	   for ($i = 1; $i <= $total_pages; $i++) {
  $txt = $i;
   
 /* if($page>1){   $res .= '   <li><a href="../../functions/'. $_SERVER["PHP_SELF"] . '?page='.$i-1.'\">&laquo;</a></li>  '; }
   $res .= '  <li><a href="../../functions/'. $_SERVER["PHP_SELF"] . '?page='.$i.'\">'.$txt.'</a></li>
                                            <li><a href="../../functions/'. $_SERVER["PHP_SELF"] . '?page='.$i+1.'\">'.$txt+1.'</a></li>
                                            <li><a href="../../functions/'. $_SERVER["PHP_SELF"] . '?page='.$i+2.'\">'.$txt+2.'</a></li> ';
  
    if($page>1){   $res .= '   <li><a href="../../functions/'. $_SERVER["PHP_SELF"] . '?page='.$i+3.'\">&raquo;</a></li>  '; }*/
  if ($page != $i)
  $txt = ' <li align="center"><a href="../../functions/'. $_SERVER["PHP_SELF"] . '?page='.$i.'\">'.$txt.'</a> </li>';
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
										    <th>SHIFT NAME</th>
											<th>SHIFT START TIME</th>
											<th>SHIFT END TIME</th>
											<th>STATUS</th>
							                 <th>&nbsp;</th>
                                        </tr> ';
										
     $select_query =  "SELECT `shift_code`,shift_name, `shift_start_time`,DATE_FORMAT(shift_start_time,'%H:%m:%s') as shift_start_time1,`shift_end_time`,DATE_FORMAT(shift_end_time, '%H:%m:%s') as shift_end_time1,`shift_created_user_id`,`shift_created_date`,`status` FROM `shift_master`  ORDER BY shift_code desc";
	    
	 $i=$start + 1;
    $resultk = mysql_query($select_query);
		    while ($rowk = mysql_fetch_array($resultk)) {
	if($rowk["status"]=="A") $status="Active";
	if($rowk["status"]=="I") $status="InActive";
	
    
   
   
   $res .= '<tr><td align="left">  '.$i.'</td><td align="left">  '.$rowk["shift_name"].'</td><td align="left">  '.$rowk["shift_start_time1"].'</td><td align="left">  '.$rowk["shift_end_time1"].'</td><td align="left"> '.$status.'  </td><td align="center"> &nbsp;<a href="shiftmaster.php?edm=edit&icode='.$rowk["shift_code"].'"><img src="img/user_edit.png" /></a> &nbsp; <a href="shiftmaster.php?edm=del&del=dels&icode='.$rowk["shift_code"].'" class="ask"><img src="img/trash.png" /></a></td></tr>';;
			$i=$i+1;
    }
 
		               $res .= '                     </table>
                                </div><!-- /.box-body -->
                              <!--  <div class="box-footer clearfix no-border">
                                    <button class="btn btn-default pull-right"><i class="fa fa-plus"></i> Add item</button>
                                </div>-->
                            </div><!-- /.box --> ';
	return $res;
	

}	
?>