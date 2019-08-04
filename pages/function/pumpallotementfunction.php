<?php
//ob_start();
include_once '../../includes/db_connect.php';

$pages="";
define('MAX_REC_PER_PAGE',10); 

function pumpallote($empname,$scode ,$cbox,$pdate,$status) {
 $cbox=str_replace("-",",",$cbox);
   $query= "SELECT emp_code FROM daily_pump_allotment WHERE upper(emp_code) = trim(upper('$empname')) and upper(allotment_pumps) = upper('$cbox') and upper(status) = upper('$status') and upper(	allotment_date) = upper('$pdate')";
 
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
 
 function  menulist($menulist){
	$insvalue ='<table cellpadding="2" cellspacing="0" border="1" width="98%"> '; 
    $select_q = "SELECT `tank_id`, `tank_name`, `oil_type`, `calibration_id`, `tank_created_user_id`, `tank_created_date`, `status` FROM `tank_master` where status='A' and tank_name=0 ORDER BY tank_id ASC";
	//echo $select_q;
	$resultm = mysql_query($select_q);
    while ($rowm = mysql_fetch_array($resultm)) {
		$insvalue .='<tr><th>'. $rowm['tank_name']. '</th></tr>'; 
 $insvalue .='<tr><td>';
	$insvalue .='<table cellpadding="2" cellspacing="0" border="0" width="98%"><tr>'; 
    $select_query = " SELECT `pump_id`, `pump_name`, `tank_id`, `item_code`, `user_id`, `pump_date`, `status` FROM `pump_master`  WHERE  tank_id='".$rowm['tank_id']."' and status='A' order by pump_name, `tank_id`";
	//echo $select_query;
	$i=1;$mcode="";$MPM="";
	
	// echo  $select_query;
    $arrSelected = explode(",", $menulist);
	$resultl = mysql_query($select_query);
    while ($rowk = mysql_fetch_array($resultl)) {
		$mcode = $rowk['pump_id'];
			 if(isset($arrSelected))
			 {	if (in_array($mcode,$arrSelected, TRUE)) { $MPM = "checked"; } else { $MPM = " ";} 	}
							
        $insvalue .= '<td> <input type="checkbox" name="cbox[]" id="cbox[]" value='.$rowk['pump_id'].' style="width:30px"   '.$MPM.'  > '.$rowk['pump_name'].' ('.$rowk['pump_id'].') </td>';
		 
			if($i%4==0){ $insvalue .= '</tr><tr>';}
			$i=$i+1;
    }
	$insvalue .= '</tr></table>';
	$insvalue .= '</td></tr>';
	}
    $insvalue .= '</table>';
	
	return $insvalue;
}
	

function  pumpallotementmaster($sid,$empname,$scode,$cbox,$pdate,$userid,$cdate,$status){
 $res = ''; 
$DDate = Date("Y-m-d");
		$TTime = Time();
$cbox=str_replace("-",",",$cbox);
	 $query= "SELECT emp_code FROM daily_pump_allotment WHERE s_id='$sid' ";
    // echo $query;
	 $result=mysql_query($query);
	 $num=mysql_numrows($result);

/*$date = date_create($pdate);
$mgdate=date_format($date, 'Y-m-d H:i:s');*/

	// echo $num;
 $query =  "insert into daily_pump_allotment(emp_code,shift_code,allotment_pumps,allotment_date,user_id,c_date,status) values('$empname','$scode','$cbox','$pdate','$userid',now(),'$status')" ;
//echo $query;
 $query1 = "update daily_pump_allotment set emp_code='$empname',shift_code='$scode',allotment_pumps='$cbox',allotment_date='$pdate',user_id='$userid',c_date=now(),status='$status'  where s_id='$sid'";
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
	
 

function pumpallgrid() {
 $res = ''; 

	 $rs = mysql_query("SELECT COUNT(*) FROM daily_pump_allotment") or die("Count query error!");
  list($total) = mysql_fetch_row($rs);
  $total_pages = ceil($total / MAX_REC_PER_PAGE);
  $page = intval(@$_GET["page"]); 
  if (0 == $page){   $page = 1;   }  
  $start = MAX_REC_PER_PAGE * ($page - 1);
  $max = MAX_REC_PER_PAGE;
    
  $res .= '<div class="box box-primary">
                                <div class="box-header">
                                    <i class="ion ion-clipboard"></i>
                                    <h3 class="box-title"><b>Pump Allotement List</b></h3>';
									
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
                                            <th>EMPLOYEE NAME</th>
											<th>SHIFT NAME</th>
											  <th>PUMP LIST</th>
											  <th>ALLOMENT DATE</th>
                                             <th>STATUS</th>
											  <th>&nbsp;</th>
                                        </tr> ';
										
             $select_query ="SELECT `s_id`,(SELECT `emp_name` FROM `employee_master` WHERE `emp_code`= s.emp_code)ename,(SELECT shift_name FROM shift_master WHERE shift_code=s.shift_code)scode,allotment_pumps,`allotment_date`,DATE_FORMAT(allotment_date,'%d/%m/%Y %H:%m:%s') as allotment_date1,`user_id`,`c_date`,`status` FROM `daily_pump_allotment` s  ORDER BY emp_code desc";
	 //echo $select_query ;
	 $i=$start + 1;
    $resultk = mysql_query($select_query);
		    while ($rowk = mysql_fetch_array($resultk)) {
	if($rowk["status"]=="A") $status="Active";
	if($rowk["status"]=="I") $status="InActive";
	$pumps=$rowk["allotment_pumps"];
	 $pumplist=(explode(",",$pumps ));
	 $select_query1 ="SELECT `pump_name` FROM `pump_master` WHERE `pump_id` in (".$pumps.")";
	  //echo $select_query1 ;
	  
	  
	  $pump="";
	 $result = mysql_query($select_query1);
	 while ($row = mysql_fetch_array($result)) {
		 $pump .= ",".$row["pump_name"]; 
	 }
		$pump=trim($pump,','); 
		//echo $pump;
		
   $res .= '<tr><td align="left"> '.$i.'  </td><td align="left">  '.$rowk["ename"].'   </td><td align="left">  '.$rowk["scode"].'   </td> <td align="left">  '.$pump.'</td><td align="left">  '.$rowk["allotment_date1"].'</td><td align="left"> '.$status.'  </td><td align="center">&nbsp;<a href="pumpallotement.php?edm=edit&icode='.$rowk["s_id"].'" class="ask"><img src="img/user_edit.png"/></a> &nbsp; <a href="pumpallotement.php?edm=del&del=dels&icode='.$rowk["s_id"].'" class="ask"><img src="img/trash.png" /></a></td></tr>';
			$i=$i+1;
    }
 
		               $res .= '                     </table>
                                </div><!-- /.box-body -->
                             
                            </div><!-- /.box --> ';
	return $res;
 
}				
 