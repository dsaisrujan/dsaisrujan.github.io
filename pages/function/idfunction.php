<?php

include_once '../../includes/db_connect.php';

$pages="";
define('MAX_REC_PER_PAGE',10); 
function idproofname($idcode,$idname,$userid,$cdate,$status) {
 $query3 = "SELECT id_proof_name  FROM id_proof_type_master 
                             WHERE  upper(id_proof_type_code) = trim(upper('$idcode')) and upper(id_proof_name) = trim(upper('$idname')) and  upper(status) = trim(upper('$status'))";
   //echo $query3;

   $result=mysql_query($query3);
$num=mysql_numrows($result);

    if ($result) {
         
        if ($num > 0) {
            return false;
        } else {
            return true;
        }

    }
}
   
function idproofmaster($idcode,$idname,$userid,$cdate,$status) {
//echo 'shashi';
$res = ''; 
 $query= "SELECT id_proof_name  FROM id_proof_type_master WHERE id_proof_type_code='$idcode'";
// echo  $query;
     $result=mysql_query($query);
	 $num=mysql_numrows($result);
 
 
$query =  "insert into id_proof_type_master(id_proof_name,`c_user`, `c_date`,status) values('$idname','$userid',now(),'$status')" ;
 $query1 = "update id_proof_type_master set id_proof_name='$idname',`c_user`='$userid',`c_date`=now(),status='$status' where id_proof_type_code='$idcode'";
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


function idproofgrid() {

 $res = ''; 

$rs = mysql_query("SELECT COUNT(*) FROM id_proof_type_master") or die("Count query error!");
  list($total) = mysql_fetch_row($rs);
  $total_pages = ceil($total / MAX_REC_PER_PAGE);
  $page = intval(@$_GET["page"]); 
  if (0 == $page){   $page = 1;   }  
  $start = MAX_REC_PER_PAGE * ($page - 1);
  $max = MAX_REC_PER_PAGE;
    
  $res .= '<div class="box box-primary">
                                <div class="box-header">
                                    <i class="ion ion-clipboard"></i>
                                    <h3 class="box-title"><b>Proof List</b></h3>';
									
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
		 $res .= '					  <table class="table table-hover">
                                        <tr>
                                            <th>ID</th>
                                            <th>PROOF NAME</th>
                                             <th>STATUS</th>
											  <th>&nbsp;</th>
                                        </tr> ';
										
             $select_query =  "SELECT `id_proof_type_code`, `id_proof_name`,`c_user`, `c_date`, `status` FROM `id_proof_type_master`  ORDER BY id_proof_name desc";
	    
	 $i=$start + 1;
    $resultk = mysql_query($select_query);
		    while ($rowk = mysql_fetch_array($resultk)) {
	if($rowk["status"]=="A") $status="Active";
	if($rowk["status"]=="I") $status="InActive";
	
    $res .= '<tr><td align="left"> '.$i.'  </td><td align="left">  '.$rowk["id_proof_name"].'   </td> <td align="left"> '.$status.'  </td><td align="center"> &nbsp; <a href="idproof.php?edm=edit&icode='.$rowk["id_proof_type_code"].'" class="ask"><img src="img/user_edit.png" /></a> &nbsp; <a href="idproof.php?edm=del&del=dels&icode='.$rowk["id_proof_type_code"].'" class="ask"><img src="img/trash.png" /></a></td></tr>';
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

function idproofedit($icode,$edm){

$sal = '';

}		
 ?>