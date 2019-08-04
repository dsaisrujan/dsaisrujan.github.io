<?php
include_once '../../includes/db_connect.php';
include_once '../../includes/functions.php';   
include_once("header.php");
$pages="";
define('MAX_REC_PER_PAGE',10); 




function myview($startdate,$enddate,$customername) {
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
											 	 <th>BILL NUMBER</th>
                                            <th>TOTAL AMOUNT</th>
											<th>DATE</th>	 
                                        </tr> ';
										$msdate = implode(array_reverse(explode("^" , $startdate)), "-");
										$mdate = implode(array_reverse(explode("^" , $enddate)), "-");
										
									$whelink=""; 						 
						
                                               if($msdate!="" && $mdate!="" && $customername!="" ) { $whelink.= "where (S.DATE BETWEEN '$msdate' AND '$mdate') and (S.credit_customer_code='$customername')";}	
						elseif($customername!="")	{ $whelink.= "where (S.credit_customer_code='$customername')";}
						elseif($msdate!="" && $mdate!="")
						{
						$whelink.= "where (S.DATE BETWEEN '$msdate' AND '$mdate')";}				
						
									
             $select_query =  "select (SELECT`credit_customer_name` from credit_customer_master where credit_customer_code=s.credit_customer_code) as name , `bill_no` , `total_amount_bal` , `bill_date`
FROM `bill_entry` S ".$whelink." ";
//echo $select_query;
	 $i=$start + 1;
    $resultk = mysql_query($select_query);
		    while ($rowk = mysql_fetch_array($resultk)) {
	
	
   $res .= '<tbody><tr><td align="left"><b> '.$i.'</b>  </td><td align="left"> <b> '.$rowk["name"].'</b>   </td> <td align="left"> <b> '.$rowk["bill_no"].'</b> </td> <td align="left"> <b> '.$rowk["total_amount_bal"].'</b></td><td align="left"> <b> '.$rowk["bill_date"].'</b>  </td> </tr>';
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
 