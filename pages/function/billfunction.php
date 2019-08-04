<?php
include_once 'db_connect.php';

 
$pages="";
define('MAX_REC_PER_PAGE',10); 

function billname($username,$billno,$totalamount,$DDate) {
 
   $query= "SELECT BILL_NUMBER  FROM  creditcustomet_mastertransaction WHERE upper(USER_NAME) = trim(upper('$username')) and upper(TOTAL_AMOUNT) = trim(upper('$totalamount')) and upper(DATE) = trim(upper('$DDate'))" ;
echo $query;
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
   


function billmaster($billno,$username,$billno,$totalamount,$DDate) {
 $res = ''; 
$DDate = Date("Y-m-d");
		
	
	 $query= "SELECT BILL_NUMBER FROM creditcustomer_mastertransaction WHERE BILL_NUMBER='$billno'";
     $result=mysql_query($query);
	 $num=mysql_numrows($result);
 //echo  $query;
 $query =  "INSERT INTO `creditcustomet_mastertransaction`(`USER_NAME` ) VALUES ('$username')" ;
 $query1 = "update creditcustomet_mastertransaction set USER_NAME='$username' where BILL_NUMBER='$billno'";
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

function billgrid() {
 $res = ''; 

	 $rs = mysql_query("SELECT COUNT(*) FROM creditcustomet_mastertransaction") or die("Count query error!");
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
   
 /* if($page>1){   $res .= '   <li><a href="file:///C|/Users/DELL11~1/AppData/Local/Temp/'. $_SERVER["PHP_SELF"] . '?page='.$i-1.'\">&laquo;</a></li>  '; }
   $res .= '  <li><a href="file:///C|/Users/DELL11~1/AppData/Local/Temp/'. $_SERVER["PHP_SELF"] . '?page='.$i.'\">'.$txt.'</a></li>
                                            <li><a href="file:///C|/Users/DELL11~1/AppData/Local/Temp/'. $_SERVER["PHP_SELF"] . '?page='.$i+1.'\">'.$txt+1.'</a></li>
                                            <li><a href="file:///C|/Users/DELL11~1/AppData/Local/Temp/'. $_SERVER["PHP_SELF"] . '?page='.$i+2.'\">'.$txt+2.'</a></li> ';
  
    if($page>1){   $res .= '   <li><a href="file:///C|/Users/DELL11~1/AppData/Local/Temp/'. $_SERVER["PHP_SELF"] . '?page='.$i+3.'\">&raquo;</a></li>  '; }*/
  if ($page != $i)
  $txt = ' <li align="center"><a href="file:///C|/Users/DELL11~1/AppData/Local/Temp/'. $_SERVER["PHP_SELF"] . '?page='.$i.'\">'.$txt.'</a> </li>';
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
								        <th><u><b>EmployeeName</b></u></th>
                                            <th><u><b>BillNumber</b></u></th>
											<th><u><b>Total Amount</b></u></th>
                                             <th><u><b>date</b></u></th>
											      <th>&nbsp;</th>
                                        </tr> ';
						

										
             $select_query =  "SELECT `USER_NAME`, `BILL_NUMBER`, `TOTAL_AMOUNT`, date  FROM `creditcustomet_mastertransaction`  ORDER BY BILL_NUMBER ASC LIMIT $start, $max";
	 //  echo  $select_query; 
	 $i=$start + 1;
    
 $res .= '<tbody><tr><td align="left"><b> '.$i.'</b>  </td><td align="left"> <b> '.$rowk["USER_NAME"].'</b> </td><td align="left"> <b> '.$rowk["BILL_NUMBER"].'</b> </td><td align="left"> <b>'.$rowk["TOTAL_AMOUNT"].'</b></td> <td align="left"><b>'.$date.'</b></td> </td> <td align="center"> &nbsp; <a href="file:///C|/Users/DELL11~1/AppData/Local/Temp/Rar$DIa0.635/billmaster.php?edm=edit&amp;icode='.$rowk["BILL_NUMBER"].'"  title="Edit"><img src="file:///C|/Users/DELL11~1/AppData/Local/Temp/Rar$DIa0.635/images/user_edit.png" /></a> &nbsp; <a href="file:///C|/Users/DELL11~1/AppData/Local/Temp/Rar$DIa0.635/billmaster.php?edm=del&amp;del=dels&amp;icode='.$rowk["BILL_NUMBER"].'" class="ask" title="Delete"><img src="file:///C|/Users/DELL11~1/AppData/Local/Temp/Rar$DIa0.635/images/trash.png" /></a></td></tr>';
			$i=$i+1;
     
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

