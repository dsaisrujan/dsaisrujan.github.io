<?php
include_once '../includes/db_connect.php';

$pages="";
define('MAX_REC_PER_PAGE',10); 

function dailytransname($desc,$amount,$amtype,$date,$toc,$ccno,$pm,$dcdate,$bank,$branch,$ifsc,$ccno1,$userid,$cdate,$status)
{
   $query= "SELECT `description`, `amount`, `amount_type`, `date_of_received`, `type_of_customer`, `credit_customer_no`, `payment_mode`, `dd_cq_date`, `bank`, `branch`, `ifsc_code`, `cc_no`, `user_id`, `c_date`, `status` FROM `daily_transactions` WHERE upper(description) = trim(upper('$desc')) and upper(amount) = trim(upper('$amount'))and upper(amount_type) = trim(upper('$amtype')) and upper(date_of_received) = trim(upper('$date'))and upper(type_of_customer) = trim(upper('$toc')) and upper(credit_customer_no) = trim(upper('$ccno')) and upper(payment_mode) = trim(upper('$pm')) and upper(dd_cq_date) = trim(upper('$dcdate')) and upper(bank) = trim(upper('$bank')) and upper(branch) = trim(upper('$branch')) and upper(ifsc_code) = trim(upper('$ifsc')) and upper(cc_no) = trim(upper('$ccno1'))and upper(c_date) = trim(upper('$cdate')) and upper(user_id) = trim(upper('$userid')) and upper(status) = trim(upper('$status'))" ;
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
   
function dailytransmaster($sid,$desc,$amount,$amtype,$date,$toc,$ccno,$pm,$dcdate,$bank,$branch,$ifsc,$ccno1,$userid,$cdate,$status) 
{
$res = ''; 
$DDate = Date("Y-m-d");
		$TTime = Time();

 $query3= "SELECT `credit_customer_no` FROM `daily_transactions` WHERE `s_id`='$sid'";
 //echo $query3;
     $result=mysql_query($query3);
	 $num=mysql_numrows($result);
	  //$msdate = implode(array_reverse(explode("^" , $cdate)), "-");
 $query = "INSERT INTO `daily_transactions`(`description`, `amount`, `amount_type`, `date_of_received`, `type_of_customer`, `credit_customer_no`, `payment_mode`, `dd_cq_date`, `bank`, `branch`, `ifsc_code`, `cc_no`, `user_id`, `c_date`, `status`) VALUES ('$desc','$amount','$amtype','$date','$toc','$ccno','$pm','$dcdate','$bank','$branch','$ifsc','$ccno1','$userid',now(),'$status')";
//echo $query;
 $query1 = "update daily_transactions set description='$desc',amount='$amount',amount_type='$amtype',`date_of_received`='$date',type_of_customer='$toc',credit_customer_no='$ccno',payment_mode='$pm',`dd_cq_date`='$dcdate',bank='$bank',branch='$branch',`ifsc_code`='$ifsc',cc_no='$ccno1',user_id='$userid',c_date=now(),status='$status' where s_id='$sid'";
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

function  dailytransgrid() {
 $res = ''; 

	 $rs = mysql_query("SELECT COUNT(*) FROM product_master") or die("Count query error!");
  list($total) = mysql_fetch_row($rs);
  $total_pages = ceil($total / MAX_REC_PER_PAGE);
  $page = intval(@$_GET["page"]); 
  if (0 == $page){   $page = 1;   }  
  $start = MAX_REC_PER_PAGE * ($page - 1);
  $max = MAX_REC_PER_PAGE;
    
 $res .= '<div class="box box-primary">
                                <div class="box-header">
                                    <i class="ion ion-clipboard"></i>
                                    <h3 class="box-title"><b>Daily Trans List</b></h3>';
									
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
											<th>DESCRIPTION</th>
                                            <th>AMOUNT</th>
											<th>AMOUNT TYPE</th>
                                             <th>STATUS</th>
											  <th>&nbsp;</th>
                                        </tr> ';
										
             $select_query =  "SELECT `s_id`, `description`, `amount`, `amount_type`, `date_of_received`, `type_of_customer`, `credit_customer_no`, `payment_mode`, `dd_cq_date`, `bank`, `branch`, `ifsc_code`, `cc_no`, `user_id`, `c_date`, `status` FROM `daily_transactions` ORDER BY description desc";
	   //echo $select_query;
	 $i=$start + 1;
    $resultk = mysql_query($select_query);
		    while ($rowk = mysql_fetch_array($resultk)) {
	if($rowk["status"]=="A") $status="Active";
	if($rowk["status"]=="I") $status="InActive";
	
    $res .= '<tr><td align="left"> '.$i.'  </td><td align="left">  '.$rowk["description"].'   </td><td align="left">  '.$rowk["amount"].'  </td> <td align="left">  '.$rowk["amount_type"].'   </td><td align="left"> '.$status.'  </td><td align="center"> &nbsp; <a href="dailytransactionmaster.php?edm=edit&icode='.$rowk["s_id"].'" class="ask"><img src="img/user_edit.png" /></a> &nbsp; <a href="dailytransactionmaster.php?edm=del&del=dels&icode='.$rowk["s_id"].'" class="ask"><img src="img/trash.png" /></a></td></tr>';
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