<?php
include_once '../../includes/db_connect.php';

$pages="";
define('MAX_REC_PER_PAGE',10); 

function itemidname1($itemcode) {
 
  $query= "SELECT item_code   FROM item_master  WHERE upper(item_code) = trim(upper('$itemcode') and upper(item_name) = trim(upper('$itemname') and   upper(status) = trim(upper('$status'))))";
   
   
   $result=mysql_query($query);
$num=mysql_numrows($result);
echo $num;
    if ($result) {
         
        if ($num > 0) {
            return false;
        } else {
            return true;
        }

    }
}
   

function imaster($itemcode,$itemname,$status,$date,$units,$userid) {
$res = ''; 
 $query3= "SELECT item_code FROM item_master WHERE item_code ='$itemcode'";
 
     $result=mysql_query($query3);
	 $num=mysql_numrows($result);
	  $msdate = implode(array_reverse(explode("^" , $date)), "-");
 $query =  "insert into item_master(item_code,item_name,status,item_date,no_of_units,user_id) values('$itemcode','$itemname','$status','$msdate','$units','$userid')" ;
 $query1 = "update item_master set item_code='$itemcode',item_name='$itemname',status='$status',item_date='$msdate',no_of_units='$units',user_id='$userid'  where item_code='$itemcode'";
// echo $query1;
	 if ($num > 0) {
            $result=mysql_query($query1);
			$res = 'Your Data was updated.'; 
        } else {
           $result=mysql_query($query);
		   	$res = 'Your Data was created.'; 
        }
  
	return 	$res; 
}

function igrid() {
 $res = ''; 

  $rs = mysql_query("SELECT COUNT(*) FROM  item_master") or die("Count query error!");
  list($total) = mysql_fetch_row($rs);
  $total_pages = ceil($total / MAX_REC_PER_PAGE);
  $page = intval(@$_GET["page"]); 
  if (0 == $page){   $page = 1;   }  
  $start = MAX_REC_PER_PAGE * ($page - 1);
  $max = MAX_REC_PER_PAGE;
    
  $res .= '<div class="box box-primary">
                                <div class="box-header">
                                    <i class="ion ion-clipboard"></i>
                                    <h3 class="box-title">Employee List</h3>';
									
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
								           <th>Item code</th>
										    <th>Item Name</th>
                                               <th>Status</th>
											      <th>&nbsp;</th>
                                        </tr> ';
						

										
             $select_query =  "SELECT `item_code`, `item_name`, `status` FROM `item_master`   ORDER BY item_code ASC LIMIT $start, $max";
	 // echo  $select_query; 
	 $i=$start + 1;
    $resultk = mysql_query($select_query);
		    while ($rowk = mysql_fetch_array($resultk)) {
	if($rowk["status"]=="A") $status="Active";
	if($rowk["status"]=="I") $status="InActive";
	 
 $res .= '<tbody><tr><td align="left"><b> '.$i.'</b>  </td><td align="left"> <b> '.$rowk["item_code"].'</b> </td><td align="left"> <b> '.$rowk["item_name"].'</b> </td><td align="left"><b>'.$status.'</b></td> </td><td align="center"> &nbsp; <a href="itemmaster.php?edm=edit&icode='.$rowk["item_code"].'"><img src="images/user_edit.png" /></a> &nbsp; <a href="itemmaster.php?edm=del&del=dels&icode='.$rowk["item_code"].'" class="ask"><img src="images/trash.png" /></a></td></tr>';
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

