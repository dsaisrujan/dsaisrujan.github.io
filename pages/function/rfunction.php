<?php

include_once '../../includes/db_connect.php';

$pages="";
define('MAX_REC_PER_PAGE',10); 


function rulename($rid,$rname,$ecode,$status) {
 
   $query= "SELECT `role_name` FROM `role_master` WHERE  upper(role_id) = trim(upper('$rid')) and upper(role_name) = trim(upper('$rname')) and upper(employee_codes) = trim(upper('$ecode')) and upper(status) = trim(upper('$status'))" ;

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
   
function rulemaster($rid,$rname,$ecode,$status) {
$res = ''; 
 $query= "SELECT role_name FROM role_master WHERE role_id='$rid'";
 //echo  $query;
     $result=mysql_query($query);
	 $num=mysql_numrows($result);
 
 
$query =  "INSERT INTO `role_master`(`role_name`,`employee_codes`,`status`) VALUES ('$rname','$ecode','$status')" ;
 $query1 = "update role_master set role_name='$rname',employee_codes='$ecode',status='$status' where role_id='$rid'";
//echo $query1;
	 if ($num > 0) {
            $result=mysql_query($query1);
			//echo $query;
			$res = 'Your Data was updated.'; 
        } else {
		//echo $query;
           $result=mysql_query($query);
		  // echo $query;
		   	$res = 'Your Data was created.'; 
        }
  
	return 	$res; 
}


function rulegrid() {

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
                                    <h3 class="box-title">PROOF LIST</h3>';
									
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
								       
                                            <th>Role Name</th>
										
                                             <th>Status</th>
											      <th>&nbsp;</th>
                                        </tr> ';
           $select_query =  "SELECT `role_id`, `role_name`, `employee_codes`, `status` FROM `role_master` ORDER BY role_name ASC LIMIT $start, $max";
	    
	 $i=$start + 1;
    $resultk = mysql_query($select_query);
		    while ($rowk = mysql_fetch_array($resultk)) {
	if($rowk["STATUS"]=="A") $status="Active";
	if($rowk["STATUS"]=="I") $status="InActive";
	
    $res .= '<tbody><tr><td align="left"><b> '.$i.'</b>  </td><td align="left"> <b> '.$rowk["role_name"].'</b>   </td> <td align="left"><b> '.$status.'</b>  </td><td align="center"> &nbsp; <a href="rmaster.php?edm=edit&icode='.$rowk["role_id"].'" class="ask"><img src="images/user_edit.png" /></a> &nbsp; <a href="rmaster.php?edm=del&del=dels&icode='.$rowk["role_id"].'" class="ask"><img src="images/trash.png" /></a></td></tr>';
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

function ruleedit($icode,$edm){

$sal = '';

}		
 