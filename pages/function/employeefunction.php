<?php
include_once 'db_connect.php';

$pages="";
define('MAX_REC_PER_PAGE',10); 

function eemployeename($ename,$add1,$add2,$cno,$eid,$iptc,$sphoto,$idm1,$idm2,$roleid,$userid,$status) {
 
   $query= "SELECT `emp_name`, `address1`, `address2`,`contact_no`, `email_id`, `id_proof_type_code`, `id_proof_image`, `id_marks1`, `id_marks2`,`role_id`,`s_id_user`,`status`  FROM employee_master WHERE upper(emp_name) = trim(upper('$ename')) and upper(address1) = trim(upper('$add1'))and upper(address2) = trim(upper('$add2')) and upper(contact_no) = trim(upper('$cno'))and upper(email_id) = trim(upper('$eid')) and upper(id_proof_type_code) = trim(upper('$iptc')) and upper(id_proof_image) = trim(upper('$sphoto')) and upper(id_marks1) = trim(upper('$idm1')) and upper(id_marks2) = trim(upper('$idm2')) and upper(role_id) = trim(upper('$roleid')) and upper(s_id_user) = trim(upper('$userid')) and upper(status) = trim(upper('$status'))" ;
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
   
function eemployeemaster($ecode,$user,$ename,$add1,$add2,$category,$cno,$eid,$iptc,$sphoto,$idm1,$idm2,$roleid,$userid,$cdate,$status) {
$res = ''; 
$DDate = Date("Y-m-d");
		$TTime = Time();
	$password=generatePassword(12, 1, 2, 3);
	 $query= "SELECT emp_name FROM employee_master WHERE emp_code='$ecode'";
	//echo $query;
     $result=mysql_query($query);
	 $num=mysql_numrows($result);

 $query =  "INSERT INTO `employee_master`(`emp_name`, `address1`, `address2`,category, `contact_no`, `email_id`, `id_proof_type_code`, `id_proof_image`, `id_marks1`, `id_marks2`,`role_id`,`s_id_user`,`c_date`,`status`) VALUES ('$ename','$add1','$add2','$category','$cno','$eid','$iptc','$sphoto','$idm1','$idm2','$roleid','$userid',now(),'$status')" ;
//echo  $query;

 $query1 = "update employee_master set emp_name='$ename',address1='$add1',address2='$add2',category='$category',contact_no='$cno',id_marks1='$idm1',id_marks2='$idm2',email_id='$eid',id_proof_type_code='$iptc',id_proof_image='$sphoto',role_id='$roleid',s_id_user='$userid',`c_date`=now(),status='$status' where emp_code='$ecode'";
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
			 $sqry = "select emp_code from employee_master where emp_name='".$ename."'";
			 $resultq = mysql_query($sqry);
			 $nrows=mysql_fetch_array($resultq);
			 $seid = $nrows["emp_code"];
			 
			$query="SELECT * FROM `user_master`  where USER_CATG='emp' and REFERENCE_CODE=(select emp_code from employee_master where emp_name='".$ename."')";
			$result=mysql_query($query);
			$num=mysql_numrows($result);
	 
	 
			$i=0;
				if ($i < $num) {
				 
					$nrow=mysql_fetch_array($result);
					//$res .=  '<h3>This User Id & Password Already Exists</h3>';
					$res .='<p align="center"> <h2> User ID : '.$nrow["USER_ID"].'</h2></p>'; 
					
				}else{
					$sql_inser= "insert into user_master( `USER_ID`, `PASSWORD`, `REFERENCE_CODE`, `USER_CATG`,`email_id`, `DATE_CREATED`, `STATUS_FLAG`, `salt`) values('$userids','$passwd', '$seid', 'emp','$eid','$DDate','A','$random_salt')";
					//echo $sql_inser;	 
			$resul_inser= mysql_query($sql_inser) or die('could not connect');
					if(!$resul_inser){ echo "Database error occured";}
					$res .= '<p align="center"> <h2> User ID : '.$userids.'</h2></p>';
					$res .= '<p align="center"> <h2> Password : '.$passwrd.'</h2></p>';
				}
			}
		}
  
	return 	$res; 
} 


function eemployeegrid() {
 $res = ''; 

	 $rs = mysql_query("SELECT COUNT(*) FROM employee_master") or die("Count query error!");
  list($total) = mysql_fetch_row($rs);
  $total_pages = ceil($total / MAX_REC_PER_PAGE);
  $page = intval(@$_GET["page"]); 
  if (0 == $page){   $page = 1;   }  
  $start = MAX_REC_PER_PAGE * ($page - 1);
  $max = MAX_REC_PER_PAGE;
    
  $res .= '<div class="box box-primary">
                                <div class="box-header">
                                    <i class="ion ion-clipboard"></i>
                                    <h3 class="box-title"><b>Employee List</b></h3>';
									
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
								        <th>EMPLOYEE NAME</th>
                                            <th>EMAIL ID</th>
											<th>CONTACT NUMBER</th>
                                             <th>STATUS</th>
											      <th>&nbsp;</th>
                                        </tr> ';
						

										
             $select_query =  "SELECT `emp_code`, `emp_name`, `address1`, `address2`,category, `contact_no`, `email_id`, `id_proof_type_code`, `id_proof_image`, `id_marks1`, `id_marks2`, `status` FROM `employee_master`  ORDER BY emp_name desc";
	   //echo  $select_query; 
	 $i=$start + 1;
    $resultk = mysql_query($select_query);
		    while ($rowk = mysql_fetch_array($resultk)) {
	if($rowk["status"]=="A") $status="Active";
	if($rowk["status"]=="I") $status="InActive";
	 
 $res .= '<tr><td align="left"> '.$i.'  </td><td align="left">  '.$rowk["emp_name"].' </td><td align="left">  '.$rowk["email_id"].' </td><td align="left"> '.$rowk["contact_no"].'</td> <td align="left">'.$status.'</td> </td> <td align="center"> &nbsp; <a href="employeemaster.php?edm=edit&icode='.$rowk["emp_code"].'"><img src="img/user_edit.png" /></a> </td></tr>';
 //<a href="employeemaster.php?edm=del&del=dels&icode='.$rowk["emp_code"].'"><img src="img/trash.png" /></a>
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
?>
