<?php
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';
$pages="";
define('MAX_REC_PER_PAGE',10); 

function franchpurches($invoiceid,$sby,$authorized_by,$tamount,$invcedate,$recivdate,$desc,$status)
{
 
   $query= "SELECT upper(franch_pur_invoice_number),status FROM franch_purchase_order_master
 
                             WHERE upper(franch_pur_invoice_number) = upper('$invoiceid') and upper(franch_pur_invoice_date)=upper('$invcedate') and upper(recieved_by)=upper('$authorized_by') and upper(suppllied_by)=upper('$sby') and upper(franch_product_received_date)=upper('$recivdate') and upper(franch_product_amt)=upper('$tamount')  and upper(status)=upper('$status')";
 //echo $query; 
   $result=mysql_query($query);
$num=mysql_num_rows($result);

    if ($result) {
         
        if ($num > 0) {
            return false;
        } else {
        return true;
        }

    }
}
  
function franchpurchesmaster($sid,$invoiceid,$sby,$authorized_by,$tamount,$invcedate,$recivdate,$desc,$userid,$status) 
{
 $res = ''; 
$DDate = Date("Y-m-d");
		$TTime = Time();
	
	 $query= "SELECT `franch_purchase_order_id`, `franch_pur_invoice_number`, `franch_pur_invoice_date`, `franch_product_received_date`, `suppllied_by`, `recieved_by`, `comments`, `franch_product_amt`, `created_by`, `created_date`, `modified_date`, `status` FROM `franch_purchase_order_master`='$sid'  ";
     $result=mysql_query($query);
	 $num=mysql_num_rows($result);
//echo $query;
 $query =  "INSERT INTO `franch_purchase_order_master`(`franch_pur_invoice_number`, `franch_pur_invoice_date`,`suppllied_by`, `recieved_by`,
  `comments`,`franch_product_received_date`, `franch_product_amt`, `created_by`, `created_date`, `status`) values(upper('$invoiceid'),'$invcedate','$sby','$authorized_by','$desc','$recivdate','$tamount','$userid','$DDate','$status')" ;
  
 $query1 = "UPDATE `franch_purchase_order_master` SET `franch_pur_invoice_number`='$invoiceid',`suppllied_by`='$sby', `recieved_by`='$authorized_by', `comments`='$desc',`franch_pur_invoice_date`='$invcedate',`franch_product_received_date`='$recivdate',`franch_product_amt`='$tamount',created_by='$userid',modified_date='$DDate',status='$status'  where franch_package_id='$sid'";
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

function frachpurchesgrid() {
 $res = '';  
  $res .= '<div class="box box-primary">
                                <div class="box-header">
                                    <i class="ion ion-clipboard"></i>
                                    <h3 class="box-title">Purches order List</h3>';
									
      $res .= '                               <div class="box-tools pull-right"> ';
	   
     $res .= '                                </div> 
                                </div><!-- /.box-header -->
                                <div class="box-body" style="overflow:auto;max-height:300px;"> ';
		 $res .= '						
                                     <table class="table table-hover">
                                        <tr>
                                            <th>ID</th>
                                            <th>Invoice Order NO</th>
											<th>Procure Date </th>
											<th>Date Of Authorised</th>
											<th>Authorised By</th>
											<th>Invoice Amount</th>
                                             <th>Status</th>
											 
                                        </tr> ';
										
             $select_query =  "SELECT `s_id`, `invoice_id`, `procure_date`,DATE_FORMAT(procure_date,'%d/%m/%Y %H:%m:%s') as procure_date1, `date_of_authorised`,DATE_FORMAT(date_of_authorised,'%d/%m/%Y %H:%m:%s') as date_of_authorised1, `authorized_by`, `invoice_amount`, `description`, `USER_ID`, `created_date`, `status` FROM `purches_master` ORDER BY created_date ASC ";
	// echo  $select_query ;  
	 $i=1;
    $resultk = mysql_query($select_query);
		 $num = mysql_num_rows($resultk);  
 while ($rowk = mysql_fetch_array($resultk)) {
	if($rowk["status"]=="A") $status="Active";
	if($rowk["status"]=="I") $status="InActive";
	
    $res .= '<tr><td align="left"> '.$i.'  </td><td align="left">  '.$rowk["invoice_id"].'   </td>  <td align="left">  '.$rowk["procure_date1"].'   </td> <td align="left">  '.$rowk["date_of_authorised1"].'   </td><td align="left">'.$rowk["authorized_by"].'</td><td align="left">  '.$rowk["invoice_amount"].'   </td><td align="left"> '.$status.'  </td></tr>';
			$i=$i+1;
			
    }
 
		               $res .= '                     </table>
                                </div><!-- /.box-body -->
                           
                            </div><!-- /.box --> ';
	return $res;
 
  
}				
 