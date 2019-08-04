<?php
include_once '../../includes/db_connect.php';

 
$pages="";
define('MAX_REC_PER_PAGE',10); 

function pname($price,$ino,$pdate,$status) {
 
  $query= "SELECT item_code  FROM price_master  WHERE upper(price) = trim(upper('$price')) and upper(item_code) = trim(upper('$ino')) and upper(price_date) = trim(upper('$pdate')) and upper(status) = trim(upper('$status'))";
   
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
   

function pmaster($ino,$price,$pdate,$status) {
$res = ''; 
 $query3= "SELECT item_code FROM price_master WHERE item_code ='$ino'";
 //echo  $query;
     $result=mysql_query($query3);
	 $num=mysql_numrows($result);
	 $msdate = implode(array_reverse(explode("^" , $pdate)), "-");
 
 
 $query =  "insert into price_master(item_code,price,price_date,status) values('$ino','$price','$msdate','$status')" ;
 $query1 = "update price_master set item_code='$ino',price='$price',price_date='$msdate',status='$status'  where item_code='$ino'";
 
// echo $query1;
	 if ($num > 0) {
            $result=mysql_query($query1);
			$res = 'Your Data was updated.'; 
        } else {
           $result=mysql_query($query);
		   	$res = 'Your Data was created.'; 
        }
  
	return 	$res; 
}

function pgrid() {
 $res = '';
 $rs = mysql_query("SELECT COUNT(*) FROM price_master") or die("Count query error!");
  list($total) = mysql_fetch_row($rs);
  $total_pages = ceil($total / MAX_REC_PER_PAGE);
  $page = intval(@$_GET["page"]); 
  if (0 == $page){   $page = 1;   }  
  $start = MAX_REC_PER_PAGE * ($page - 1);
  $max = MAX_REC_PER_PAGE;
    
  $res .= '<div class="box box-primary">
                                <div class="box-header">
                                    <div align="center">
									<i class="ion ion-clipboard"></i>
                                  
								    <h3 class="box-title">List</h3>';
									
      $res .= '                               <div class="box-tools pull-right"> ';
	    $res .= '                                 <ul class="pagination pagination-sm inline">';
	   for ($i = 1; $i <= $total_pages; $i++) {
  $txt = $i;
   
 /* if($page>1){   $res .= '   <li><a href="../../functions/'. $_SERVER["PHP_SELF"] . '?page='.$i-1.'\">&laquo;</a></li>  '; }
   $res .= '  <li><a href="../../functions/'. $_SERVER["PHP_SELF"] . '?page='.$i.'\">'.$txt.'</a></li>
                                            <li><a href="../../functions/'. $_SERVER["PHP_SELF"] . '?page='.$i+1.'\">'.$txt+1.'</a></li>
                                            <li><a href="../../functions/'. $_SERVER["PHP_SELF"] . '?page='.$i+2.'\">'.$txt+2.'</a></li> ';
  
    if($page>1){   $res .= '   <li><a href="../../functions/'. $_SERVER["PHP_SELF"] . '?page='.$i+3.'\">&raquo;</a></li>  '; }*/
  if ($page != $i)
  $txt = ' <li align="center"><a href="../../functions/'. $_SERVER["PHP_SELF"] . '?page='.$i.'\">'.$txt.'</a> </li>';
 $insvalue .= '
      <li align="center">'. $txt .'</li> ';
      
  }
  
     $res .= '    </ul> ';
										
     $res .= '                                </div> 
                                </div><!-- /.box-header -->
                                <div class="box-body"> ';
		 $res .= '					<div align="center">	
                                     <table class="table table-hover">
                                        <tr>
                                           
                                            <th>Item Name</th>
											<th>price</th>
									
										       <th>&nbsp;</th>
                                        </tr> ';
										
     $select_query =  "SELECT `item_code`,(select item_name from item_master i where i.item_code=n.item_code)itemname, `price`,`price_date`,`status` FROM price_master n ORDER BY item_code ASC LIMIT $start, $max";
	    
	 $i=$start + 1;
    $resultk = mysql_query($select_query);
		    while ($rowk = mysql_fetch_array($resultk)) {
	if($rowk["status"]=="A") $status="Active";
	if($rowk["status"]=="I") $status="InActive";
	
   
   
   
   $res .= '<tbody><tr><td align="left"> <b> '.$rowk["itemname"].'</b></td><td align="left"> <b> '.$rowk["price"].'</b></td><td align="center"> &nbsp;<a href="pricemaster.php?edm=edit&icode='.$rowk["item_code"].'"><img src="img/user_edit.png" /></a> &nbsp; <a href="pricemaster.php?edm=del&del=dels&icode='.$rowk["item_code"].'" class="ask"><img src="img/delete.jpg" /></a></td></tr>';;
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
