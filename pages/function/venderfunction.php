<?php
include_once '../../includes/db_connect.php';

$pages="";
define('MAX_REC_PER_PAGE',10); 
function vendername($vname,$venderadd,$contactno,$email,$cpname,$status) {
 
   $query= "SELECT  `vender_name`, `vender_address`, `contact_no`, `email_id`, `contact_person_name`,status FROM `vender_master` where upper(vender_name) = trim(upper('$vname')) and upper(vender_address) = trim(upper('$venderadd'))and upper(contact_no) = trim(upper('$contactno')) and upper(email_id) = trim(upper('$email')) and upper(contact_person_name) = trim(upper('$cpname')) and upper(status) = trim(upper('$status'))";
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
   

function vendermaster($sid,$vname,$venderadd,$contactno,$email,$cpname,$cdate,$userid,$status) {
$res = ''; 
$DDate = Date("Y-m-d");
		$TTime = Time();

 $query3= "SELECT vender_name  FROM vender_master WHERE s_id ='$sid'";
 //echo $query3;
     $result=mysql_query($query3);
	 $num=mysql_numrows($result);
	  //$msdate = implode(array_reverse(explode("^" , $cdate)), "-");
 $query = "INSERT INTO `vender_master`(`vender_name`, `vender_address`, `contact_no`, `email_id`, `contact_person_name`, `c_date`, `c_user`, `status`) VALUES ('$vname','$venderadd','$contactno','$email','$cpname',now(),'$userid','$status')";
//echo $query;
 $query1 = "update vender_master set vender_name='$vname',vender_address='$venderadd',contact_no='$contactno',`email_id`='$email',`contact_person_name`='$cpname',c_date=now(),c_user='$userid',status='$status' where s_id='$sid'";
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

function vendergrid() {
 $res = ''; 

	 $rs = mysql_query("SELECT COUNT(*) FROM vender_master") or die("Count query error!");
  list($total) = mysql_fetch_row($rs);
  $total_pages = ceil($total / MAX_REC_PER_PAGE);
  $page = intval(@$_GET["page"]); 
  if (0 == $page){   $page = 1;   }  
  $start = MAX_REC_PER_PAGE * ($page - 1);
  $max = MAX_REC_PER_PAGE;
    
 $res .= '<div class="box box-primary">
                                <div class="box-header">
                                    <i class="ion ion-clipboard"></i>
                                    <h3 class="box-title"><b>Vender List</b></h3>';
									
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
                                            <th>VENDER NAME</th>
											<th> VENDER ADDRESS</th>
                                            <th>CONTACT NUMBER</th>
											<th>EMAIL ID</th>
											<th>CONTACT PERSON NAME</th>
                                             <th>STATUS</th>
											  <th>&nbsp;</th>
                                        </tr> ';
										
             $select_query =  "SELECT `s_id`, `vender_name`, `vender_address`, `contact_no`, `email_id`, `contact_person_name`, `c_date`, `c_user`, `status` FROM `vender_master` ORDER BY vender_name desc";
	   //echo $select_query;
	 $i=$start + 1;
    $resultk = mysql_query($select_query);
		    while ($rowk = mysql_fetch_array($resultk)) {
	if($rowk["status"]=="A") $status="Active";
	if($rowk["status"]=="I") $status="InActive";
	
    $res .= '<tr><td align="left"> '.$i.'  </td><td align="left">  '.$rowk["vender_name"].'  </td> <td align="left">  '.$rowk["vender_address"].'   </td><td align="left">  '.$rowk["contact_no"].'   </td><td align="left">  '.$rowk["email_id"].'   </td><td align="left">  '.$rowk["contact_person_name"].'   </td><td align="left"> '.$status.'  </td><td align="center"> &nbsp; <a href="vendermaster.php?edm=edit&icode='.$rowk["s_id"].'" class="ask"><img src="img/user_edit.png" /></a> &nbsp; <a href="vendermaster.php?edm=del&del=dels&icode='.$rowk["s_id"].'" class="ask"><img src="img/trash.png" /></a></td></tr>';
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