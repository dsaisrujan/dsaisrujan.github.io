<?php
include_once '../../includes/db_connect.php';

 
$pages="";
define('MAX_REC_PER_PAGE',10); 

function username($s_id,$name,$utcode,$userid,$status) {
 
   $query= "SELECT user_s_id  FROM user_master WHERE upper(	user_s_id) = trim(upper('$s_id')) and upper(user_id) = trim(upper('$name')) and upper(user_type_code) = trim(upper('$utcode')) and upper(user_id_code) = trim(upper('$userid')) and upper(status)=upper('$status')" ;
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

   

function usermaster($name,$utcode,$userid,$status) {
 $res = ''; 
$DDate = Date("Y-m-d");
		$TTime = Time();
	$password=generatePassword(12, 1, 2, 3);
	 $query= "SELECT user_s_id FROM user_master WHERE user_s_id='$s_id'";
     $result=mysql_query($query);
	 $num=mysql_numrows($result);
 //echo  $query;
 $query =  "INSERT INTO `user_master`(`user_id`, `user_pwd`, `user_type_code`, `user_id_code`, `status`) VALUES ('$name','$password','$utcode','$userid','$status')" ;
 $query1 = "update user_master set user_id='$name',user_type_code='$utcode',`user_id_code`='$userid',status='$status' where user_s_id='$s_id'";
echo $query;
	 if ($num > 0) {
            $result=mysql_query($query1);
			$res = '<font color="green">Your Data was updated.</font>'; 
        } else {
           $result=mysql_query($query);
		   	$res = '<font color="green">Your Data was created.</font>'; 
        }
  
	return 	$res; 
}

function usergrid() {
 $res = ''; 

	 $rs = mysql_query("SELECT COUNT(*) FROM user_master") or die("Count query error!");
  list($total) = mysql_fetch_row($rs);
  $total_pages = ceil($total / MAX_REC_PER_PAGE);
  $page = intval(@$_GET["page"]); 
  if (0 == $page){   $page = 1;   }  
  $start = MAX_REC_PER_PAGE * ($page - 1);
  $max = MAX_REC_PER_PAGE;
    
  $res .= '<div class="box box-primary">
                                <div class="box-header">
                                    <i class="ion ion-clipboard"></i>
                                    <h3 class="box-title">User List</h3>';
									
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
                                         <th><u><b>ID</b></u></th>
								        <th><u><b>User ID</b></u></th>
                                            <th><u><b>User Type</b></u></th>
											
                                             <th><u><b>Status</b></u></th>
											      <th>&nbsp;</th>
                                        </tr> ';
						

										
             $select_query =  "SELECT `user_s_id`, `user_id`, `user_pwd`, `user_type_code`, `user_id_code`, `status` FROM `user_master`  ORDER BY user_id ASC LIMIT $start, $max";
	  // echo  $select_query; 
	 $i=$start + 1;
    $resultk = mysql_query($select_query);
		    while ($rowk = mysql_fetch_array($resultk)) {
	if($rowk["status"]=="A") $status="Active";
	if($rowk["status"]=="I") $status="InActive";
	 
 $res .= '<tbody><tr><td align="left"><b> '.$i.'</b>  </td><td align="left"> <b> '.$rowk["user_id"].'</b> </td><td align="left"> <b> '.$rowk["user_type_code"].'</b> </td> <td align="left"><b>'.$status.'</b></td> </td> <td align="center"> &nbsp; <a href="usermaster.php?edm=edit&icode='.$rowk["user_s_id"].'"><img src="images/user_edit.png" / title="Edit"></a> &nbsp; <a href="usermaster.php?edm=del&del=dels&icode='.$rowk["user_s_id"].'" class="ask" title="Delete"><img src="images/trash.png" /></a></td></tr>';
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