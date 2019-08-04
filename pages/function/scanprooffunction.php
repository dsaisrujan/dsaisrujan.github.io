 <?php
 include_once '../../includes/db_connect.php';

$pages="";
define('MAX_REC_PER_PAGE',10); 


function scanname($idcode,$idname,$simg,$status) {
 
   $query= "SELECT customer_id   FROM  id_proof_scanned_item_master 
                             WHERE upper(id_proof_scanned_item_code) = trim(upper('$idcode')) and upper(customer_id) = trim(upper('$idname')) and upper(id_proof_image) = trim(upper('$simg')) and upper(status) = trim(upper('$status'))";
	//echo $query;						 
   $result=mysql_query($query);
$num=mysql_numrows($result);

    if ($result) {
         
        if ($num > 0) 
  {
            return false;
        } else {
            return true;
        }

    }
}
   

function scanmaster($idcode,$idname,$simg,$status) {
$res = ''; 
 $query3= "SELECT customer_id FROM id_proof_scanned_item_master WHERE id_proof_scanned_item_code ='$idcode'";
echo  $query3;
     $result=mysql_query($query3);
	 $num=mysql_numrows($result);
 $query =  "insert into id_proof_scanned_item_master(customer_id,id_proof_image,status) values('$idname','$simg','$status')" ;
 $query1 = "update id_proof_scanned_item_master set customer_id='$idname',id_proof_image='$simg',status='$status'  where id_proof_scanned_item_code='$idcode'";
 echo  $query1;

	 if ($num > 0) {
            $result=mysql_query($query1);
			$res = 'Your Data was updated.'; 
        } else {
           $result=mysql_query($query);
		   	$res = 'Your Data was created.'; 
        }
  
	return 	$res; 
}

function scangrid() {
 $res = ''; 

	 $rs = mysql_query("SELECT COUNT(*) FROM id_proof_scanned_item_master") or die("Count query error!");
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
                                           <th height="76">ID</th>
                                          <th>PROOF  Name</th>
                                             <th>Status</th>
											  <th>&nbsp;</th>
                                        </tr> ';
										
             $select_query = "SELECT id_proof_scanned_item_code,customer_id,id_proof_image,status  from `id_proof_scanned_item_master`  ORDER BY id_proof_scanned_item_code ASC LIMIT $start, $max";
	   // echo  $select_query;
	 $i=$start + 1;
    $resultk = mysql_query($select_query);
		    while ($rowk = mysql_fetch_array($resultk)) {
	if($rowk["status"]=="A") $status="Active";
	if($rowk["status"]=="I") $status="InActive";
	
    $res .= '<tbody><tr><td align="left"><b> '.$i.'</b>  </td><td align="left"> <b> '.$rowk["id_proof_image"].'</b>   </td> <td align="left"><b> '.$status.'</b>  </td><td align="center"> &nbsp; <a href="scanproof.php?edm=edit&icode='.$rowk["id_proof_scanned_item_code"].'" ><img src="img/user_edit.png" /></a> &nbsp; <a href="scanproof.php?edm=del&del=dels&icode='.$rowk["id_proof_scanned_item_code"].'" class="ask"><img src="img/trash.png" /></a></td></tr>';
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

function scanedit($icode,$edm){

$sal = '';

}		
 