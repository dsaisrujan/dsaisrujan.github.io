<?php
include_once  '../../includes/db_connect.php';
$pages="";
define('MAX_REC_PER_PAGE',10); 

function  ccustomerbillgrid() {
 $res = ''; 

	 $rs = mysql_query("SELECT COUNT(*) FROM bill_entry") or die("Count query error!");
  list($total) = mysql_fetch_row($rs);
  $total_pages = ceil($total / MAX_REC_PER_PAGE);
  $page = intval(@$_GET["page"]); 
  if (0 == $page){   $page = 1;   }  
  $start = MAX_REC_PER_PAGE * ($page - 1);
  $max = MAX_REC_PER_PAGE;
    
  $res .= '<div class="box box-primary">
                                <div class="box-header">
                                    <i class="ion ion-clipboard"></i>
                                    <h3 class="box-title"><b>Credit Customer Bill List</b></h3>';
									
      $res .= '                               <div class="box-tools pull-right"> ';
	    $res .= '                                 <ul class="pagination pagination-sm inline">';
	   for ($i = 1; $i <= $total_pages; $i++) {
  $txt = $i;
   
 /* if($page>1){   $res .= '   <li><a href="file:///E|/Dell 11/Desktop/pump/functions/'. $_SERVER["PHP_SELF"] . '?page='.$i-1.'\">&laquo;</a></li>  '; }
   $res .= '  <li><a href="file:///E|/Dell 11/Desktop/pump/functions/'. $_SERVER["PHP_SELF"] . '?page='.$i.'\">'.$txt.'</a></li>
                                            <li><a href="file:///E|/Dell 11/Desktop/pump/functions/'. $_SERVER["PHP_SELF"] . '?page='.$i+1.'\">'.$txt+1.'</a></li>
                                            <li><a href="file:///E|/Dell 11/Desktop/pump/functions/'. $_SERVER["PHP_SELF"] . '?page='.$i+2.'\">'.$txt+2.'</a></li> ';
  
    if($page>1){   $res .= '   <li><a href="file:///E|/Dell 11/Desktop/pump/functions/'. $_SERVER["PHP_SELF"] . '?page='.$i+3.'\">&raquo;</a></li>  '; }*/
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
                                     <table  valign="top" class="table table-hover"  width="100%">
                                       <tr valign="top">
                                            <th>ID</th>
                                            <th>BILL NUMBER</th>
											<th>BILL TYPE</th>
											<th>CARD HOLDER NAME</th>
											<th>CUSTOMER NAME</th>
											
											<th>AMOUNT</th>
                                            
											  <th>&nbsp;</th>
                                        </tr> ';
										
            /* SELECT `bill_no`, `bill_number`, `bill_type`, `cardholder_name`,(SELECT `credit_customer_name` FROM `credit_customer_master` WHERE `credit_customer_code`=b.`credit_customer_code`)cname,(SELECT DATE_FORMAT(`bill_date`,'%d/%m/%Y %H:%m')date FROM `bill_detail_entry`)sdate,(SELECT `cc_vehicle_no` FROM `creditcustomer_vechicle_master` WHERE `cc_s_id`=(SELECT `vehicle_code` FROM `bill_detail_entry` WHERE `bill_no`=b.`bill_no`))bvcl,
			 (SELECT `produt_name` FROM `product_master` WHERE `s_id`=(SELECT `item_code` FROM `bill_detail_entry` WHERE `bill_no`=b.`bill_no`))product,
			 (SELECT `price` FROM `price_master` WHERE `s_id`=(SELECT `price` FROM `bill_detail_entry` WHERE `bill_no`=b.`bill_no`))price1,(SELECT `item_quantity` FROM `bill_detail_entry` WHERE `bill_no`=b.`bill_no`)qty,(SELECT `vehicle_driver_name` FROM `bill_detail_entry` WHERE `bill_no`=b.`bill_no`)dname,`bill_amount`, `cc_payment_type`, `total_amount_bal`, `cc_payment_id`, `bill_created_user_id` FROM `bill_entry` b order by bill_no,bill_date*/
			 
			 $select_query =  "SELECT `bill_no`, `bill_number`, `bill_type`, `cardholder_name`, (SELECT `credit_customer_name` FROM `credit_customer_master` WHERE `credit_customer_code`=b.`credit_customer_code`)cname, `bill_amount`, `cc_payment_type`, `total_amount_bal`, `cc_payment_id`, `bill_created_user_id`, `c_date`, `status` FROM `bill_entry` b order by bill_no";
	  //echo $select_query;
	 $i=$start + 1;
    $resultk = mysql_query($select_query);
		    while ($rowk = mysql_fetch_array($resultk)) {
	if($rowk["status"]=="A") $status="Active";
	if($rowk["status"]=="I") $status="InActive";
	//echo $status;
   $res .= '<tr><td align="left"> '.$i.'  </td><td align="left">  '.$rowk["bill_number"].'  </td><td align="left">  '.$rowk["bill_type"].'  </td><td align="left">  '.$rowk["cardholder_name"].'  </td><td align="left">  '.$rowk["cname"].'  </td> <td align="left">  '.$rowk["bill_amount"].'  </td></tr>';
			$i=$i+1;
    }
 
		               $res .= '                     </table>
                                </div><!-- /.box-body -->
                              <!--  <div class="box-footer clearfix no-border">
                                    <button class="btn btn-default pull-right"><i class="fa fa-plus"></i> Add item</button>
                                </div>-->
                            </div><!-- /.box --> ';
	return $res;
	
	

  

  
}
?>