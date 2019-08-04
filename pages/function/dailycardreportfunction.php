<?php
include_once '../../includes/db_connect.php';
include_once '../../includes/functions.php';   

$pages="";
define('MAX_REC_PER_PAGE',10); 




function myview($stdate) {
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
											 <th>CUSTOMER NAME</th>
											 	 <th>BILL NO</th>
                                            <th>TOTAL   AMOUNT</th>
											 
                                        </tr> ';
										
					$msdate = implode(array_reverse(explode("^" , $stdate)), "-");
									
             $select_query =  "select bill_no,cardholder_name,bill_amount from bill_entry where bill_date='$msdate' and bill_type='card'";


echo $select_query;
	 $i=$start + 1;
    $resultk = mysql_query($select_query);
		    while ($rowk = mysql_fetch_array($resultk)) {
	
	
   $res .= '<tbody><tr><td align="left"><b> '.$i.'</b>  </td><td align="left"> <b> '.$rowk["cardholder_name"].'</b>   </td> <td align="left"> <b> '.$rowk["bill_no"].'</b> </td> <td align="left"> <b> '.$rowk["bill_amount"].'</b></td></tr>';
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
 