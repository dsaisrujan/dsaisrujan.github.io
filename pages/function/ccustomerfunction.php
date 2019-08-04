<?php

include_once  '../../includes/db_connect.php';
$pages="";
define('MAX_REC_PER_PAGE',10); 


function  customername($cuname,$address,$address1,$agname,$mailid,$crlimit,$prcode,$sphoto,$userid,$cell,$roled,$status){
 
   $query= "SELECT credit_customer_name, cc_address1,cc_address2,cc_agency_name,email_id,cc_credit_limit,cc_id_proof_type_code,id_proof_image,user_id,cc_mobile_no,role_id,status FROM  credit_customer_master 
                             WHERE upper(credit_customer_name) = trim(upper('$cuname')) and upper(cc_address1) = trim(upper('$address')) and upper(cc_address2) = trim(upper('$address1')) and upper(cc_agency_name) = trim(upper('$agname'))and upper(email_id) = trim(upper('$mailid')) and upper(cc_credit_limit) = trim(upper('$crlimit'))and upper(cc_register_date) = trim(upper('$crlimit'))  and upper(cc_id_proof_type_code) = trim(upper('$prcode')) and upper(id_proof_image) = trim(upper('$sphoto')) and upper(user_id) = trim(upper('$userid')) and upper(cc_mobile_no) = trim(upper('$cell')) and upper(role_id) = trim(upper('$roled')) and upper(status) = trim(upper('$status'))";
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
function customermaster($ccode,$user,$cuname,$category,$address,$address1,$agname,$mailid,$crlimit,$rgdate,$prcode,$sphoto,$userid,$cell,$roled,$status) {
$res = ''; 

$DDate = Date("Y-m-d");
		$TTime = Time();

 $query3= "SELECT credit_customer_name, cc_register_date FROM credit_customer_master WHERE credit_customer_code='$ccode'";
//echo $query3;
 $result=mysql_query($query3);
$num=mysql_numrows($result);
//$msdate = implode(array_reverse(explode("^" , $rgdate)), "-");
 //echo  $query;$password=generatePassword(12, 1, 2, 3);
 //$password=generatePassword(12, 1, 2, 3);
  //  echo '...'. $msdate; 
 
 
 $query =   "insert into credit_customer_master(credit_customer_name,category, cc_address1,cc_address2,cc_agency_name,email_id,cc_credit_limit,cc_register_date,cc_id_proof_type_code,id_proof_image,user_id,cc_mobile_no,role_id,status) values('$cuname','$category','$address','$address1','$agname','$mailid','$crlimit',now(),'$prcode','$sphoto','$userid','$cell','$roled','$status')" ;
//echo  $query;
  
 $query1 = "update credit_customer_master set credit_customer_name='$cuname',category='$category', cc_address1='$address',cc_address2='$address1',cc_agency_name='$agname',email_id='$mailid',cc_credit_limit='$crlimit',cc_register_date=now(),cc_id_proof_type_code='$prcode',id_proof_image='$sphoto',user_id='$userid',cc_mobile_no='$cell',role_id='$roled',status='$status'  where credit_customer_code='$ccode'";
//echo $query1;
	 if ($num > 0) {
            $result=mysql_query($query1);
			$res = 'Your Data was updated.'; 
        } else {
           $result=mysql_query($query);
		   	$res = 'Your Data was created.'; 
        }
  
	
		if($result){
					$output = preg_replace('/[^a-zA-Z0-9]/s', '', $user);
					$passwrd  = $output;
					$userids = $output;
		
		 
					$ranpwd= generatePassword(12, 1, 2, 3);
  
   		// Create a random salt
        $random_salt = hash('sha512', $ranpwd);
 
        // Create salted password 
        $passwd = hash('sha512', $passwrd . $random_salt);
		
        
       	$DDate = Date("Ymd");
		$TTime = Time();
	 
	 
		 if (($userids !="") && $user!="") {
			 $sqry = "select credit_customer_code from credit_customer_master where credit_customer_name='".$cuname."'";
			 $resultq = mysql_query($sqry);
			 $nrows=mysql_fetch_array($resultq);
			 $seid = $nrows["credit_customer_code"];
			 
			$query="SELECT * FROM `user_master`  where USER_CATG='cuser' and REFERENCE_CODE=(select credit_customer_code from credit_customer_master where credit_customer_name='".$cuname."')";
			//echo $query;
			$result=mysql_query($query);
			$num=mysql_numrows($result);
	 
	 
			$i=0;
				if ($i < $num) {
				 
					$nrow=mysql_fetch_array($result);
					//$res .=  '<h3>This User Id & Password Already Exists</h3>';
					$res .='<p align="center"> <h2> User ID : '.$nrow["USER_ID"].'</h2></p>'; 
					
				}else{
					$sql_inser= "insert into user_master( `USER_ID`, `PASSWORD`, `REFERENCE_CODE`, `USER_CATG`,`email_id`, `DATE_CREATED`, `STATUS_FLAG`, `salt`) values('$userids','$passwd', '$seid', 'cuser','$mailid','$DDate','A','$random_salt')";	 
			$resul_inser= mysql_query($sql_inser) or die('could not connect');
					if(!$resul_inser){ echo "Database error occured";}
					$res .= '<p align="center"> <h2> User ID : '.$userids.'</h2></p>';
					$res .= '<p align="center"> <h2> Password : '.$passwrd.'</h2></p>';
				}
			}
		}
  
	return 	$res; 
} 
function  customergrid() {
 $res = ''; 

	 $rs = mysql_query("SELECT COUNT(*) FROM credit_customer_master") or die("Count query error!");
  list($total) = mysql_fetch_row($rs);
  $total_pages = ceil($total / MAX_REC_PER_PAGE);
  $page = intval(@$_GET["page"]); 
  if (0 == $page){   $page = 1;   }  
  $start = MAX_REC_PER_PAGE * ($page - 1);
  $max = MAX_REC_PER_PAGE;
    
  $res .= '<div class="box box-primary">
                                <div class="box-header">
                                    <i class="ion ion-clipboard"></i>
                                    <h3 class="box-title"><b>Credit Customer List</b></h3>';
									
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
                                     <table  valign="top" class="table table-hover" >
                                       <tr valign="top">
                                            <th>ID</th>
                                            <th>CUSTOMER NAME</th>
                                             <th>STATUS</th>
											  <th>&nbsp;</th>
                                        </tr> ';
										
             $select_query =  "SELECT credit_customer_code,credit_customer_name,category, cc_address1,cc_address2,cc_agency_name,cc_credit_limit,cc_register_date,cc_id_proof_type_code,id_proof_image,user_id,cc_mobile_no,status FROM `credit_customer_master`  ORDER BY credit_customer_name desc ";
	   //echo $select_query;
	 $i=$start + 1;
    $resultk = mysql_query($select_query);
		    while ($rowk = mysql_fetch_array($resultk)) {
	if($rowk["status"]=="A") $status="Active";
	if($rowk["status"]=="I") $status="InActive";
	//echo $status;
   $res .= '<tr><td align="left"> '.$i.'  </td><td align="left">  '.$rowk["credit_customer_name"].'   </td> <td align="left"> '.$status.'  </td><td align="center"> &nbsp; <a href="creditcustomer.php?edm=edit&icode='.$rowk["credit_customer_code"].'"><img src="img/user_edit.png" /></a></td></tr>';
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