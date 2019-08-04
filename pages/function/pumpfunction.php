<?php

include_once '../../includes/db_connect.php';
$pages="";
define('MAX_REC_PER_PAGE',10); 


function pumpname($pumpid,$pumpname,$tankid,$itemcode,$status) {
 
   $query= "SELECT  `pump_name` FROM  pump_master 
                             WHERE  upper(pump_name) = trim(upper('$pumpname')) and upper(status) = trim(upper('$status'))";
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
   

function pumpmaster($pumpid,$pumpname,$tankid,$itemcode,$userid,$pumpdate,$status) {
$res = ''; 
 $query3= "SELECT pump_id  FROM pump_master WHERE pump_id ='$pumpid'";
//echo  $query3;
     $result=mysql_query($query3);
	 $num=mysql_numrows($result);
	 //$msdate = implode(array_reverse(explode("^" , $pumpdate)), "-");
 
 
 $query =  "insert into pump_master(pump_name,tank_id,item_code,user_id,pump_date,status) values('$pumpname','$tankid','$itemcode','$userid','$pumpdate','$status')" ;
//echo $query ;
 $query1 = "update pump_master set pump_name='$pumpname',tank_id='$tankid',item_code='$itemcode',pump_date='$pumpdate',user_id='$userid',status='$status'  where pump_id='$pumpid'";
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

function pumpgrid() {
 $res = ''; 

	 $rs = mysql_query("SELECT COUNT(*) FROM pump_master") or die("Count query error!");
  list($total) = mysql_fetch_row($rs);
  $total_pages = ceil($total / MAX_REC_PER_PAGE);
  $page = intval(@$_GET["page"]); 
  if (0 == $page){   $page = 1;   }  
  $start = MAX_REC_PER_PAGE * ($page - 1);
  $max = MAX_REC_PER_PAGE;
    
  $res .= '<div class="box box-primary">
                                <div class="box-header">
                                    <i class="ion ion-clipboard"></i>
                                    <h3 class="box-title"><b>Pump List</b></h3>';
									
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
                                            <th>PUMP NAME</th>
											 <th>TANK NAME</th>  
											 <th>PRODUCT NAME</th>
											<th>STATUS</th>
											  <th>&nbsp;</th>
                                        </tr> ';
										
             $select_query =  "SELECT pump_id,pump_name,(SELECT `tank_name` FROM `tank_master` WHERE `tank_id`=p.tank_id)tankname,(SELECT `produt_name` FROM `product_master` WHERE `s_id`=p.item_code)product,status FROM `pump_master` p ORDER BY pump_name desc";
	    //echo  $select_query;
	 $i=$start + 1;
    $resultk = mysql_query($select_query);
		    while ($rowk = mysql_fetch_array($resultk)) {
	if($rowk["status"]=="A") $status="Active";
	if($rowk["status"]=="I") $status="InActive";
	
    $res .= '<tr><td align="left"> '.$i.'  </td><td align="left">  '.$rowk["pump_name"].'   </td><td align="left">  '.$rowk["tankname"].'   </td> <td align="left">  '.$rowk["product"].'   </td>  <td align="left"> '.$status.'  </td><td align="center"> &nbsp; <a href="pumpmaster.php?edm=edit&icode='.$rowk["pump_id"].'" class="ask"><img src="img/user_edit.png" /></a> &nbsp; <a href="pumpmaster.php?edm=del&del=dels&icode='.$rowk["pump_id"].'" class="ask"><img src="img/trash.png" /></a></td></tr>';
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

function pumpedit($icode,$edm){

$sal = '';

}		
 ?>