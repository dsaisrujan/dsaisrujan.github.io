<?php
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';
$pages="";
define('MAX_REC_PER_PAGE',10); 

function menuname($mname,$mhead,$murl,$status)
{ 
   $query= "SELECT menu_name FROM menu_master  WHERE upper(menu_name) = upper('$mname') and upper(menu_head)=upper('$mhead') and upper(menu_url)=upper('$murl') and upper(status)=upper('$status')";
 
   	$result=mysql_query($query);
	$num=mysql_num_rows($result);

    if ($result) {
        if ($num > 0) {  return false;
        } else {   return true;   }
    }
}
  
function menumaster($sid,$mname,$mhead,$murl,$status,$userid) 
{
 $res = ''; 
$DDate = Date("Y-m-d");
		$TTime = Time();
	
	 $query= "SELECT menu_name FROM menu_master WHERE s_id='$sid' ";
     $result=mysql_query($query);
	 $num=mysql_num_rows($result);

 $query =  "insert into menu_master(menu_name,menu_head,menu_url,c_date,c_user,status) values('$mname','$mhead','$murl',now(),'$userid','$status')" ;
 //echo $query;
 $query1 = "update menu_master set menu_name='$mname',menu_head='$mhead',menu_url='$murl',c_date=now(),c_user='$userid',status='$status'  where s_id='$sid'";
	 if ($num > 0) {
            $result=mysql_query($query1);
			$res = 'Your Data was updated.'; 
        } else {
          $result=mysql_query($query);
		   	$res = 'Your Data was created.'; 
        }
	return 	$res; 
}

function menugrid() {
 $res = ''; 
 	$select_query =  "SELECT count(`s_id`) as count  FROM `menu_master`";
		 		$resultk = mysql_query($select_query);
		    	while ($rowk = mysql_fetch_array($resultk)) {  $count = $rowk["count"];  }
    
   $res .= '<div class="box box-primary">
                                <div class="box-header">
                                    <i class="ion ion-clipboard"></i>
                                    <h3 class="box-title"><b>Menu List</b></h3>';
									
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
                                            <th>MENU NAME</th>
											<th>MENU HEAD</th>
                                             <th>STATUS</th>
											  <th>&nbsp;</th>
                                        </tr> ';
										
             $select_query =  "SELECT `s_id`, `menu_name`,(SELECT menu_name FROM menu_master WHERE s_id = m.menu_head)menu_head1,`menu_url`, `c_date`, `c_user`, `status` FROM `menu_master` m ORDER BY menu_name desc";
	    
	 $i=1;
    $resultk = mysql_query($select_query);
		    while ($rowk = mysql_fetch_array($resultk)) {
	if($rowk["status"]=="A") $status="Active";
	if($rowk["status"]=="I") $status="InActive";
	
    $res .= '<tr><td align="left"> '.$i.'  </td><td align="left">  '.$rowk["menu_name"].'   </td><td align="left">  '.$rowk["menu_head1"].'   </td> <td align="left"> '.$status.'  </td><td align="center"> &nbsp; <a href="menumaster1.php?edm=edit&icode='.$rowk["s_id"].'"><img src="img/user_edit.png" /></a> &nbsp; <a href="menumaster1.php?edm=del&del=dels&icode='.$rowk["s_id"].'" class="ask"><img src="img/trash.png" /></a></td></tr>';
			$i=$i+1;
    }
 
		               $res .= '                     </table>
                                </div><!-- /.box-body -->
                               </div><!-- /.box --> ';
	return $res;
 
  
}				
 ?>