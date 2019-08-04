<?php

include_once '../../includes/db_connect.php';
$pages="";
define('MAX_REC_PER_PAGE',10); 
function childname($tno,$bno,$cuname,$pid,$price,$amount) {
 $query3 = "SELECT transaction_number  FROM  creditcustomer_childtransaction 
                             WHERE  upper(transaction_number) = trim(upper('$tno')) and upper(bill_number) = trim(upper('$bno')) and  upper(customer_name) = trim(upper('$cuname') and upper( 	product_id) = trim(upper('$pid')) and upper(price) = trim(upper('$price')) and  upper(amount) = trim(upper('$amount'))";
   echo $query3;

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

   
function childmaster($tno,$bno,$cuname,$pid,$price,$amount) {
//echo 'shashi';
$res = ''; 
 $query= "SELECT transaction_number  FROM creditcustomer_childtransaction WHERE transaction_number='$idcode'";
// echo  $query;
     $result=mysql_query($query);
	 $num=mysql_numrows($result);
 $query54= "SELECT max(bill_number)+1 as bill_number FROM creditcustomet_mastertransaction";
 echo $query54;
 $resultn=mysql_query($query54);
 //echo $resultn;
 while ($rowk = mysql_fetch_array($resultn)) 
 {
$bno=$rowk["bill_number"];
echo 'my value is'.$bno;
}
$query =  "insert into creditcustomer_childtransaction(bill_number,customer_name,product_id,price,amount) values('$bno','$cuname','$pid','$price','$amount')" ;
 $query1 = "update creditcustomer_childtransaction set bill_number='$bno', customer_name='$cuname',product_id='$pid' , price='$price',amount='$amount' where transaction_number='$idcode'";
echo $query;
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


function childgrid() {

$res = ''; 

	 $rs = mysql_query("SELECT COUNT(*) FROM creditcustomer_childtransaction") or die("Count query error!");
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
						
		 $res .= '					  <table class="table table-hover">
                                        <tr>
                                            <th>ID</th>
                                            <th>bill number</th>
                                             <th>customer name</th>
											 <th>amount</th>
											  <th>&nbsp;</th>
                                        </tr> ';
										
             $select_query =  "SELECT  transaction_number,bill_number,customer_name,product_id,price,amount FROM `creditcustomer_childtransaction`  ORDER BY transaction_number ASC LIMIT $start, $max";
	   // echo $select_query;
	  $i=$start + 1;
    $resultk = mysql_query($select_query);
		    while ($rowk = mysql_fetch_array($resultk)) {
	
	
    $res .= '<tbody><tr><td align="left"><b> '.$i.'</b>  </td><td align="left"> <b> '.$rowk["bill_number"].'</b>   </td> <td align="left"> <b> '.$rowk["customer_name"].'</b>   </td>  <td align="left"> <b> '.$rowk["amount"].'</b>   </td><td align="center"> &nbsp; <a href="childbill.php?edm=edit&icode='.$rowk["bill_number"].'" class="ask"><img src="images/user_edit.png" /></a> &nbsp;  
	 <a href="childbill.php?edm=del&del=dels&icode='.$rowk["bill_number"].'" class="ask"><img src="images/trash.png" /></a></td></tr>';
			$i=$i+1;
    }
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
  
				

function childedit($icode,$edm){

$sal = '';

}		
 