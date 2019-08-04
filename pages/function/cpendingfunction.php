<?php
include_once '../../includes/db_connect.php';
include_once '../../includes/functions.php';   

$pages="";
define('MAX_REC_PER_PAGE',10); 




function myview($customername) {
 $res = ''; 

  $res .= '<div class="box box-primary">
                                <div class="box-header">
                                    <i class="ion ion-clipboard"></i>
                                    <h3 class="box-title" font color="#FF2222">CUSTOMER REPORT</h3>';
									
    
										
     $res .= '              </div><!-- /.box-header -->
                                <div class="box-body"> ';
		 $res .= '						
                                     <table class="table table-hover">
                                        <tr>
										
                                           <th>ID</th>
											 <th>CUSOMER NAME</th>
											 	 <th>CREDIT LIMIT</th>
                                            <th>TOTAL BALANCE  AMOUNT</th>
											 
                                        </tr> ';
										
										$sal="select max(bill_no) as bill from bill_entry where credit_customer_code='$customername'";
										 $resultf=mysql_query($sal);
 //echo $sal;
 {
 while ($rowk = mysql_fetch_array($resultf)) 
 {
$bno=$rowk["bill"];

}
}								
									
             $select_query =  "select (select credit_customer_name from credit_customer_master where `credit_customer_code`='$customername')name ,cc_credit_limit,(select `total_amount_bal` from bill_entry where `bill_no`= '$bno')amt from credit_customer_master where `credit_customer_code`='$customername'";


//echo $select_query;
	 $i=$start + 1;
    $resultk = mysql_query($select_query);
		    while ($rowk = mysql_fetch_array($resultk)) {
	
	
   $res .= '<tbody><tr><td align="left"><b> '.$i.'</b>  </td><td align="left"> <b> '.$rowk["name"].'</b>   </td> <td align="left"> <b> '.$rowk["cc_credit_limit"].'</b> </td> <td align="left"> <b> '.$rowk["amt"].'</b></td></tr>';
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
 