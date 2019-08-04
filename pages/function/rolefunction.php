<?php
//ob_start();
include_once '../../includes/db_connect.php';
    
$pages="";
define('MAX_REC_PER_PAGE',10); 

function rolename($rname,$cbox,$permission,$status) {
 $cbox=str_replace("-",",",$cbox);
   $query= "SELECT role_name FROM role_master WHERE upper(role_name) = trim(upper('$rname')) and upper(accept_screens) = upper('$cbox') and upper(status) = upper('$status') and upper(permission) = upper('$permission')";
 
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
    $select_q = "SELECT `s_id`,menu_name,menu_head,menu_url,`c_date`, `c_user`, `status` FROM `menu_master` where status='A' and menu_head=0 ORDER BY s_id ASC";
	$resultm = mysql_query($select_q);
    while ($rowm = mysql_fetch_array($resultm)) {
		$insvalue .='<tr><th>'. $rowm['menu_name']. '</th></tr>'; 
 $insvalue .='<tr><td>';
	 
	$insvalue .='<table cellpadding="2" cellspacing="0" border="0" width="98%"><tr>'; 
    $select_query = "SELECT `s_id`, `menu_name`, `menu_url`, `menu_head`, `status` FROM `menu_master`  WHERE  menu_head='".$rowm['s_id']."' and status='A' order by menu_head, `menu_name`";
	//echo $select_query;
	$i=1;$mcode="";$MPM="";
	
	// echo  $select_query;
    $arrSelected = explode(",", $menulist);
	$resultl = mysql_query($select_query);
    while ($rowk = mysql_fetch_array($resultl)) {
		$mcode = $rowk['s_id'];
			 if(isset($arrSelected))
			 {	if (in_array($mcode,$arrSelected, TRUE)) { $MPM = "checked"; } else { $MPM = " ";} 	}
							
        $insvalue .= '<td> <input type="checkbox" name="cbox[]" id="cbox[]" value='.$rowk['s_id'].' style="width:30px"   '.$MPM.'  > '.$rowk['menu_name'].' ('.$rowk['s_id'].') </td>';
		 
			if($i%4==0){ $insvalue .= '</tr><tr>';}
			$i=$i+1;
    }
	$insvalue .= '</tr></table>';
	$insvalue .= '</td></tr>';
	}
    $insvalue .= '</table>';
	
	return $insvalue;
}
	

function rolemaster($sid,$rname,$cbox,$permission,$userid,$status){
 $res = ''; 
$DDate = Date("Y-m-d");
		$TTime = Time();
$cbox=str_replace("-",",",$cbox);
	 $query= "SELECT role_name FROM role_master WHERE s_id='$sid' or upper(role_name) = upper('$rname')";
     $result=mysql_query($query);
	 $num=mysql_numrows($result);
	// echo $num;
 $query =  "insert into role_master(role_name,accept_screens,permission,c_date,c_user,status) values('$rname','$cbox','$permission','$DDate','$userid','$status')" ;
 $query1 = "update role_master set role_name='$rname',accept_screens='$cbox',permission='$permission',c_date='$DDate',c_user='$userid',status='$status'  where s_id='$sid'";
//echo $query;
	 if ($num > 0) {
            $result=mysql_query($query1);
			$res = 'Your Data was updated.'; 
        } else {
           $result=mysql_query($query);
		   	$res = 'Your Data was created.'; 
        }
  
	return 	$res; 
}
	
 

function rolegrid() {
 $res = ''; 

	 $rs = mysql_query("SELECT COUNT(*) FROM role_master") or die("Count query error!");
  list($total) = mysql_fetch_row($rs);
  $total_pages = ceil($total / MAX_REC_PER_PAGE);
  $page = intval(@$_GET["page"]); 
  if (0 == $page){   $page = 1;   }  
  $start = MAX_REC_PER_PAGE * ($page - 1);
  $max = MAX_REC_PER_PAGE;
    
  $res .= '<div class="box box-primary">
                                <div class="box-header">
                                    <i class="ion ion-clipboard"></i>
                                    <h3 class="box-title"><b>Role List</b></h3>';
									
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
                                            <th>ROLE NAME</th>
											  <th>MENU LIST</th>
                                             <th>STATUS</th>
											  <th>&nbsp;</th>
                                        </tr> ';
										
             $select_query =  "SELECT `s_id`,`role_name`,`accept_screens`,permission,`c_date`,`c_user`,`status` FROM `role_master`  ORDER BY role_name desc ";
	   // echo $select_query;
	 $i=$start + 1;
    $resultk = mysql_query($select_query);
		    while ($rowk = mysql_fetch_array($resultk)) {
	if($rowk["status"]=="A") $status="Active";
	if($rowk["status"]=="I") $status="InActive";
	
   $res .= '<tr><td align="left"> '.$i.'  </td><td align="left">  '.$rowk["role_name"].'   </td> <td align="left">  '.$rowk["accept_screens"].'</td> 
   <td align="left"> '.$status.'  </td><td align="center"> &nbsp; <a href="rolemaster.php?edm=edit&icode='.$rowk["s_id"].'" class="ask"><img src="img/user_edit.png"/>
   </a>&nbsp; <a href="rolemaster.php?edm=del&del=dels&icode='.$rowk["s_id"].'" class="ask"><img src="img/trash.png" /></a></td></tr>'; 
			$i=$i+1;
    }
 
		               $res .= '                     </table>
                                </div><!-- /.box-body -->
                             
                            </div><!-- /.box --> ';
	return $res;
 
}				
 ?>